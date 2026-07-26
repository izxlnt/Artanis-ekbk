<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\HakMilik;
use App\Models\KemasukanBahan;
use App\Models\Pembeli;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * REAL-DATA end-to-end test: mills #1 (shuttle 1027) and #2 (shuttle 1807),
 * both real shuttle-type-3 IBK factories whose 2026 data was untouched
 * ("Tidak Diisi") before this test ran. Fills Form A, Form B (Q1), Form C
 * bulan=1 across all 5 kayu groups (with a normal/edge/decimal value mix per
 * the test plan), Form C bulan=2 via "Tiada Pengeluaran", and Form D bulan=1,
 * through the real IBK user accounts and real HTTP routes.
 *
 * Wrapped in DatabaseTransactions — everything here is rolled back at the end
 * of each test method, regardless of pass/fail.
 */
class RealMillFreshChainTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function mill_1_shuttle_1027_fresh_full_chain()
    {
        $this->runFreshChain(1027, 2302);
    }

    /** @test */
    public function mill_2_shuttle_1807_fresh_full_chain()
    {
        $this->runFreshChain(1807, 3943);
    }

    private function runFreshChain(int $shuttleId, int $ibkUserId): void
    {
        $user = User::findOrFail($ibkUserId);
        $shuttle = Shuttle::findOrFail($shuttleId);
        $this->assertSame((string) $shuttleId, (string) $user->shuttle_id, "User {$ibkUserId} must belong to shuttle {$shuttleId}.");
        $this->assertSame('3', (string) $shuttle->shuttle_type, "Shuttle {$shuttleId} must be shuttle type 3 for this test.");

        // Mill #1 (1027) has ZERO Batch/FormA rows for 2026 in the real DB (a
        // pre-existing data gap — presumably never seeded — noted separately
        // in the report). Mill #2 (1807) already has proper "Tidak Diisi"
        // placeholder rows. Create the missing rows here (in-transaction,
        // exactly like the real yearly seeder would) so we can exercise the
        // real fill routes either way.
        foreach ([1, 2] as $bulan) {
            Batch::firstOrCreate(
                ['shuttle_id' => $shuttleId, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['status' => 'Tidak Diisi', 'borang_a' => 0, 'borang_b' => 0, 'borang_c' => 0, 'borang_d' => 0]
            );
        }
        FormA::firstOrCreate(
            ['shuttle_id' => $shuttleId, 'tahun' => self::YEAR],
            ['status' => 'Tidak Diisi']
        );

        // ── BEFORE snapshot ─────────────────────────────────────────────────
        $fields = ['status', 'borang_a', 'borang_b', 'borang_c', 'borang_d'];
        $before = [
            'formA' => FormA::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->first()->status,
            'batch1' => array_intersect_key(Batch::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 1)->first()->toArray(), array_flip($fields)),
            'batch2' => array_intersect_key(Batch::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 2)->first()->toArray(), array_flip($fields)),
        ];

        // ── Form A ──────────────────────────────────────────────────────────
        $hakMilik = HakMilik::first();
        $this->assertNotNull($hakMilik, 'HakMilik lookup table must be seeded.');

        $this->actingAs($user)->get(route('user.shuttle-3-formA'))->assertOk();
        $resp = $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
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
        $resp->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formA = FormA::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->first();
        $this->assertNotSame('Tidak Diisi', $formA->status, "Shuttle {$shuttleId}: Form A should no longer be Tidak Diisi after filling.");

        $batchAfterA = Batch::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('borang_a', 1)->first();
        $this->assertNotNull($batchAfterA, "Shuttle {$shuttleId}: some Batch row should have borang_a flipped to 1 after Form A submit.");

        // ── Form B Q1 ───────────────────────────────────────────────────────
        $this->actingAs($user)->get(route('user.shuttle-3-formB', [1, self::YEAR]))->assertOk();
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => 1])
            ->set('pekerja_wargabumi_lelaki.0', 1)
            ->set('gaji_lelaki.0', 5000)
            ->call('store')
            ->assertHasNoErrors();

        $formB = FormB::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('suku_tahun', 1)->first();
        $this->assertNotNull($formB);
        $this->assertNotSame('Tidak Diisi', $formB->status, "Shuttle {$shuttleId}: Form B Q1 should no longer be Tidak Diisi.");

        // ── Form C bulan=1: normal / edge / decimal mix across all 5 groups ──
        $prefix = 'shuttle-3-formC';
        $groupValues = [
            // route => [label, value-generator($speciesId)]
            'KKB'        => fn ($id) => 50 + ($id % 20),          // normal, moderate positive
            'KKS'        => fn ($id) => 999999,                    // edge case: very large volume
            'KKR'        => fn ($id) => 123.45 + ($id % 10) * 0.11, // decimal values
            'KayuLembut' => fn ($id) => 75 + ($id % 15),
            'LainLain'   => fn ($id) => 30 + ($id % 10),
        ];
        $kayuIds = ['KKB' => 1, 'KKS' => 2, 'KKR' => 3, 'KayuLembut' => 4, 'LainLain' => 5];

        foreach ($groupValues as $route => $valueFn) {
            $this->actingAs($user)->get(route("user.view.{$prefix}.{$route}", [1, self::YEAR]))->assertOk();

            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayuIds[$route])->get()->values();
            $this->assertGreaterThan(0, $species->count(), "No species for group {$route}.");

            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = $valueFn($s->id);
            }
            $zeroFill = array_fill(0, $species->count(), 0);

            $resp = $this->actingAs($user)->post(route("user.view.{$prefix}.{$route}.store", [1, self::YEAR]), [
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
            $resp->assertStatus(302)->assertSessionDoesntHaveErrors();
        }

        // Verify the decimal (KKR) values actually persisted with their fractional part intact.
        $formC1 = FormC::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertNotNull($formC1);
        $kkrSpecies = Spesis::where('kumpulan_kayu_id', 3)->orderBy('id')->first();
        $kkrRow = KemasukanBahan::where('formcs_id', $formC1->id)->where('spesis_id', $kkrSpecies->id)->first();
        $this->assertNotNull($kkrRow);
        $expectedDecimal = 123.45 + ($kkrSpecies->id % 10) * 0.11;
        $this->assertEqualsWithDelta($expectedDecimal, (float) $kkrRow->kayu_masuk, 0.02,
            "Shuttle {$shuttleId}: KKR decimal value should be persisted with its fractional part.");

        // Verify the edge-case (KKS) large value persisted without truncation/overflow.
        $kksSpecies = Spesis::where('kumpulan_kayu_id', 2)->orderBy('id')->first();
        $kksRow = KemasukanBahan::where('formcs_id', $formC1->id)->where('spesis_id', $kksSpecies->id)->first();
        $this->assertNotNull($kksRow);
        $this->assertEquals(999999, (float) $kksRow->kayu_masuk, "Shuttle {$shuttleId}: KKS edge-case large value should persist exactly.");

        $formC1->refresh();
        $this->assertSame('Sedang Diproses', $formC1->status, "Shuttle {$shuttleId}: Form C bulan=1 should be Sedang Diproses after all 5 groups submitted.");

        $batch1 = Batch::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertSame(1, (int) $batch1->borang_c, "Shuttle {$shuttleId} bulan=1: batches.borang_c should be 1 (awaiting PHD).");
        $this->assertSame('Sedang Diproses', $batch1->status);

        // ── Form C bulan=2 via "Tiada Pengeluaran" ───────────────────────────
        $this->actingAs($user)->get(route("user.view.{$prefix}.KKB", [2, self::YEAR]))->assertOk();
        $resp = $this->actingAs($user)->get(route("user.{$prefix}.tiadaPengeluaran", [2, self::YEAR]));
        $resp->assertStatus(302)->assertSessionDoesntHaveErrors();
        $this->assertFalse($resp->getSession()->has('error'), "Shuttle {$shuttleId} bulan=2 Tiada Pengeluaran unexpectedly rejected: " . $resp->getSession()->get('error'));

        $formC2 = FormC::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 2)->first();
        $this->assertNotNull($formC2);
        $this->assertSame('Tiada Pengeluaran', $formC2->status);
        $this->assertSame(1, (int) $formC2->tiada_pengeluaran);

        $batch2 = Batch::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 2)->first();
        $this->assertSame(1, (int) $batch2->borang_c, "Shuttle {$shuttleId} bulan=2: batches.borang_c should be 1 after Tiada Pengeluaran.");

        // ── Form D bulan=1 (shuttle 3 = generic FormD + PenjualanPembeli buyers) ──
        FormD::firstOrCreate(
            ['shuttle_id' => $shuttleId, 'tahun' => self::YEAR, 'bulan' => 1],
            ['shuttle_type' => '3', 'status' => 'Tidak Diisi']
        );
        $this->actingAs($user)->get(route('user.shuttle-3-formD', [self::YEAR, 1]))->assertOk();

        $jumlahJualan = [];
        foreach (Pembeli::where('shuttle', 3)->get() as $i => $p) {
            $jumlahJualan[$i] = 100;
        }
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\ShuttleThree\FormD::class, ['year' => self::YEAR, 'bulan_id' => 1])
            ->set('total_export', 500)
            ->set('jumlah_jualan', $jumlahJualan)
            ->call('store')
            ->assertHasNoErrors();

        $formD = FormD::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertNotNull($formD);
        $this->assertNotSame('Tidak Diisi', $formD->status, "Shuttle {$shuttleId}: Form D bulan=1 should no longer be Tidak Diisi.");

        $batch1->refresh();
        $this->assertSame(1, (int) $batch1->borang_d, "Shuttle {$shuttleId} bulan=1: batches.borang_d should be 1 after Form D submit.");

        // ── Report the before -> after transition succinctly to the log ─────
        fwrite(STDERR, sprintf(
            "\n[Mill shuttle=%d] BEFORE: FormA=%s batch1=%s batch2=%s\n[Mill shuttle=%d] AFTER:  FormA=%s batch1(a=%d,b=%d,c=%d,d=%d,status=%s) batch2(c=%d,status=%s) FormC1=%s FormC2=%s FormD1=%s\n",
            $shuttleId, $before['formA'], json_encode($before['batch1']), json_encode($before['batch2']),
            $shuttleId, $formA->status,
            $batch1->borang_a, $batch1->borang_b, $batch1->borang_c, $batch1->borang_d, $batch1->status,
            $batch2->borang_c, $batch2->status,
            $formC1->status, $formC2->status, $formD->status
        ));
    }
}
