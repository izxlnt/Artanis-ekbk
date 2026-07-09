<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\HakMilik;
use App\Models\JenisKayu;
use App\Models\KemasukanBahan;
use App\Models\Pembeli;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * The full journey, per shuttle, under the confirmed production configuration
 * (2026-only data, buffer rules OFF until further notice):
 *
 *   Form A  fill -> PHD approve -> IPJPSM/BPE certify (Lulus)
 *   Form B  Q1 fill
 *   Form C  month 1: every kayu group filled with a DISTINCT value per
 *           species, then every single species row read back and asserted
 *           -> PHD rejects (Tidak Lengkap) -> IBK refills with NEW distinct
 *           per-species values -> every row re-verified (updated, not stale)
 *           -> PHD approves -> BPE certifies (Lulus)
 *   Form C  month 2: filled with carried-over opening stock, re-verified
 *           per species
 *   Form D  fill -> PHD approve -> BPE certify
 *   Form E  (shuttle 4/5) fill -> PHD approve -> BPE certify
 */
class FullSystemPerSpeciesE2ETest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    // Distinct, non-overlapping value bases so a value can never "accidentally
    // match" across rounds/fields: value = BASE + species id.
    private const R1_MASUK = 1000;   // month 1, first fill
    private const R1_CLOSE = 2000;
    private const R2_MASUK = 5000;   // month 1, refill after PHD rejection
    private const R2_CLOSE = 6000;
    private const M2_MASUK = 7000;   // month 2

    /** @test */
    public function shuttle_3_full_journey_with_per_species_verification_and_resubmission()
    {
        $this->runFullJourney('3');
    }

    /** @test */
    public function shuttle_4_full_journey_with_per_species_verification_and_resubmission()
    {
        $this->runFullJourney('4');
    }

    /** @test */
    public function shuttle_5_full_journey_with_per_species_verification_and_resubmission()
    {
        $this->runFullJourney('5');
    }

    private function runFullJourney(string $shuttleType): void
    {
        $user = $this->makeIbkUser($shuttleType);
        $shuttle = $user->shuttle;
        $phd = $this->makeReviewerUser('PHD');
        $bpe = $this->makeReviewerUser('BPE');

        // Pin the confirmed production configuration: buffer rules OFF for
        // every borang of this shuttle (rolled back by the test transaction).
        foreach (['B', 'C', 'D', 'E'] as $borang) {
            Buffer::updateOrCreate(
                ['shuttle' => $shuttleType, 'borang' => $borang],
                ['delay' => 0, 'aktif' => 0]
            );
        }

        // ── Form A: fill -> PHD approve -> BPE certify ─────────────────────
        $this->fillFormA($user, $shuttle, $shuttleType);
        $formA = FormA::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->first();

        $this->actingAs($phd)->post(route('update_status_form3A', $formA->id), [
            'ulasan_phd' => 'Maklumat lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formA->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formA->status);

        $this->actingAs($bpe)->post(route('update_status_form3A_ipjpsm', $shuttle->id), [
            'status' => 'Lulus', 'tahun' => self::YEAR, 'nilai_harta' => '100000',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formA->refresh();
        $this->assertSame('Lulus', $formA->status, "Shuttle {$shuttleType}: Form A must be Lulus after certification.");

        // ── Form B Q1 ──────────────────────────────────────────────────────
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 1);

        // ── Form C month 1: fill + verify every species ────────────────────
        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 1, self::R1_MASUK, self::R1_CLOSE);
        $this->assertEverySpeciesRow($shuttle, $shuttleType, 1, self::R1_MASUK, self::R1_CLOSE, 'first fill');

        $formc1 = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertContains($formc1->status, \App\Services\FormFlowService::SUBMITTED,
            "Shuttle {$shuttleType}: month-1 Form C must be submitted after filling.");

        // ── PHD rejects -> IBK refills -> verify values UPDATED ────────────
        $this->actingAs($phd)->post(route('update_status_form3C', $formc1->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila semak semula data spesies.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formc1->refresh();
        $this->assertSame('Tidak Lengkap', $formc1->status);

        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 1, self::R2_MASUK, self::R2_CLOSE);
        $this->assertEverySpeciesRow($shuttle, $shuttleType, 1, self::R2_MASUK, self::R2_CLOSE, 'refill after rejection');

        $formc1->refresh();
        $this->assertNotSame('Tidak Lengkap', $formc1->status,
            "Shuttle {$shuttleType}: month-1 Form C must leave Tidak Lengkap after resubmission.");

        // ── PHD approves the resubmission -> BPE certifies ─────────────────
        $this->actingAs($phd)->post(route('update_status_form3C', $formc1->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data sudah betul.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formc1->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formc1->status);

        $this->actingAs($bpe)->post(route('update_status_form3C_ipjpsm', $formc1->id), [
            'status' => 'Lulus', 'ulasan_ipjpsm' => 'Diperaku.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formc1->refresh();
        $this->assertSame('Lulus', $formc1->status, "Shuttle {$shuttleType}: month-1 Form C must be Lulus after certification.");

        // ── Form C month 2: opening stock carried from month 1's closing ───
        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 2, self::M2_MASUK, 0, self::R2_CLOSE);
        $formc2 = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 2)->first();
        $this->assertNotNull($formc2);

        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        foreach ($species as $s) {
            $row = KemasukanBahan::where('formcs_id', $formc2->id)->where('spesis_id', $s->id)->first();
            $this->assertNotNull($row, "Shuttle {$shuttleType} month 2: species {$s->id} ({$s->nama_spesis}) row missing.");
            $this->assertEquals(self::R2_CLOSE + $s->id, (float) $row->baki_stok,
                "Shuttle {$shuttleType} month 2: species {$s->id} opening stock must equal month 1's closing stock for that exact species.");
            $this->assertEquals(self::M2_MASUK + $s->id, (float) $row->kayu_masuk,
                "Shuttle {$shuttleType} month 2: species {$s->id} kayu_masuk mismatch.");
        }

        // ── Form D -> PHD -> BPE ───────────────────────────────────────────
        $this->fillReviewAndCertifyFormD($user, $shuttle, $shuttleType, 1, $phd, $bpe);

        // ── Form E (shuttle 4/5 only) -> PHD -> BPE ────────────────────────
        if (in_array($shuttleType, ['4', '5'], true)) {
            $this->fillReviewAndCertifyFormE($user, $shuttle, $shuttleType, 1, $phd, $bpe);
        }
    }

    /**
     * Read back EVERY species row for the month and assert its two key values
     * are exactly the ones submitted for that specific species — this is the
     * strongest possible guard against the original species-swap bug.
     */
    private function assertEverySpeciesRow($shuttle, string $shuttleType, int $bulan, int $masukBase, int $closeBase, string $stage): void
    {
        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
        $this->assertNotNull($formc);

        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        $this->assertGreaterThan(0, $species->count());

        foreach ($species as $s) {
            $row = KemasukanBahan::where('formcs_id', $formc->id)->where('spesis_id', $s->id)->first();
            $this->assertNotNull($row,
                "Shuttle {$shuttleType} bulan {$bulan} ({$stage}): species {$s->id} ({$s->nama_spesis}) has no KemasukanBahan row.");
            $this->assertEquals($masukBase + $s->id, (float) $row->kayu_masuk,
                "Shuttle {$shuttleType} bulan {$bulan} ({$stage}): species {$s->id} ({$s->nama_spesis}) kayu_masuk belongs to the wrong species.");
            $this->assertEquals($closeBase + $s->id, (float) $row->baki_stok_kehadapan,
                "Shuttle {$shuttleType} bulan {$bulan} ({$stage}): species {$s->id} ({$s->nama_spesis}) closing stock belongs to the wrong species.");
        }

        // Exactly one row per species — no duplicates, none missing.
        $rowCount = KemasukanBahan::where('formcs_id', $formc->id)->count();
        $this->assertSame($species->count(), $rowCount,
            "Shuttle {$shuttleType} bulan {$bulan} ({$stage}): expected exactly one row per species.");
    }

    // ── Fill helpers ───────────────────────────────────────────────────────

    private function fillFormCForMonth(User $user, $shuttle, string $shuttleType, int $bulan, int $masukBase, int $closeBase, int $bakiBase = 0): void
    {
        $prefix = "shuttle-{$shuttleType}-formC";

        Batch::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['status' => 'Sedang Diproses', 'borang_a' => 1]
        );
        FormC::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['shuttle_type' => $shuttleType, 'status' => 'Tidak Diisi']
        );

        $stages = [
            ['kayu_id' => 1, 'route' => 'KKB'],
            ['kayu_id' => 2, 'route' => 'KKS'],
            ['kayu_id' => 3, 'route' => 'KKR'],
            ['kayu_id' => 4, 'route' => 'KayuLembut'],
            ['kayu_id' => 5, 'route' => 'LainLain'],
        ];

        foreach ($stages as $stage) {
            $this->actingAs($user)->get(route("user.view.{$prefix}.{$stage['route']}", [$bulan, self::YEAR]))->assertOk();

            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $stage['kayu_id'])->get()->values();
            $count = $species->count();
            $kayuMasuk = [];
            $closing = [];
            $baki = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = $masukBase + $s->id;
                $closing[$i] = $closeBase > 0 ? $closeBase + $s->id : 0;
                $baki[$i] = $bakiBase > 0 ? $bakiBase + $s->id : 0;
            }
            $zeroFill = array_fill(0, $count, 0);

            $response = $this->actingAs($user)->post(route("user.view.{$prefix}.{$stage['route']}.store", [$bulan, self::YEAR]), [
                'baki_stoks' => $baki,
                'kayu_masuk' => $kayuMasuk,
                'jumlah_stok_kayu_balak' => $kayuMasuk,
                'proses_masuk' => $zeroFill,
                'proses_keluar' => $zeroFill,
                'baki_stok_kehadapan' => $closing,
                'jumlah_baki_stok' => $zeroFill,
                'jumlah_kayu_masuk' => $zeroFill,
                'total_stok_kayu_balak' => $zeroFill,
                'total_kayu_masuk_jentera' => $zeroFill,
                'total_kayu_keluar_jentera' => $zeroFill,
                'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
                'jumlah_besar_baki_stok_bulan_lepas' => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0,
                // Non-zero so shuttle 4's Form D recovery-rate check has a
                // valid production range to validate against.
                'jumlah_besar_kayu_ke_dalam_jentera' => 500,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ]);
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();
        }
    }

    private function fillReviewAndCertifyFormD($user, $shuttle, string $shuttleType, int $bulan, User $phd, User $bpe): void
    {
        if ($shuttleType === '3') {
            FormD::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '3', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-3-formD', [self::YEAR, $bulan]))->assertOk();

            $jumlahJualan = [];
            foreach (Pembeli::where('shuttle', 3)->get() as $i => $p) {
                $jumlahJualan[$i] = 100;
            }

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleThree\FormD::class, ['year' => self::YEAR, 'bulan_id' => $bulan])
                ->set('total_export', 500)
                ->set('jumlah_jualan', $jumlahJualan)
                ->call('store')
                ->assertHasNoErrors();

            $formD = FormD::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotSame('Tidak Diisi', $formD->status);

            $this->actingAs($phd)->post(route('update_status_form3D', $formD->id), [
                'status' => 'Dihantar ke IPJPSM', 'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $formD->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $formD->status);

            $this->actingAs($bpe)->post(route('update_status_form3D_ipjpsm', $formD->id), [
                'status' => 'Lulus', 'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $formD->refresh();
            $this->assertSame('Lulus', $formD->status, 'Shuttle 3 Form D must be Lulus after certification.');
        } elseif ($shuttleType === '4') {
            Form4D::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '4', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-4-formD', [self::YEAR, $bulan]))->assertOk();

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFour\FormD::class, ['bulan_id' => $bulan])
                ->set('rekod_veniermuka', 50)
                ->set('rekod_venierteras', 50)
                ->set('produk_isipadumr_a.0', 1)
                ->set('produk_isipaduwbp_a.0', 1)
                ->set('produk_ketebalan_a.0', 5)
                ->set('produk_isipadumr_b.0', 1)
                ->set('produk_isipaduwbp_b.0', 1)
                ->set('produk_ketebalan_b.0', 12)
                ->call('store')
                ->assertHasNoErrors();

            $form4d = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotSame('Tidak Diisi', $form4d->status);

            $this->actingAs($phd)->post(route('update_status_form4D', $form4d->id), [
                'status' => 'Dihantar ke IPJPSM', 'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4d->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form4d->status);

            $this->actingAs($bpe)->post(route('update_status_form4D_ipjpsm', $form4d->id), [
                'status' => 'Lulus', 'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4d->refresh();
            $this->assertSame('Lulus', $form4d->status, 'Shuttle 4 Form D must be Lulus after certification.');
        } else {
            Form5D::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '5', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-5-formD', [self::YEAR, $bulan]))->assertOk();

            $pengeluaranKayu = [];
            foreach (JenisKayu::all() as $i => $j) {
                $pengeluaranKayu[$i] = 0;
            }

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFive\FormD::class, ['bulan_id' => $bulan])
                ->set('total_jumlah_pengeluaran', 0)
                ->set('pengeluaran_kayu', $pengeluaranKayu)
                ->call('store')
                ->assertHasNoErrors();

            $form5d = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotSame('Tidak Diisi', $form5d->status);

            $this->actingAs($phd)->post(route('update_status_form5D', $form5d->id), [
                'status' => 'Dihantar ke IPJPSM', 'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5d->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form5d->status);

            $this->actingAs($bpe)->post(route('update_status_form5D_ipjpsm', $form5d->id), [
                'status' => 'Lulus', 'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5d->refresh();
            $this->assertSame('Lulus', $form5d->status, 'Shuttle 5 Form D must be Lulus after certification.');
        }
    }

    private function fillReviewAndCertifyFormE($user, $shuttle, string $shuttleType, int $bulan, User $phd, User $bpe): void
    {
        if ($shuttleType === '4') {
            Form4E::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '4', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-4-formE', [self::YEAR, $bulan]))->assertOk();

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFour\FormE::class, ['bulan_id' => $bulan])
                ->set('total_export', 200)
                ->set('jumlah_pasaran_tempatan', 100)
                ->set('jumlah_venier_eksport', 50)
                ->set('jumlah_venier_tempatan', 25)
                ->call('store')
                ->assertHasNoErrors();

            $form4e = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotSame('Tidak Diisi', $form4e->status);

            $this->actingAs($phd)->post(route('update_status_form4E', $form4e->id), [
                'status' => 'Dihantar ke IPJPSM', 'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4e->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form4e->status);

            $this->actingAs($bpe)->post(route('update_status_form4E_ipjpsm', $form4e->id), [
                'status' => 'Lulus', 'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4e->refresh();
            $this->assertSame('Lulus', $form4e->status, 'Shuttle 4 Form E must be Lulus after certification.');
        } else {
            Form5E::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '5', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-5-formE', [self::YEAR, $bulan]))->assertOk();

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFive\FormE::class, ['bulan_id' => $bulan])
                ->set('jumlah_jualan_pasaran_tempatan', 100)
                ->set('jumlah_jualan_eksport', 50)
                ->call('store')
                ->assertHasNoErrors();

            $form5e = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotSame('Tidak Diisi', $form5e->status);

            $this->actingAs($phd)->post(route('update_status_form5E', $form5e->id), [
                'status' => 'Dihantar ke IPJPSM', 'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5e->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form5e->status);

            $this->actingAs($bpe)->post(route('update_status_form5E_ipjpsm', $form5e->id), [
                'status' => 'Lulus', 'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5e->refresh();
            $this->assertSame('Lulus', $form5e->status, 'Shuttle 5 Form E must be Lulus after certification.');
        }
    }

    // ── User / Form A / Form B helpers (same conventions as ReviewWorkflowTest) ──

    private function makeIbkUser(string $shuttleType): User
    {
        RecoveryRate::firstOrCreate(
            ['shuttle_type' => $shuttleType],
            ['min_recovery_rate' => 0.15, 'max_recovery_rate' => 0.99]
        );

        $user = User::factory()->create([
            'kategori_pengguna' => 'IBK',
            'status' => 1,
            'is_approved' => 1,
        ]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();

        return $user->fresh();
    }

    private function makeReviewerUser(string $kategoriPengguna): User
    {
        $unique = uniqid();

        return User::create([
            'name' => $kategoriPengguna . ' Reviewer',
            'email' => strtolower($kategoriPengguna) . '-' . $unique . '@example.com',
            'login_id' => strtolower($kategoriPengguna) . '-' . $unique,
            'password' => Hash::make('password'),
            'kategori_pengguna' => $kategoriPengguna,
            'status' => 1,
            'is_approved' => 1,
        ]);
    }

    private function fillFormA(User $user, $shuttle, string $shuttleType): void
    {
        $hakMilik = HakMilik::first();

        $this->actingAs($user)->get(route("user.shuttle-{$shuttleType}-formA"))->assertOk();

        $response = $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ]);
        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    private function fillFormBForQuarter(User $user, $shuttle, string $shuttleType, int $suku): void
    {
        $this->actingAs($user)->get(route("user.shuttle-{$shuttleType}-formB", [$suku, self::YEAR]))->assertOk();

        $namespace = [
            '3' => \App\Http\Livewire\ShuttleThree\FormB::class,
            '4' => \App\Http\Livewire\ShuttleFour\FormB::class,
            '5' => \App\Http\Livewire\ShuttleFive\FormB::class,
        ][$shuttleType];

        Livewire::actingAs($user)
            ->test($namespace, ['year' => self::YEAR, 'suku_id' => $suku])
            ->set('pekerja_wargabumi_lelaki.0', 1)
            ->set('gaji_lelaki.0', 5000)
            ->call('store')
            ->assertHasNoErrors();

        $formB = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', $suku)->first();
        $this->assertNotNull($formB);
        $this->assertNotSame('Tidak Diisi', $formB->status);
    }
}
