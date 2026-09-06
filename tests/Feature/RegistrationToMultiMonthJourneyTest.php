<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Daerah;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormD;
use App\Models\HakMilik;
use App\Models\JenisKayu;
use App\Models\KategoriGunaTenaga;
use App\Models\KemasukanBahan;
use App\Models\Pembeli;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * REAL-FLOW test: register a brand new factory through the actual public
 * registration form (POST /register, real file uploads), approve it through
 * the real IPJPSM approval action (which is also what seeds the year's
 * Batch/FormA/FormB rows in production), then have the newly-created IBK
 * sub-user fill Form A -> B -> C -> D(/E) with randomized data across 4
 * consecutive months, for every shuttle type.
 *
 * This exists to catch gaps that fixture-built users can hide: the owner
 * vs sub-user split, the approval-time provisioning step, and month-to-month
 * carry-forward starting from a genuinely empty history.
 */
class RegistrationToMultiMonthJourneyTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const MONTHS = [1, 2, 3, 4];

    /** @test */
    public function shuttle_3_registers_and_fills_four_months_with_random_data()
    {
        $this->runJourney('3');
    }

    /** @test */
    public function shuttle_4_registers_and_fills_four_months_with_random_data()
    {
        $this->runJourney('4');
    }

    /** @test */
    public function shuttle_5_registers_and_fills_four_months_with_random_data()
    {
        $this->runJourney('5');
    }

    private function runJourney(string $shuttleType): void
    {
        [$user, $shuttle] = $this->registerAndApprove($shuttleType);

        $this->fillFormA($user, $shuttle);

        $filledSpecies = []; // month => [spesis_id => kayu_masuk value submitted]

        foreach (self::MONTHS as $bulan) {
            $suku = (int) ceil($bulan / 3);
            if ($bulan === ($suku - 1) * 3 + 1 && $suku >= 1) {
                // First month of a new quarter: fill that quarter's Form B first,
                // since Form C requires the *previous* quarter's Form B submitted
                // (and quarter 1 has no prior requirement).
                if ($suku === 1 || $this->formBSubmitted($shuttle, $suku - 1)) {
                    $this->fillFormB($user, $shuttle, $suku);
                }
            }

            $filledSpecies[$bulan] = $this->fillFormC($user, $shuttle, $shuttleType, $bulan);
            $this->fillFormDAndE($user, $shuttle, $shuttleType, $bulan);
        }

        // ── Final correctness pass: every month's species values are exactly
        // what was submitted for that month, and months never bled into
        // each other. ────────────────────────────────────────────────────
        foreach (self::MONTHS as $bulan) {
            $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($formc, "Month {$bulan}: FormC row missing.");

            foreach ($filledSpecies[$bulan] as $spesisId => $expected) {
                $row = KemasukanBahan::where('formcs_id', $formc->id)->where('spesis_id', $spesisId)->first();
                $this->assertNotNull($row, "Shuttle {$shuttleType} month {$bulan}: species {$spesisId} row missing.");
                $this->assertEquals($expected, (float) $row->kayu_masuk,
                    "Shuttle {$shuttleType} month {$bulan}: species {$spesisId} kayu_masuk drifted from what was submitted.");
            }
        }
    }

    // ── Registration + approval ─────────────────────────────────────────

    private function registerAndApprove(string $shuttleType): array
    {
        $unique = $shuttleType . '-' . Str::random(6) . '-' . now()->timestamp;
        $daerah = Daerah::inRandomOrder()->first();
        $this->assertNotNull($daerah, 'Daerah lookup table must be seeded.');
        $hakMilik = HakMilik::inRandomOrder()->first();
        $this->assertNotNull($hakMilik, 'HakMilik lookup table must be seeded.');

        // ->create() (not ->image()) - ->image() needs the GD extension, which
        // isn't available in this environment; ->create() with an explicit
        // mimeType satisfies the 'image'/'mimes:jpeg,jpg,png' validation rules
        // without needing to render real image bytes.
        $fakeImage = fn () => UploadedFile::fake()->create('doc.jpg', 50, 'image/jpeg');

        $response = $this->post(route('register'), [
            'name' => 'Test Pengguna ' . $unique,
            'email' => "sub-{$unique}@example.test",
            'email_kilang' => "kilang-{$unique}@example.test",
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'jawatan' => 'Pengurus',
            'jantina' => 'Lelaki',
            'warganegara' => 'Malaysia',
            'kaum' => 'Melayu',
            // Valid Malaysian IC shape per App\Rules\MalaysianIC: YYMMDD + birthplace
            // (01-16/21-59/82-83) + 4 free digits (gender+check, unvalidated here).
            'no_kad_pengenalan' => '900115' . '14' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT),
            'gambar_ic_hadapan' => $fakeImage(),
            'gambar_ic_belakang' => $fakeImage(),
            'gambar_passport' => $fakeImage(),
            'shuttle_type' => $shuttleType,
            'tahun' => (string) self::YEAR,
            'negeri_id' => (string) $daerah->id,
            'daerah_id' => (string) $daerah->id,
            'nama_kilang' => 'Kilang Ujian ' . $unique,
            'alamat_kilang_1' => 'No. 1, Jalan Ujian',
            'alamat_kilang_poskod' => '50000',
            'alamat_kilang_daerah' => $daerah->daerah_hutan,
            'alamat_sama' => '1',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM' . $unique,
            'tarikh_tubuh' => '2010-01-01',
            'tarikh_operasi' => '2010-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '500000',
            'no_lesen' => 'LESEN' . $unique,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
            'sijil_ssm' => $fakeImage(),
            'lesen_kilang' => $fakeImage(),
        ]);

        $response->assertSessionDoesntHaveErrors();
        $response->assertStatus(302);

        $shuttle = Shuttle::where('no_ssm', 'like', 'SSM' . $unique . '%')->first();
        $this->assertNotNull($shuttle, 'Registration must create a Shuttle row.');

        $pengguna = PenggunaKilang::where('email', "sub-{$unique}@example.test")->first();
        $this->assertNotNull($pengguna, 'Registration must create a PenggunaKilang row.');

        $subUser = User::where('pengguna_kilang_id', $pengguna->id)->first();
        $this->assertNotNull($subUser, 'Registration must create a sub-user account.');
        $this->assertSame(0, (int) $subUser->is_approved, 'A freshly registered user must start unapproved.');

        // ── IPJPSM (BPE) approves the sub-user - this is also what seeds
        // this year's Batch/FormA/FormB rows in the real system. ──────────
        $bpe = User::where('kategori_pengguna', 'BPE')->first();
        $this->assertNotNull($bpe, 'A BPE/IPJPSM user must exist to approve registrations.');

        $this->actingAs($bpe)->post(route('sahkan_permohonan_pengguna_ipjpsm', $pengguna->id))
            ->assertStatus(302)->assertSessionDoesntHaveErrors();

        $subUser->refresh();
        $this->assertSame(1, (int) $subUser->is_approved, 'Approval must flip is_approved to 1.');

        return [$subUser, $shuttle->fresh()];
    }

    // ── Form fillers (randomized inputs) ────────────────────────────────

    private function fillFormA(User $user, Shuttle $shuttle): void
    {
        $hakMilik = HakMilik::inRandomOrder()->first();

        $this->actingAs($user)->get(route("user.shuttle-{$user->shuttle_type}-formA"))->assertOk();

        $response = $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '01' . random_int(20000000, 99999999),
            'no_ssm' => $shuttle->no_ssm,
            'tarikh_tubuh' => '2010-01-01',
            'tarikh_operasi' => '2010-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => (string) random_int(50000, 900000),
            'email_kilang' => $shuttle->email,
            'no_lesen' => $shuttle->no_lesen,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ]);
        $response->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formA = FormA::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->first();
        $this->assertNotNull($formA);
        $this->assertNotSame('Tidak Diisi', $formA->status, 'Form A should no longer be Tidak Diisi after filling.');
    }

    private function formBSubmitted(Shuttle $shuttle, int $suku): bool
    {
        $formB = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', $suku)->first();
        return $formB && in_array($formB->status, \App\Services\FormFlowService::SUBMITTED, true);
    }

    private function fillFormB(User $user, Shuttle $shuttle, int $suku): void
    {
        $shuttleType = $user->shuttle_type;
        $viewRoute = "user.shuttle-{$shuttleType}-formB";
        $this->actingAs($user)->get(route($viewRoute, [$suku, self::YEAR]))->assertOk();

        $kategori = KategoriGunaTenaga::get();
        $lelaki = [];
        $gaji = [];
        foreach ($kategori as $i => $k) {
            $lelaki[$i] = random_int(1, 15);
            $gaji[$i] = random_int((int) $k->gaji_min, (int) $k->gaji_max);
        }

        $namespace = [
            '3' => \App\Http\Livewire\ShuttleThree\FormB::class,
            '4' => \App\Http\Livewire\ShuttleFour\FormB::class,
            '5' => \App\Http\Livewire\ShuttleFive\FormB::class,
        ][$shuttleType];

        $test = Livewire::actingAs($user)->test($namespace, ['year' => self::YEAR, 'suku_id' => $suku]);
        foreach ($lelaki as $i => $v) {
            $test->set("pekerja_wargabumi_lelaki.{$i}", $v)->set("gaji_lelaki.{$i}", $gaji[$i]);
        }
        $test->call('store');

        $formB = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', $suku)->first();
        $this->assertNotNull($formB);
        $this->assertNotSame('Tidak Diisi', $formB->status, "Shuttle {$shuttleType} Form B suku {$suku} should no longer be Tidak Diisi.");
    }

    /** @return array<int,float> spesis_id => submitted kayu_masuk value */
    private function fillFormC(User $user, Shuttle $shuttle, string $shuttleType, int $bulan): array
    {
        $prefix = "shuttle-{$shuttleType}-formC";
        $submitted = [];

        $stages = [
            ['kayu_id' => 1, 'route' => 'KKB'],
            ['kayu_id' => 2, 'route' => 'KKS'],
            ['kayu_id' => 3, 'route' => 'KKR'],
            ['kayu_id' => 4, 'route' => 'KayuLembut'],
            ['kayu_id' => 5, 'route' => 'LainLain'],
        ];

        foreach ($stages as $stage) {
            $this->actingAs($user)->get(route("user.view.{$prefix}.{$stage['route']}", [$bulan, self::YEAR]))->assertOk();

            $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->where('kumpulan_kayu_id', $stage['kayu_id'])->get()->values();
            $count = $species->count();
            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                // Randomized but deterministic-per-species value, offset by month
                // so re-filling a later month can never coincidentally match an
                // earlier one.
                $val = random_int(50, 500) + $bulan;
                $kayuMasuk[$i] = $val;
                $submitted[$s->id] = (float) $val;
            }
            $zeroFill = array_fill(0, $count, 0);

            // total_kayu_masuk_jentera[0] is what FormCController::refreshJumlahBesar
            // actually sums into jumlah_besar_kayu_ke_dalam_jentera (posting that
            // field directly gets overwritten) - only Lain-Lain sets it, kept
            // proportional to a modest downstream Form D/E production fill.
            $totalKayuMasukJentera = $zeroFill;
            if ($count > 0 && $stage['route'] === 'LainLain') {
                $totalKayuMasukJentera[0] = 500;
            }

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
                'total_kayu_masuk_jentera' => $totalKayuMasukJentera,
                'total_kayu_keluar_jentera' => $zeroFill,
                'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
                'jumlah_besar_baki_stok_bulan_lepas' => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0,
                'jumlah_besar_kayu_ke_dalam_jentera' => 0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ]);
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();
        }

        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
        $this->assertNotNull($formc);
        $this->assertContains($formc->status, \App\Services\FormFlowService::SUBMITTED,
            "Shuttle {$shuttleType} month {$bulan}: Form C must end in a submitted state.");

        return $submitted;
    }

    private function fillFormDAndE(User $user, Shuttle $shuttle, string $shuttleType, int $bulan): void
    {
        if ($shuttleType === '3') {
            FormD::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '3', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-3-formD', [self::YEAR, $bulan]))->assertOk();

            $jumlahJualan = [];
            foreach (Pembeli::where('shuttle', 3)->get() as $i => $p) {
                $jumlahJualan[$i] = random_int(10, 200);
            }

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleThree\FormD::class, ['year' => self::YEAR, 'bulan_id' => $bulan])
                ->set('total_export', random_int(50, 300))
                ->set('jumlah_jualan', $jumlahJualan)
                ->call('store');

            $formd = FormD::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($formd);
            $this->assertNotSame('Tidak Diisi', $formd->status, "Shuttle 3 month {$bulan}: Form D should no longer be Tidak Diisi.");
            return;
        }

        if ($shuttleType === '4') {
            Form4D::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '4', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-4-formD', [self::YEAR, $bulan]))->assertOk();

            // Keep production modest and proportional to the 500-unit jentera
            // total set in fillFormC, so the recovery-rate check (0.15-0.99 * 500)
            // passes: total must land in roughly [75, 495].
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
            $this->assertNotSame('Tidak Diisi', $form4d->status, "Shuttle 4 month {$bulan}: Form D should no longer be Tidak Diisi.");

            Form4E::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '4', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-4-formE', [self::YEAR, $bulan]))->assertOk();

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFour\FormE::class, ['bulan_id' => $bulan])
                ->set('total_export', random_int(50, 150))
                ->set('jumlah_pasaran_tempatan', random_int(50, 150))
                ->set('jumlah_venier_eksport', random_int(10, 60))
                ->set('jumlah_venier_tempatan', random_int(10, 60))
                ->call('store');

            $form4e = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($form4e);
            $this->assertNotSame('Tidak Diisi', $form4e->status, "Shuttle 4 month {$bulan}: Form E should no longer be Tidak Diisi.");
            return;
        }

        if ($shuttleType === '5') {
            Form5D::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '5', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-5-formD', [self::YEAR, $bulan]))->assertOk();

            $jenisKayu = JenisKayu::all();
            $pengeluaranKayu = [];
            foreach ($jenisKayu as $i => $j) {
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
            $this->assertNotSame('Tidak Diisi', $form5d->status, "Shuttle 5 month {$bulan}: Form D should no longer be Tidak Diisi.");

            Form5E::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => '5', 'status' => 'Tidak Diisi']
            );
            $this->actingAs($user)->get(route('user.shuttle-5-formE', [self::YEAR, $bulan]))->assertOk();

            Livewire::actingAs($user)
                ->test(\App\Http\Livewire\ShuttleFive\FormE::class, ['bulan_id' => $bulan])
                ->set('jumlah_jualan_pasaran_tempatan', random_int(50, 150))
                ->set('jumlah_jualan_eksport', random_int(10, 60))
                ->call('store');

            $form5e = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($form5e);
            $this->assertNotSame('Tidak Diisi', $form5e->status, "Shuttle 5 month {$bulan}: Form E should no longer be Tidak Diisi.");
        }
    }
}
