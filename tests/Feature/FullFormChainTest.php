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
use App\Models\KategoriGunaTenaga;
use App\Models\Pembeli;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * End-to-end regression test: fill every form in the real dependency chain
 * (A -> B -> C -> D -> E) for a single month, per shuttle type.
 *
 * This is a smoke test, not a deep field-by-field audit like the Form C
 * species-matching tests — the goal is to prove the whole journey a real
 * IBK user walks (register -> yearly profile -> quarterly headcount ->
 * monthly stock -> monthly production -> monthly sales) completes without
 * crashing and leaves each form in a submitted state, for every shuttle type.
 */
class FullFormChainTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const BULAN = 1;

    /** @test */
    public function shuttle_3_can_fill_form_a_through_d()
    {
        $user = $this->makeUser('3');
        $shuttle = $user->shuttle;

        $this->fillFormA($user, $shuttle, '3');
        $this->fillFormBShared($user, $shuttle);
        $this->fillFormCAllGroups($shuttle, '3');

        // Form D (shuttle 3 uses the generic FormD model + PenjualanPembeli buyers)
        FormD::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3',
            'tahun' => self::YEAR, 'bulan' => self::BULAN, 'status' => 'Tidak Diisi',
        ]);

        $this->get(route('user.shuttle-3-formD', [self::YEAR, self::BULAN]))->assertOk();

        $jenisPembeli = Pembeli::where('shuttle', 3)->get();
        $jumlahJualan = [];
        foreach ($jenisPembeli as $i => $p) {
            $jumlahJualan[$i] = 100;
        }

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleThree\FormD::class, ['year' => self::YEAR, 'bulan_id' => self::BULAN])
            ->set('total_export', 500)
            ->set('jumlah_jualan', $jumlahJualan)
            ->call('store');

        $formd = FormD::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', self::BULAN)->first();
        $this->assertNotNull($formd);
        $this->assertNotSame('Tidak Diisi', $formd->status, 'Shuttle 3 Form D should no longer be Tidak Diisi after filling.');
    }

    /** @test */
    public function shuttle_4_can_fill_form_a_through_e()
    {
        $user = $this->makeUser('4');
        $shuttle = $user->shuttle;

        $this->fillFormA($user, $shuttle, '4');
        $this->fillFormBShared($user, $shuttle);
        $this->fillFormCAllGroups($shuttle, '4');

        // Form D (shuttle 4 = plywood production, ProdukPengeluaran line items)
        Form4D::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '4',
            'tahun' => self::YEAR, 'bulan' => self::BULAN, 'status' => 'Tidak Diisi',
        ]);

        $this->get(route('user.shuttle-4-formD', [self::YEAR, self::BULAN]))->assertOk();

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleFour\FormD::class, ['bulan_id' => self::BULAN])
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

        $form4d = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', self::BULAN)->first();
        $this->assertNotNull($form4d);
        $this->assertNotSame('Tidak Diisi', $form4d->status, 'Shuttle 4 Form D should no longer be Tidak Diisi after filling.');

        // Form E (shuttle 4 = export/local-market wood-product totals, Pembeli-linked sales)
        Form4E::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '4',
            'tahun' => self::YEAR, 'bulan' => self::BULAN, 'status' => 'Tidak Diisi',
        ]);

        $this->get(route('user.shuttle-4-formE', [self::YEAR, self::BULAN]))->assertOk();

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleFour\FormE::class, ['bulan_id' => self::BULAN])
            ->set('total_export', 200)
            ->set('jumlah_pasaran_tempatan', 100)
            ->set('jumlah_venier_eksport', 50)
            ->set('jumlah_venier_tempatan', 25)
            ->call('store');

        $form4e = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', self::BULAN)->first();
        $this->assertNotNull($form4e);
        $this->assertNotSame('Tidak Diisi', $form4e->status, 'Shuttle 4 Form E should no longer be Tidak Diisi after filling.');
    }

    /** @test */
    public function shuttle_5_can_fill_form_a_through_e()
    {
        $user = $this->makeUser('5');
        $shuttle = $user->shuttle;

        $this->fillFormA($user, $shuttle, '5');
        $this->fillFormBShared($user, $shuttle);
        $this->fillFormCAllGroups($shuttle, '5');

        // Form D (shuttle 5 = per-JenisKayu production totals)
        Form5D::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5',
            'tahun' => self::YEAR, 'bulan' => self::BULAN, 'status' => 'Tidak Diisi',
        ]);

        $this->get(route('user.shuttle-5-formD', [self::YEAR, self::BULAN]))->assertOk();

        $jenisKayu = JenisKayu::all();
        // Form D's output must equal Form C's submitted proses_masuk total for
        // this shuttle/month (kemasukan_bahan_calc_lain_lain, which defaults to
        // 0 here since form_c_data isn't wired through in this test) — our
        // Form C fill also submitted proses_masuk=0 for every species, so 0 is
        // the correct, consistent value here too.
        $pengeluaranKayu = [];
        foreach ($jenisKayu as $i => $j) {
            $pengeluaranKayu[$i] = 0;
        }

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleFive\FormD::class, ['bulan_id' => self::BULAN])
            ->set('total_jumlah_pengeluaran', 0)
            ->set('pengeluaran_kayu', $pengeluaranKayu)
            ->call('store')
            ->assertHasNoErrors();

        $form5d = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', self::BULAN)->first();
        $this->assertNotNull($form5d);
        $this->assertNotSame('Tidak Diisi', $form5d->status, 'Shuttle 5 Form D should no longer be Tidak Diisi after filling.');

        // Form E (shuttle 5 = local/export sales totals)
        Form5E::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5',
            'tahun' => self::YEAR, 'bulan' => self::BULAN, 'status' => 'Tidak Diisi',
        ]);

        $this->get(route('user.shuttle-5-formE', [self::YEAR, self::BULAN]))->assertOk();

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleFive\FormE::class, ['bulan_id' => self::BULAN])
            ->set('jumlah_jualan_pasaran_tempatan', 100)
            ->set('jumlah_jualan_eksport', 50)
            ->call('store');

        $form5e = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', self::BULAN)->first();
        $this->assertNotNull($form5e);
        $this->assertNotSame('Tidak Diisi', $form5e->status, 'Shuttle 5 Form E should no longer be Tidak Diisi after filling.');
    }

    // ── Shared setup helpers ────────────────────────────────────────────────

    private function makeUser(string $shuttleType): User
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

    private function fillFormA(User $user, $shuttle, string $shuttleType): void
    {
        $hakMilik = HakMilik::first();
        $this->assertNotNull($hakMilik, 'HakMilik lookup table must be seeded.');

        $viewRoute = "user.shuttle-{$shuttleType}-formA";
        $this->actingAs($user)->get(route($viewRoute))->assertOk();

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
        $response->assertSessionDoesntHaveErrors();

        $formA = FormA::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->first();
        $this->assertNotNull($formA);
        $this->assertNotSame('Tidak Diisi', $formA->status, 'Form A should no longer be Tidak Diisi after filling.');
    }

    private function fillFormBShared(User $user, $shuttle): void
    {
        $shuttleType = $shuttle->shuttle_type;
        $viewRoute = "user.shuttle-{$shuttleType}-formB";

        $this->actingAs($user)->get(route($viewRoute, [1, self::YEAR]))->assertOk();

        $kategori = KategoriGunaTenaga::get();
        $this->assertGreaterThan(0, $kategori->count(), 'KategoriGunaTenaga must be seeded.');

        $namespace = [
            '3' => \App\Http\Livewire\ShuttleThree\FormB::class,
            '4' => \App\Http\Livewire\ShuttleFour\FormB::class,
            '5' => \App\Http\Livewire\ShuttleFive\FormB::class,
        ][$shuttleType];

        Livewire::actingAs($user)
            ->test($namespace, ['year' => self::YEAR, 'suku_id' => 1])
            ->set('pekerja_wargabumi_lelaki.0', 1)
            ->set('gaji_lelaki.0', 5000)
            ->call('store');

        $formB = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', 1)->first();
        $this->assertNotNull($formB);
        $this->assertNotSame('Tidak Diisi', $formB->status, "Shuttle {$shuttleType} Form B should no longer be Tidak Diisi after filling.");
    }

    private function fillFormCAllGroups($shuttle, string $shuttleType): void
    {
        $prefix = "shuttle-{$shuttleType}-formC";

        Batch::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => self::BULAN],
            ['status' => 'Sedang Diproses', 'borang_a' => 1]
        );

        // Shuttle 4/5's Form C view controllers expect the month's FormC row
        // to already exist (plain ->first(), no firstOrCreate).
        FormC::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => self::BULAN],
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
            $this->get(route("user.view.{$prefix}.{$stage['route']}", [self::BULAN, self::YEAR]))->assertOk();

            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $stage['kayu_id'])->get()->values();
            $count = $species->count();
            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = 10 + $s->id;
            }
            $zeroFill = array_fill(0, $count, 0);

            $response = $this->post(route("user.view.{$prefix}.{$stage['route']}.store", [self::BULAN, self::YEAR]), [
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
                // Form D (shuttle 4/5) validates its production output against
                // this figure * the shuttle's recovery-rate range, so it must
                // be non-zero for a downstream Form D fill to pass validation.
                'jumlah_besar_kayu_ke_dalam_jentera' => 500,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ]);
            $response->assertSessionDoesntHaveErrors();
        }

        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', self::BULAN)->first();
        $this->assertNotNull($formc);
        $this->assertContains($formc->status, \App\Services\FormFlowService::SUBMITTED,
            "Shuttle {$shuttleType} Form C must end in a submitted state so Form D can unlock.");
    }
}
