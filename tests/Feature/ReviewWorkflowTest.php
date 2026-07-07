<?php

namespace Tests\Feature;

use App\Models\Batch;
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
use App\Models\Pembeli;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression test for the review workflow that happens after an IBK user
 * submits a form: PHD reviews it first (approve -> "Dihantar ke IPJPSM", or
 * reject -> "Tidak Lengkap"), then IPJPSM/BPE gives final certification
 * ("Lulus"). Also walks Form C's monthly progression from January through
 * July for each shuttle, including the Q2 (April) and Q3 (July) quarter
 * boundaries, to prove the whole submit -> verify -> certify cycle holds up
 * over time, not just for a single month.
 */
class ReviewWorkflowTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function shuttle_3_forms_can_be_submitted_reviewed_and_certified_through_july()
    {
        $this->runReviewChain('3');
    }

    /** @test */
    public function shuttle_4_forms_can_be_submitted_reviewed_and_certified_through_july()
    {
        $this->runReviewChain('4');
    }

    /** @test */
    public function shuttle_5_forms_can_be_submitted_reviewed_and_certified_through_july()
    {
        $this->runReviewChain('5');
    }

    /** @test */
    public function phd_can_reject_form_c_and_ibk_can_then_refill_and_resubmit_it()
    {
        $shuttleType = '3';
        $user = $this->makeIbkUser($shuttleType);
        $shuttle = $user->shuttle;
        $phd = $this->makeReviewerUser('PHD');

        $this->fillFormA($user, $shuttle, $shuttleType);
        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 1);

        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 1)->first();

        // PHD rejects it.
        $this->actingAs($phd)->post(route('update_status_form3C', $formc->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila perbetulkan data KKB.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formc->refresh();
        $this->assertSame('Tidak Lengkap', $formc->status, 'Form C should be marked Tidak Lengkap after PHD rejects it.');

        // IBK must still be able to open and resubmit it (the whole point of "Tidak Lengkap").
        $this->actingAs($user)
            ->get(route('user.view.shuttle-3-formC.KKB', [1, self::YEAR]))
            ->assertOk();

        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 1);

        $formc->refresh();
        $this->assertNotSame('Tidak Lengkap', $formc->status, 'Form C should have moved out of Tidak Lengkap once IBK resubmits it.');

        // PHD approves this time, then IPJPSM/BPE certifies it.
        $this->actingAs($phd)->post(route('update_status_form3C', $formc->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data sudah betul.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formc->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formc->status);

        $bpe = $this->makeReviewerUser('BPE');
        $this->actingAs($bpe)->post(route('update_status_form3C_ipjpsm', $formc->id), [
            'status' => 'Lulus',
            'ulasan_ipjpsm' => 'Diperaku.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formc->refresh();
        $this->assertSame('Lulus', $formc->status, 'Form C should be Lulus after IPJPSM certifies it.');
    }

    private function runReviewChain(string $shuttleType): void
    {
        $user = $this->makeIbkUser($shuttleType);
        $shuttle = $user->shuttle;
        $phd = $this->makeReviewerUser('PHD');
        $bpe = $this->makeReviewerUser('BPE');

        // ── Form A: fill -> PHD approve -> IPJPSM certify ──────────────────
        $this->fillFormA($user, $shuttle, $shuttleType);
        $formA = FormA::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->first();

        $this->actingAs($phd)->post(route('update_status_form3A', $formA->id), [
            'ulasan_phd' => 'Maklumat lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formA->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formA->status, "Shuttle {$shuttleType} Form A should move to Dihantar ke IPJPSM after PHD approves.");

        // update_status_ipjpsm3A's {id} route param is the SHUTTLE id, not the FormA id.
        $this->actingAs($bpe)->post(route('update_status_form3A_ipjpsm', $shuttle->id), [
            'status' => 'Lulus',
            'tahun' => self::YEAR,
            'nilai_harta' => '100000',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formA->refresh();
        $this->assertSame('Lulus', $formA->status, "Shuttle {$shuttleType} Form A should be Lulus after IPJPSM certifies it.");

        // ── Form B Q1, then Form C for Jan/Feb/Mar -> PHD -> IPJPSM ────────
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 1);
        foreach ([1, 2, 3] as $bulan) {
            $this->fillFormCForMonth($user, $shuttle, $shuttleType, $bulan);
            $this->reviewAndCertifyFormC($shuttle, $shuttleType, $bulan, $phd, $bpe);

            if ($bulan === 1) {
                // ── Form D (and Form E for shuttle 4/5) -> PHD -> IPJPSM ───
                $this->fillReviewAndCertifyFormD($user, $shuttle, $shuttleType, $bulan, $phd, $bpe);
                if (in_array($shuttleType, ['4', '5'], true)) {
                    $this->fillReviewAndCertifyFormE($user, $shuttle, $shuttleType, $bulan, $phd, $bpe);
                }
            }
        }

        // ── Form B Q2 (unlocks April), then Form C for Apr/May/Jun ─────────
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 2);
        foreach ([4, 5, 6] as $bulan) {
            $this->fillFormCForMonth($user, $shuttle, $shuttleType, $bulan);
            $this->reviewAndCertifyFormC($shuttle, $shuttleType, $bulan, $phd, $bpe);
        }

        // ── Form B Q3 (unlocks July) ────────────────────────────────────────
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 3);
        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 7);
        $this->reviewAndCertifyFormC($shuttle, $shuttleType, 7, $phd, $bpe);
    }

    private function reviewAndCertifyFormC($shuttle, string $shuttleType, int $bulan, User $phd, User $bpe): void
    {
        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
        $this->assertNotNull($formc, "Shuttle {$shuttleType} bulan={$bulan}: FormC row missing before review.");

        $this->actingAs($phd)->post(route('update_status_form3C', $formc->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data lengkap dan betul.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formc->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formc->status,
            "Shuttle {$shuttleType} bulan={$bulan}: Form C should move to Dihantar ke IPJPSM after PHD approves.");

        $this->actingAs($bpe)->post(route('update_status_form3C_ipjpsm', $formc->id), [
            'status' => 'Lulus',
            'ulasan_ipjpsm' => 'Diperaku.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        $formc->refresh();
        $this->assertSame('Lulus', $formc->status,
            "Shuttle {$shuttleType} bulan={$bulan}: Form C should be Lulus after IPJPSM certifies it.");
    }

    private function fillReviewAndCertifyFormD($user, $shuttle, string $shuttleType, int $bulan, User $phd, User $bpe): void
    {
        if ($shuttleType === '3') {
            FormD::create([
                'shuttle_id' => $shuttle->id, 'shuttle_type' => '3',
                'tahun' => self::YEAR, 'bulan' => $bulan, 'status' => 'Tidak Diisi',
            ]);
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
            $this->assertNotNull($formD);
            $this->assertNotSame('Tidak Diisi', $formD->status, "Shuttle 3 Form D should no longer be Tidak Diisi after filling.");

            $this->actingAs($phd)->post(route('update_status_form3D', $formD->id), [
                'status' => 'Dihantar ke IPJPSM',
                'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $formD->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $formD->status, "Shuttle 3 Form D should move to Dihantar ke IPJPSM after PHD approves.");

            $this->actingAs($bpe)->post(route('update_status_form3D_ipjpsm', $formD->id), [
                'status' => 'Lulus',
                'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $formD->refresh();
            $this->assertSame('Lulus', $formD->status, "Shuttle 3 Form D should be Lulus after IPJPSM certifies it.");
        } elseif ($shuttleType === '4') {
            Form4D::create([
                'shuttle_id' => $shuttle->id, 'shuttle_type' => '4',
                'tahun' => self::YEAR, 'bulan' => $bulan, 'status' => 'Tidak Diisi',
            ]);
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
            $this->assertNotNull($form4d);
            $this->assertNotSame('Tidak Diisi', $form4d->status, "Shuttle 4 Form D should no longer be Tidak Diisi after filling.");

            $this->actingAs($phd)->post(route('update_status_form4D', $form4d->id), [
                'status' => 'Dihantar ke IPJPSM',
                'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4d->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form4d->status, "Shuttle 4 Form D should move to Dihantar ke IPJPSM after PHD approves.");

            $this->actingAs($bpe)->post(route('update_status_form4D_ipjpsm', $form4d->id), [
                'status' => 'Lulus',
                'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4d->refresh();
            $this->assertSame('Lulus', $form4d->status, "Shuttle 4 Form D should be Lulus after IPJPSM certifies it.");
        } else {
            Form5D::create([
                'shuttle_id' => $shuttle->id, 'shuttle_type' => '5',
                'tahun' => self::YEAR, 'bulan' => $bulan, 'status' => 'Tidak Diisi',
            ]);
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
            $this->assertNotNull($form5d);
            $this->assertNotSame('Tidak Diisi', $form5d->status, "Shuttle 5 Form D should no longer be Tidak Diisi after filling.");

            $this->actingAs($phd)->post(route('update_status_form5D', $form5d->id), [
                'status' => 'Dihantar ke IPJPSM',
                'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5d->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form5d->status, "Shuttle 5 Form D should move to Dihantar ke IPJPSM after PHD approves.");

            $this->actingAs($bpe)->post(route('update_status_form5D_ipjpsm', $form5d->id), [
                'status' => 'Lulus',
                'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5d->refresh();
            $this->assertSame('Lulus', $form5d->status, "Shuttle 5 Form D should be Lulus after IPJPSM certifies it.");
        }
    }

    private function fillReviewAndCertifyFormE($user, $shuttle, string $shuttleType, int $bulan, User $phd, User $bpe): void
    {
        if ($shuttleType === '4') {
            Form4E::create([
                'shuttle_id' => $shuttle->id, 'shuttle_type' => '4',
                'tahun' => self::YEAR, 'bulan' => $bulan, 'status' => 'Tidak Diisi',
            ]);
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
            $this->assertNotNull($form4e);
            $this->assertNotSame('Tidak Diisi', $form4e->status, "Shuttle 4 Form E should no longer be Tidak Diisi after filling.");

            $this->actingAs($phd)->post(route('update_status_form4E', $form4e->id), [
                'status' => 'Dihantar ke IPJPSM',
                'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4e->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form4e->status, "Shuttle 4 Form E should move to Dihantar ke IPJPSM after PHD approves.");

            $this->actingAs($bpe)->post(route('update_status_form4E_ipjpsm', $form4e->id), [
                'status' => 'Lulus',
                'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form4e->refresh();
            $this->assertSame('Lulus', $form4e->status, "Shuttle 4 Form E should be Lulus after IPJPSM certifies it.");
        } else {
            Form5E::create([
                'shuttle_id' => $shuttle->id, 'shuttle_type' => '5',
                'tahun' => self::YEAR, 'bulan' => $bulan, 'status' => 'Tidak Diisi',
            ]);
            $this->actingAs($user)->get(route('user.shuttle-5-formE', [self::YEAR, $bulan]))->assertOk();

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFive\FormE::class, ['bulan_id' => $bulan])
                ->set('jumlah_jualan_pasaran_tempatan', 100)
                ->set('jumlah_jualan_eksport', 50)
                ->call('store')
                ->assertHasNoErrors();

            $form5e = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($form5e);
            $this->assertNotSame('Tidak Diisi', $form5e->status, "Shuttle 5 Form E should no longer be Tidak Diisi after filling.");

            $this->actingAs($phd)->post(route('update_status_form5E', $form5e->id), [
                'status' => 'Dihantar ke IPJPSM',
                'ulasan_phd' => 'Data lengkap.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5e->refresh();
            $this->assertSame('Dihantar ke IPJPSM', $form5e->status, "Shuttle 5 Form E should move to Dihantar ke IPJPSM after PHD approves.");

            $this->actingAs($bpe)->post(route('update_status_form5E_ipjpsm', $form5e->id), [
                'status' => 'Lulus',
                'ulasan_ipjpsm' => 'Diperaku.',
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
            $form5e->refresh();
            $this->assertSame('Lulus', $form5e->status, "Shuttle 5 Form E should be Lulus after IPJPSM certifies it.");
        }
    }

    // ── Shared fill/user helpers (same conventions as FullFormChainTest) ──

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

    private function fillFormCForMonth(User $user, $shuttle, string $shuttleType, int $bulan): void
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
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = 10 + $s->id;
            }
            $zeroFill = array_fill(0, $count, 0);

            $response = $this->actingAs($user)->post(route("user.view.{$prefix}.{$stage['route']}.store", [$bulan, self::YEAR]), [
                'baki_stoks' => $zeroFill,
                'kayu_masuk' => $kayuMasuk,
                'jumlah_stok_kayu_balak' => $kayuMasuk,
                'proses_masuk' => $zeroFill,
                'proses_keluar' => $zeroFill,
                'baki_stok_kehadapan' => $kayuMasuk,
                'jumlah_baki_stok' => $zeroFill,
                'jumlah_kayu_masuk' => $zeroFill,
                'total_stok_kayu_balak' => $zeroFill,
                'total_kayu_masuk_jentera' => $zeroFill,
                'total_kayu_keluar_jentera' => $zeroFill,
                'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
                'jumlah_besar_baki_stok_bulan_lepas' => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0,
                'jumlah_besar_kayu_ke_dalam_jentera' => 500,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ]);
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();
        }
    }

    private function fillFormBForQuarter(User $user, $shuttle, string $shuttleType, int $suku): void
    {
        $viewRoute = "user.shuttle-{$shuttleType}-formB";
        $this->actingAs($user)->get(route($viewRoute, [$suku, self::YEAR]))->assertOk();

        $namespace = [
            '3' => \App\Http\Livewire\ShuttleThree\FormB::class,
            '4' => \App\Http\Livewire\ShuttleFour\FormB::class,
            '5' => \App\Http\Livewire\ShuttleFive\FormB::class,
        ][$shuttleType];

        \Livewire\Livewire::actingAs($user)
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
