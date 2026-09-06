<?php

namespace Tests\Feature;

use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\GunaTenaga;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\KemasukanBahan;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use App\Services\FormFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Deep calculation-correctness test for Form B and Form C: fills every
 * column of every row with randomized data, from January through the
 * current month, for every shuttle type, then independently recomputes
 * every derived column (row-level and grand-total) in PHP and asserts the
 * database matches - not just "a value landed somewhere", but that every
 * formula (sums, sub-totals, month-to-month carry-forward) is correct.
 *
 * Form B columns verified per category:
 *  (08) jumlah_lelaki = wargabumi_lelaki + bukan_wargabumi_lelaki + asing_lelaki
 *  (09) jumlah_perempuan = wargabumi_perempuan + bukan_wargabumi_perempuan + asing_perempuan
 *  (10) jumlah_pekerja = jumlah_lelaki + jumlah_perempuan
 *  (14) total_gaji_lelaki = jumlah_lelaki * gaji_lelaki
 *  (14) total_gaji_perempuan = jumlah_perempuan * gaji_perempuan
 *  (16) total_gaji = total_gaji_lelaki + total_gaji_perempuan
 * plus every "jumlah besar" grand total (sum across all 8 categories).
 *
 * Form C columns verified per species:
 *  (04) jumlah_stok_kayu_balak = (02) baki_stok + (03) kayu_masuk
 *  (07) baki_stok_kehadapan = (04) - (05) proses_masuk
 * plus every group-level "jumlah besar" grand total (sum across all 5 wood
 * groups, server-recomputed by FormCController::refreshJumlahBesar), and
 * month N+1's carried-forward (02) baki_stok must equal month N's (07).
 */
class FormBAndFormCCalculationCorrectnessTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function shuttle_3_form_b_and_c_calculations_are_correct_jan_to_current_month()
    {
        $this->runForShuttle('3');
    }

    /** @test */
    public function shuttle_4_form_b_and_c_calculations_are_correct_jan_to_current_month()
    {
        $this->runForShuttle('4');
    }

    /** @test */
    public function shuttle_5_form_b_and_c_calculations_are_correct_jan_to_current_month()
    {
        $this->runForShuttle('5');
    }

    private function runForShuttle(string $shuttleType): void
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
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $currentMonth = (int) date('n');
        $this->assertGreaterThanOrEqual(1, $currentMonth);

        /** @var array<int,float> $carryForward spesis_id => expected baki_stok_kehadapan */
        $carryForward = [];

        for ($bulan = 1; $bulan <= $currentMonth; $bulan++) {
            $suku = (int) ceil($bulan / 3);
            $isFirstMonthOfQuarter = $bulan === (($suku - 1) * 3 + 1);

            if ($isFirstMonthOfQuarter && ($suku === 1 || $this->formBSubmitted($shuttle, $suku - 1))) {
                $this->fillAndVerifyFormB($user, $shuttle, $shuttleType, $suku);
            }

            $carryForward = $this->fillAndVerifyFormC($user, $shuttle, $shuttleType, $bulan, $carryForward);
        }
    }

    // ── Setup helpers ────────────────────────────────────────────────────

    private function fillFormA(User $user, $shuttle): void
    {
        $hakMilik = HakMilik::first();
        // The GET view firstOrCreate()s this year's FormA row - updateFormA()
        // itself only ->first()s and crashes on a missing row.
        $this->actingAs($user)->get(route("user.shuttle-{$user->shuttle_type}-formA"))->assertOk();
        $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM-CALC-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'calc-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-CALC-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    private function formBSubmitted($shuttle, int $suku): bool
    {
        $formB = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', $suku)->first();
        return $formB && in_array($formB->status, FormFlowService::SUBMITTED, true);
    }

    // ── Form B: fill every column randomly, verify every formula ───────

    private function fillAndVerifyFormB(User $user, $shuttle, string $shuttleType, int $suku): void
    {
        $this->actingAs($user)->get(route("user.shuttle-{$shuttleType}-formB", [$suku, self::YEAR]))->assertOk();

        $kategori = KategoriGunaTenaga::orderBy('id')->get();
        $inputs = [];
        foreach ($kategori as $i => $k) {
            $wl = random_int(0, 20);
            $wp = random_int(0, 20);
            $bl = random_int(0, 10);
            $bp = random_int(0, 10);
            $al = random_int(0, 10);
            $ap = random_int(0, 10);
            $gl = random_int((int) $k->gaji_min, (int) $k->gaji_max);
            $gp = random_int((int) $k->gaji_min, (int) $k->gaji_max);
            $inputs[$i] = compact('wl', 'wp', 'bl', 'bp', 'al', 'ap', 'gl', 'gp');
        }

        $namespace = [
            '3' => \App\Http\Livewire\ShuttleThree\FormB::class,
            '4' => \App\Http\Livewire\ShuttleFour\FormB::class,
            '5' => \App\Http\Livewire\ShuttleFive\FormB::class,
        ][$shuttleType];

        $test = Livewire::actingAs($user)->test($namespace, ['year' => self::YEAR, 'suku_id' => $suku]);
        foreach ($inputs as $i => $v) {
            $test->set("pekerja_wargabumi_lelaki.{$i}", $v['wl'])
                ->set("pekerja_wargabumi_perempuan.{$i}", $v['wp'])
                ->set("pekerja_bukan_wargabumi_lelaki.{$i}", $v['bl'])
                ->set("pekerja_bukan_wargabumi_perempuan.{$i}", $v['bp'])
                ->set("pekerja_asing_lelaki.{$i}", $v['al'])
                ->set("pekerja_asing_perempuan.{$i}", $v['ap'])
                ->set("gaji_lelaki.{$i}", $v['gl'])
                ->set("gaji_perempuan.{$i}", $v['gp']);
        }
        // Trigger the same recalculation cascade the real UI's oninput handlers
        // fire per cell - the grand-total calc*() methods re-loop over every
        // category from scratch each time, so calling both cascades once per
        // category (after ALL raw inputs are set) reaches the same final state
        // as a real user tabbing through every cell.
        foreach ($inputs as $i => $v) {
            $test->call('calcJumlahPekerjaLelaki', $i)->call('calcJumlahPekerjaPerempuan', $i);
        }
        $test->call('store');

        $formB = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', $suku)->first();
        $this->assertNotNull($formB, "Shuttle {$shuttleType} suku {$suku}: FormB row missing.");
        $this->assertNotSame('Tidak Diisi', $formB->status, "Shuttle {$shuttleType} suku {$suku}: FormB should be submitted.");

        $rows = GunaTenaga::where('formbs_id', $formB->id)->get()->keyBy('kategori_guna_tenaga_id');

        $expectedGrand = [
            'total_bumi_lelaki' => 0, 'total_bumi_perempuan' => 0,
            'total_bukanbumi_lelaki' => 0, 'total_bukanbumi_perempuan' => 0,
            'total_asing_lelaki' => 0, 'total_asing_perempuan' => 0,
            'total_pekerja_lelaki' => 0, 'total_pekerja_perempuan' => 0, 'total_pekerja' => 0,
            'jumlah_gaji_lelaki' => 0.0, 'jumlah_gaji_perempuan' => 0.0, 'jumlah_lelaki_perempuan' => 0.0,
            'jumlah_total_lelaki' => 0.0, 'jumlah_total_perempuan' => 0.0, 'jumlah_total_gaji' => 0.0,
        ];

        foreach ($kategori as $i => $k) {
            $v = $inputs[$i];
            $row = $rows->get($k->id);
            $this->assertNotNull($row, "Shuttle {$shuttleType} suku {$suku}: category {$k->id} ({$k->keterangan}) row missing.");

            $jumlahLelaki = $v['wl'] + $v['bl'] + $v['al'];
            $jumlahPerempuan = $v['wp'] + $v['bp'] + $v['ap'];
            $jumlahPekerja = $jumlahLelaki + $jumlahPerempuan;
            $totalGajiLelaki = round($jumlahLelaki * $v['gl'], 2);
            $totalGajiPerempuan = round($jumlahPerempuan * $v['gp'], 2);
            $totalGaji = round($totalGajiLelaki + $totalGajiPerempuan, 2);

            $label = "Shuttle {$shuttleType} suku {$suku} category {$k->id} ({$k->keterangan})";
            $this->assertSame($v['wl'], (int) $row->pekerja_wargabumi_lelaki, "{$label}: pekerja_wargabumi_lelaki drifted.");
            $this->assertSame($v['wp'], (int) $row->pekerja_wargabumi_perempuan, "{$label}: pekerja_wargabumi_perempuan drifted.");
            $this->assertSame($v['bl'], (int) $row->pekerja_bukan_wargabumi_lelaki, "{$label}: pekerja_bukan_wargabumi_lelaki drifted.");
            $this->assertSame($v['bp'], (int) $row->pekerja_bukan_wargabumi_perempuan, "{$label}: pekerja_bukan_wargabumi_perempuan drifted.");
            $this->assertSame($v['al'], (int) $row->pekerja_asing_lelaki, "{$label}: pekerja_asing_lelaki drifted.");
            $this->assertSame($v['ap'], (int) $row->pekerja_asing_perempuan, "{$label}: pekerja_asing_perempuan drifted.");
            $this->assertSame($jumlahLelaki, (int) $row->jumlah_lelaki, "{$label}: jumlah_lelaki (08)=wargabumi+bukan+asing lelaki is wrong.");
            $this->assertSame($jumlahPerempuan, (int) $row->jumlah_perempuan, "{$label}: jumlah_perempuan (09)=wargabumi+bukan+asing perempuan is wrong.");
            $this->assertSame($jumlahPekerja, (int) $row->jumlah_pekerja, "{$label}: jumlah_pekerja (10)=lelaki+perempuan is wrong.");
            $this->assertEqualsWithDelta($totalGajiLelaki, (float) $row->total_gaji_lelaki, 0.01, "{$label}: total_gaji_lelaki = jumlah_lelaki*gaji_lelaki is wrong.");
            $this->assertEqualsWithDelta($totalGajiPerempuan, (float) $row->total_gaji_perempuan, 0.01, "{$label}: total_gaji_perempuan = jumlah_perempuan*gaji_perempuan is wrong.");
            $this->assertEqualsWithDelta($totalGaji, (float) $row->total_gaji, 0.01, "{$label}: total_gaji = total_gaji_lelaki+total_gaji_perempuan is wrong.");

            $expectedGrand['total_bumi_lelaki'] += $v['wl'];
            $expectedGrand['total_bumi_perempuan'] += $v['wp'];
            $expectedGrand['total_bukanbumi_lelaki'] += $v['bl'];
            $expectedGrand['total_bukanbumi_perempuan'] += $v['bp'];
            $expectedGrand['total_asing_lelaki'] += $v['al'];
            $expectedGrand['total_asing_perempuan'] += $v['ap'];
            $expectedGrand['total_pekerja_lelaki'] += $jumlahLelaki;
            $expectedGrand['total_pekerja_perempuan'] += $jumlahPerempuan;
            $expectedGrand['total_pekerja'] += $jumlahPekerja;
            $expectedGrand['jumlah_gaji_lelaki'] += $v['gl'];
            $expectedGrand['jumlah_gaji_perempuan'] += $v['gp'];
            $expectedGrand['jumlah_lelaki_perempuan'] += round($v['gl'] + $v['gp'], 2);
            $expectedGrand['jumlah_total_lelaki'] += $totalGajiLelaki;
            $expectedGrand['jumlah_total_perempuan'] += $totalGajiPerempuan;
            $expectedGrand['jumlah_total_gaji'] += $totalGaji;
        }

        // Grand totals are stored on every row identically (see FormB::store()),
        // so checking the last row's copy is representative of all of them.
        $lastRow = $rows->get($kategori->last()->id);
        $label = "Shuttle {$shuttleType} suku {$suku} grand totals";
        $this->assertSame($expectedGrand['total_bumi_lelaki'], (int) $lastRow->total_bumi_lelaki, "{$label}: total_bumi_lelaki sum wrong.");
        $this->assertSame($expectedGrand['total_bumi_perempuan'], (int) $lastRow->total_bumi_perempuan, "{$label}: total_bumi_perempuan sum wrong.");
        $this->assertSame($expectedGrand['total_bukanbumi_lelaki'], (int) $lastRow->total_bukanbumi_lelaki, "{$label}: total_bukanbumi_lelaki sum wrong.");
        $this->assertSame($expectedGrand['total_bukanbumi_perempuan'], (int) $lastRow->total_bukanbumi_perempuan, "{$label}: total_bukanbumi_perempuan sum wrong.");
        $this->assertSame($expectedGrand['total_asing_lelaki'], (int) $lastRow->total_asing_lelaki, "{$label}: total_asing_lelaki sum wrong.");
        $this->assertSame($expectedGrand['total_asing_perempuan'], (int) $lastRow->total_asing_perempuan, "{$label}: total_asing_perempuan sum wrong.");
        $this->assertSame($expectedGrand['total_pekerja_lelaki'], (int) $lastRow->total_pekerja_lelaki, "{$label}: total_pekerja_lelaki sum wrong.");
        $this->assertSame($expectedGrand['total_pekerja_perempuan'], (int) $lastRow->total_pekerja_perempuan, "{$label}: total_pekerja_perempuan sum wrong.");
        $this->assertSame($expectedGrand['total_pekerja'], (int) $lastRow->total_pekerja, "{$label}: total_pekerja (=all lelaki+perempuan) sum wrong.");
        $this->assertEqualsWithDelta($expectedGrand['jumlah_total_lelaki'], (float) $lastRow->jumlah_total_lelaki, 0.05, "{$label}: jumlah_total_lelaki (sum of total_gaji_lelaki) wrong.");
        $this->assertEqualsWithDelta($expectedGrand['jumlah_total_perempuan'], (float) $lastRow->jumlah_total_perempuan, 0.05, "{$label}: jumlah_total_perempuan (sum of total_gaji_perempuan) wrong.");
        $this->assertEqualsWithDelta($expectedGrand['jumlah_total_gaji'], (float) $lastRow->jumlah_total_gaji, 0.05, "{$label}: jumlah_total_gaji (sum of total_gaji) wrong.");
    }

    // ── Form C: fill every species randomly, verify (04)/(07)/grand totals
    // and month-to-month carry-forward. ─────────────────────────────────

    /** @return array<int,float> spesis_id => baki_stok_kehadapan, for next month's carry-forward check */
    private function fillAndVerifyFormC(User $user, $shuttle, string $shuttleType, int $bulan, array $expectedCarryForward): array
    {
        \App\Models\Batch::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['status' => 'Sedang Diproses', 'borang_a' => 1]
        );
        FormC::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['shuttle_type' => $shuttleType, 'status' => 'Tidak Diisi']
        );

        $prefix = "shuttle-{$shuttleType}-formC";
        $stages = [
            ['kayu_id' => 1, 'route' => 'KKB'],
            ['kayu_id' => 2, 'route' => 'KKS'],
            ['kayu_id' => 3, 'route' => 'KKR'],
            ['kayu_id' => 4, 'route' => 'KayuLembut'],
            ['kayu_id' => 5, 'route' => 'LainLain'],
        ];

        // Shuttle 4 has no "proses_keluar" (06)/output column anywhere in Form C
        // at all - confirmed absent from every wood group's blade view and its
        // controller's save arrays. Its finished-product output is captured in
        // Form D instead. Shuttle 3 and 5 both track it.
        $hasProsesKeluar = $shuttleType !== '4';

        $nextCarryForward = [];
        $sumBakiStok = 0.0;
        $sumKayuMasuk = 0.0;
        $sumJumlahStok = 0.0;
        $sumProsesMasuk = 0.0;
        $sumProsesKeluar = 0.0;
        $sumBakiKehadapan = 0.0;

        foreach ($stages as $stage) {
            $getResponse = $this->actingAs($user)->get(route("user.view.{$prefix}.{$stage['route']}", [$bulan, self::YEAR]));
            $getResponse->assertOk();

            $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->where('kumpulan_kayu_id', $stage['kayu_id'])->get()->values();
            $count = $species->count();

            // Verify the carry-forward the GET view pre-fills (readonly (02)
            // baki_stok input) matches last month's stored (07) baki_stok_kehadapan
            // for every species, before we submit anything new.
            if ($bulan > 1) {
                $renderedBaki = $this->extractReadonlyBakiStok($getResponse->getContent(), $count);
                foreach ($species as $i => $s) {
                    $expected = $expectedCarryForward[$s->id] ?? 0.0;
                    $this->assertArrayHasKey($i, $renderedBaki,
                        "Shuttle {$shuttleType} month {$bulan} {$stage['route']}: no rendered baki_stok input at index {$i}.");
                    $this->assertEqualsWithDelta($expected, $renderedBaki[$i], 0.01,
                        "Shuttle {$shuttleType} month {$bulan} {$stage['route']}: species {$s->id} carried-forward baki_stok (02) doesn't match month " . ($bulan - 1) . "'s baki_stok_kehadapan (07).");
                }
            }

            $bakiStoks = [];
            $kayuMasuk = [];
            $prosesMasuk = [];
            $prosesKeluar = [];
            $jumlahStok = [];
            $bakiKehadapan = [];

            foreach ($species as $i => $s) {
                $baki = $bulan > 1 ? ($expectedCarryForward[$s->id] ?? 0.0) : (float) random_int(0, 100);
                $masuk = (float) random_int(50, 400);
                $jsb = $baki + $masuk; // (04) = (02)+(03)
                $masukJentera = (float) random_int(0, (int) $jsb); // (05) <= (04)
                $keluarJentera = $hasProsesKeluar ? (float) random_int(0, (int) $masukJentera) : 0.0; // (06) <= (05)
                $kehadapan = $jsb - $masukJentera; // (07) = (04)-(05)

                $bakiStoks[$i] = $baki;
                $kayuMasuk[$i] = $masuk;
                $prosesMasuk[$i] = $masukJentera;
                $prosesKeluar[$i] = $keluarJentera;
                $jumlahStok[$i] = $jsb;
                $bakiKehadapan[$i] = $kehadapan;

                $nextCarryForward[$s->id] = $kehadapan;
                $sumBakiStok += $baki;
                $sumKayuMasuk += $masuk;
                $sumJumlahStok += $jsb;
                $sumProsesMasuk += $masukJentera;
                $sumProsesKeluar += $keluarJentera;
                $sumBakiKehadapan += $kehadapan;
            }

            $groupSumBaki = array_sum($bakiStoks);
            $groupSumMasuk = array_sum($kayuMasuk);
            $groupSumJsb = array_sum($jumlahStok);
            $groupSumProsesMasuk = array_sum($prosesMasuk);
            $groupSumProsesKeluar = array_sum($prosesKeluar);
            $groupSumKehadapan = array_sum($bakiKehadapan);

            $response = $this->actingAs($user)->post(route("user.view.{$prefix}.{$stage['route']}.store", [$bulan, self::YEAR]), [
                'baki_stoks' => $bakiStoks,
                'kayu_masuk' => $kayuMasuk,
                'jumlah_stok_kayu_balak' => $jumlahStok,
                'proses_masuk' => $prosesMasuk,
                'proses_keluar' => $prosesKeluar,
                'baki_stok_kehadapan' => $bakiKehadapan,
                'jumlah_baki_stok' => array_fill(0, $count, $groupSumBaki),
                'jumlah_kayu_masuk' => array_fill(0, $count, $groupSumMasuk),
                'total_stok_kayu_balak' => array_fill(0, $count, $groupSumJsb),
                'total_kayu_masuk_jentera' => array_fill(0, $count, $groupSumProsesMasuk),
                'total_kayu_keluar_jentera' => array_fill(0, $count, $groupSumProsesKeluar),
                'total_kayu_dibawa_bulan_hadapan' => array_fill(0, $count, $groupSumKehadapan),
                'jumlah_besar_baki_stok_bulan_lepas' => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0,
                'jumlah_besar_kayu_ke_dalam_jentera' => 0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ]);
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();

            // ── Per-species formula + persistence check ─────────────────
            $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($formc, "Shuttle {$shuttleType} month {$bulan}: FormC row missing.");

            foreach ($species as $i => $s) {
                $row = KemasukanBahan::where('formcs_id', $formc->id)->where('spesis_id', $s->id)->first();
                $label = "Shuttle {$shuttleType} month {$bulan} {$stage['route']} species {$s->id}";
                $this->assertNotNull($row, "{$label}: row missing.");
                $this->assertEqualsWithDelta($bakiStoks[$i], (float) $row->baki_stok, 0.01, "{$label}: baki_stok (02) drifted.");
                $this->assertEqualsWithDelta($kayuMasuk[$i], (float) $row->kayu_masuk, 0.01, "{$label}: kayu_masuk (03) drifted.");
                $this->assertEqualsWithDelta($jumlahStok[$i], (float) $row->jumlah_stok_kayu_balak, 0.01, "{$label}: jumlah_stok_kayu_balak (04) != (02)+(03).");
                $this->assertEqualsWithDelta($prosesMasuk[$i], (float) $row->proses_masuk, 0.01, "{$label}: proses_masuk (05) drifted.");
                if ($hasProsesKeluar) {
                    $this->assertEqualsWithDelta($prosesKeluar[$i], (float) $row->proses_keluar, 0.01, "{$label}: proses_keluar (06) drifted.");
                }
                $this->assertEqualsWithDelta($bakiKehadapan[$i], (float) $row->baki_stok_kehadapan, 0.01, "{$label}: baki_stok_kehadapan (07) != (04)-(05).");
                $this->assertEqualsWithDelta($jumlahStok[$i] - $prosesMasuk[$i], (float) $row->baki_stok_kehadapan, 0.01, "{$label}: (07) independently recomputed from stored (04)-(05) doesn't match stored (07).");
            }
        }

        // ── Grand totals across all 5 groups (server-recomputed by
        // FormCController::refreshJumlahBesar) ──────────────────────────
        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
        $grandRow = KemasukanBahan::whereHas('spesis_id', fn ($q) => $q->where('kumpulan_kayu_id', 5))
            ->where('formcs_id', $formc->id)->first();
        $this->assertNotNull($grandRow, "Shuttle {$shuttleType} month {$bulan}: Lain-Lain group row (grand-total carrier) missing.");
        $label = "Shuttle {$shuttleType} month {$bulan} grand totals";
        $this->assertEqualsWithDelta($sumBakiStok, (float) $grandRow->jumlah_besar_baki_stok_bulan_lepas, 0.05, "{$label}: jumlah_besar_baki_stok_bulan_lepas (sum of (02) across all groups) wrong.");
        $this->assertEqualsWithDelta($sumKayuMasuk, (float) $grandRow->jumlah_besar_kemasukan_kayu_ke_kilang, 0.05, "{$label}: jumlah_besar_kemasukan_kayu_ke_kilang (sum of (03)) wrong.");
        $this->assertEqualsWithDelta($sumJumlahStok, (float) $grandRow->jumlah_besar_stok_kayu_balak, 0.05, "{$label}: jumlah_besar_stok_kayu_balak (sum of (04)) wrong.");
        $this->assertEqualsWithDelta($sumProsesMasuk, (float) $grandRow->jumlah_besar_kayu_ke_dalam_jentera, 0.05, "{$label}: jumlah_besar_kayu_ke_dalam_jentera (sum of (05)) wrong.");
        $this->assertEqualsWithDelta($sumProsesKeluar, (float) $grandRow->jumlah_besar_pengeluaran_kayu_daripada_jentera, 0.05, "{$label}: jumlah_besar_pengeluaran_kayu_daripada_jentera (sum of (06)) wrong.");
        $this->assertEqualsWithDelta($sumBakiKehadapan, (float) $grandRow->jumlah_besar_baki_stok_bulan_depan, 0.05, "{$label}: jumlah_besar_baki_stok_bulan_depan (sum of (07)) wrong.");

        $this->assertContains($formc->status, FormFlowService::SUBMITTED, "Shuttle {$shuttleType} month {$bulan}: Form C must end submitted.");

        return $nextCarryForward;
    }

    /**
     * Extracts the readonly baki_stoks.<index> input values from a rendered
     * Form C fill page, keyed by species index within that wood group.
     *
     * @return array<int,float>
     */
    private function extractReadonlyBakiStok(string $html, int $expectedCount): array
    {
        preg_match_all('/id="baki_stoks\.(\d+)"[^>]*value="([^"]*)"/s', $html, $matches, PREG_SET_ORDER);
        $result = [];
        foreach ($matches as $m) {
            $result[(int) $m[1]] = (float) $m[2];
        }
        return $result;
    }
}
