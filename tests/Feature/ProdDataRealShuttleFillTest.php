<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\KemasukanBahan;
use App\Models\Spesis;
use App\Models\User;
use App\Services\FormFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Runs against REAL production data: picks a real, active IBK factory per
 * shuttle type whose 2026 chain is mid-progress (some months submitted, next
 * month not yet), then fills that next month's Form C through the real
 * routes — exactly what will happen the moment users start inputting data
 * after the update goes live.
 *
 * The critical assertions:
 *  1. The fill succeeds (no crash, no validation surprise) on top of the
 *     shuttle's real historical rows, whatever order they were stored in.
 *  2. Every submitted value lands on exactly the right species row.
 *  3. The already-submitted previous month's data is untouched afterward.
 *
 * Everything is wrapped in a rolled-back transaction — the production data
 * is left exactly as imported. Skips per shuttle type when no candidate
 * factory matches (e.g. when run against an empty dev database).
 */
class ProdDataRealShuttleFillTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const MASUK_BASE = 30000; // far outside any real production value range

    /** @test */
    public function a_real_shuttle_3_factory_can_fill_its_next_month_correctly()
    {
        $this->fillNextMonthForRealShuttle('3');
    }

    /** @test */
    public function a_real_shuttle_4_factory_can_fill_its_next_month_correctly()
    {
        $this->fillNextMonthForRealShuttle('4');
    }

    /** @test */
    public function a_real_shuttle_5_factory_can_fill_its_next_month_correctly()
    {
        $this->fillNextMonthForRealShuttle('5');
    }

    private function fillNextMonthForRealShuttle(string $shuttleType): void
    {
        [$user, $shuttle, $bulan] = $this->findCandidate($shuttleType);
        if (!$user) {
            $this->markTestSkipped("No real shuttle-{$shuttleType} factory with a fillable next month found in this database.");
        }

        $prevMonth = $bulan - 1;
        $prevFormC = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $prevMonth)->first();
        $prevRowsBefore = KemasukanBahan::where('formcs_id', $prevFormC->id)
            ->get()
            ->mapWithKeys(fn ($r) => [$r->getAttributes()['spesis_id'] => (float) $r->baki_stok_kehadapan]);

        // The flow service must agree this month is fillable for this real factory.
        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttleType, self::YEAR);
        $this->assertTrue($flow['formC'][$bulan]['can_fill'],
            "Real shuttle {$shuttle->id} (type {$shuttleType}): month {$bulan} should be fillable. Reason: " . ($flow['formC'][$bulan]['reason'] ?? 'none'));

        // Fill every kayu group of the next month through the real routes.
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
                $kayuMasuk[$i] = self::MASUK_BASE + $s->id;
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
                'jumlah_besar_kayu_ke_dalam_jentera' => 0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ]);
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();
        }

        // 1. Every value must be on exactly the right species.
        $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
        $allSpecies = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        foreach ($allSpecies as $s) {
            $row = KemasukanBahan::where('formcs_id', $formc->id)->where('spesis_id', $s->id)->first();
            $this->assertNotNull($row,
                "Real shuttle {$shuttle->id} bulan {$bulan}: species {$s->id} ({$s->nama_spesis}) row missing.");
            $this->assertEquals(self::MASUK_BASE + $s->id, (float) $row->kayu_masuk,
                "Real shuttle {$shuttle->id} bulan {$bulan}: species {$s->id} ({$s->nama_spesis}) got the wrong value.");
        }

        $this->assertContains($formc->status, FormFlowService::SUBMITTED,
            "Real shuttle {$shuttle->id} bulan {$bulan}: Form C must be submitted after the fill.");

        // 2. The previous month's real production rows are untouched.
        $prevRowsAfter = KemasukanBahan::where('formcs_id', $prevFormC->id)
            ->get()
            ->mapWithKeys(fn ($r) => [$r->getAttributes()['spesis_id'] => (float) $r->baki_stok_kehadapan]);
        $this->assertEquals($prevRowsBefore->toArray(), $prevRowsAfter->toArray(),
            "Real shuttle {$shuttle->id}: filling month {$bulan} must not alter month {$prevMonth}'s existing production data.");
    }

    /**
     * Find a real, active IBK factory whose 2026 chain allows its next month
     * to be filled: Form A 2026 filled, some month M submitted with real
     * KemasukanBahan rows, month M+1 not yet submitted, M+1 within Jan-July,
     * and the previous quarter's Form B submitted when required.
     */
    private function findCandidate(string $shuttleType): array
    {
        $currentMonth = (int) date('n');

        $users = User::where('kategori_pengguna', 'IBK')
            ->where('status', 1)->where('is_approved', 1)
            ->whereHas('shuttle', fn ($q) => $q->where('shuttle_type', $shuttleType))
            ->get();

        foreach ($users as $user) {
            $shuttle = $user->shuttle;
            if (!$shuttle) {
                continue;
            }

            $formA = FormA::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)
                ->where('status', '!=', 'Tidak Diisi')->exists();
            if (!$formA) {
                continue;
            }

            $submittedMonths = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)
                ->whereIn('status', FormFlowService::SUBMITTED)
                ->pluck('bulan')->map(fn ($b) => (int) $b)->sort()->values();
            if ($submittedMonths->isEmpty()) {
                continue;
            }

            $lastSubmitted = $submittedMonths->last();
            $next = $lastSubmitted + 1;
            if ($next > $currentMonth || $next > 12) {
                continue;
            }

            $nextRow = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $next)->first();
            if ($nextRow && in_array($nextRow->status, FormFlowService::SUBMITTED)) {
                continue;
            }

            // Previous month must actually have real KemasukanBahan rows.
            $prevFormC = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $lastSubmitted)->first();
            if (!$prevFormC || !KemasukanBahan::where('formcs_id', $prevFormC->id)->exists()) {
                continue;
            }

            // Form B requirement for the next month's quarter.
            $prevSuku = FormFlowService::monthToSuku($next) - 1;
            if ($prevSuku >= 1) {
                $fbOk = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)
                    ->where('suku_tahun', $prevSuku)
                    ->whereIn('status', FormFlowService::SUBMITTED)->exists();
                if (!$fbOk) {
                    continue;
                }
            }

            return [$user, $shuttle, $next];
        }

        return [null, null, null];
    }
}
