<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormC;
use App\Models\KemasukanBahan;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Regression test for month-to-month carry-forward across a running chain of
 * months (Jan -> Feb -> Mar), for every shuttle type.
 *
 * This goes beyond a single hop: it proves the "baki stok dari bulan lepas"
 * shown on month N+1 is always exactly month N's closing stock (never stale
 * data from two months back, never zero once real data exists, never another
 * species' value), for every kayu group, walking the chain one step at a time.
 */
class FormCMultiMonthCarryForwardTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const MONTHS = [1, 2, 3];

    private $stages = [
        ['kayu_id' => 1, 'segment' => 'KKB', 'route' => 'KKB'],
        ['kayu_id' => 2, 'segment' => 'KKS', 'route' => 'KKS'],
        ['kayu_id' => 3, 'segment' => 'KKR', 'route' => 'KKR'],
        ['kayu_id' => 4, 'segment' => 'KayuLembut', 'route' => 'KayuLembut'],
        ['kayu_id' => 5, 'segment' => 'LainLain', 'route' => 'LainLain'],
    ];

    /** @test */
    public function shuttle_3_carries_forward_stock_correctly_across_a_chain_of_months()
    {
        $this->runChain('3');
    }

    /** @test */
    public function shuttle_4_carries_forward_stock_correctly_across_a_chain_of_months()
    {
        $this->runChain('4');
    }

    /** @test */
    public function shuttle_5_carries_forward_stock_correctly_across_a_chain_of_months()
    {
        $this->runChain('5');
    }

    private function runChain(string $shuttleType): void
    {
        $prefix = "shuttle-{$shuttleType}-formC";

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

        FormA::create([
            'shuttle_id' => $shuttle->id,
            'tahun' => self::YEAR,
            'status' => 'Lengkap',
        ]);

        foreach (self::MONTHS as $bulan) {
            Batch::create([
                'shuttle_id' => $shuttle->id,
                'tahun' => self::YEAR,
                'bulan' => $bulan,
                'status' => 'Sedang Diproses',
                'borang_a' => 1,
            ]);

            // Shuttle 4/5's view controllers expect the month's FormC row to
            // already exist (plain ->first(), no firstOrCreate).
            FormC::create([
                'shuttle_id' => $shuttle->id,
                'shuttle_type' => $shuttleType,
                'tahun' => self::YEAR,
                'bulan' => $bulan,
                'status' => 'Tidak Diisi',
            ]);
        }

        $this->actingAs($user);

        // closingStock(month, speciesId) — deterministic and unique per
        // month+species, so any reuse of a stale month's value, or a swap
        // between species, is immediately visible.
        $closingStock = fn (int $bulan, int $speciesId) => $bulan * 100000 + $speciesId;

        foreach ($this->stages as $stage) {
            $species = Spesis::orderBy('kumpulan_kayu_id')
                ->where('kumpulan_kayu_id', $stage['kayu_id'])
                ->get()
                ->values();
            $count = $species->count();

            foreach (self::MONTHS as $monthIndex => $bulan) {
                $viewRoute = "user.view.{$prefix}.{$stage['route']}";
                $storeRoute = "user.view.{$prefix}.{$stage['route']}.store";

                $getResponse = $this->get(route($viewRoute, [$bulan, self::YEAR]));
                $getResponse->assertOk("Shuttle {$shuttleType} {$stage['segment']} bulan={$bulan} view page did not load.");

                $bakiStoks = $getResponse->viewData('baki_stoks');

                if ($monthIndex === 0) {
                    // First month in the chain: nothing to carry forward yet.
                    foreach ($species as $i => $s) {
                        $this->assertEquals(0, (float) ($bakiStoks[$i] ?? 0),
                            "Shuttle {$shuttleType} {$stage['segment']} bulan={$bulan}: species #{$s->id} should start with 0 stock (no prior month).");
                    }
                } else {
                    $previousBulan = self::MONTHS[$monthIndex - 1];
                    foreach ($species as $i => $s) {
                        $expected = $closingStock($previousBulan, $s->id);
                        $this->assertEquals(
                            $expected,
                            (float) ($bakiStoks[$i] ?? null),
                            "Shuttle {$shuttleType} {$stage['segment']} bulan={$bulan}: species #{$s->id} ({$s->nama_tempatan}) ".
                            "must carry forward bulan={$previousBulan}'s closing stock ({$expected}), not stale/zero/mismatched data."
                        );
                    }
                }

                // Now fill this month with its own distinct closing stock per species.
                $bakiStokKehadapan = [];
                foreach ($species as $i => $s) {
                    $bakiStokKehadapan[$i] = $closingStock($bulan, $s->id);
                }
                $zeroFill = array_fill(0, $count, 0);

                $postResponse = $this->post(route($storeRoute, [$bulan, self::YEAR]), [
                    'baki_stoks' => $bakiStoks ?: $zeroFill,
                    'kayu_masuk' => $zeroFill,
                    'jumlah_stok_kayu_balak' => $bakiStokKehadapan,
                    'proses_masuk' => $zeroFill,
                    'proses_keluar' => $zeroFill,
                    'baki_stok_kehadapan' => $bakiStokKehadapan,
                    'jumlah_baki_stok' => $zeroFill,
                    'jumlah_kayu_masuk' => $zeroFill,
                    'total_stok_kayu_balak' => $zeroFill,
                    'total_kayu_masuk_jentera' => $zeroFill,
                    'total_kayu_keluar_jentera' => $zeroFill,
                    'total_kayu_dibawa_bulan_hadapan' => $bakiStokKehadapan,
                    'jumlah_besar_baki_stok_bulan_lepas' => 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                    'jumlah_besar_stok_kayu_balak' => 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                    'jumlah_besar_baki_stok_bulan_depan' => 0,
                ]);

                $postResponse->assertSessionDoesntHaveErrors();

                $formc = FormC::where('shuttle_id', $shuttle->id)
                    ->where('tahun', self::YEAR)
                    ->where('bulan', $bulan)
                    ->first();

                $saved = KemasukanBahan::where('formcs_id', $formc->id)
                    ->whereHas('spesis_id', fn ($q) => $q->where('kumpulan_kayu_id', $stage['kayu_id']))
                    ->get()
                    ->keyBy(fn ($item) => $item->getAttributes()['spesis_id']);

                foreach ($species as $s) {
                    $this->assertTrue($saved->has($s->id),
                        "Shuttle {$shuttleType} {$stage['segment']} bulan={$bulan}: no saved row for species #{$s->id}.");
                    $this->assertEquals(
                        $closingStock($bulan, $s->id),
                        (float) $saved[$s->id]->baki_stok_kehadapan,
                        "Shuttle {$shuttleType} {$stage['segment']} bulan={$bulan}: species #{$s->id} closing stock was not saved correctly."
                    );
                }

                // Scramble this month's storage order (delete + recreate in
                // REVERSE species order) before moving to the next month.
                // The store() endpoint always inserts in species order, which
                // never reproduces the positional-matching bug on its own —
                // real-world data (edits, migrations) doesn't stay that tidy.
                // This proves the fix holds even when it isn't tidy.
                $formcId = $formc->id;
                $kayuId = $stage['kayu_id'];
                KemasukanBahan::where('formcs_id', $formcId)
                    ->whereHas('spesis_id', fn ($q) => $q->where('kumpulan_kayu_id', $kayuId))
                    ->delete();
                foreach ($species->reverse()->values() as $s) {
                    $data = $saved[$s->id];
                    KemasukanBahan::create([
                        'spesis_id' => $s->id,
                        'shuttle_id' => $shuttle->id,
                        'bulan' => $bulan,
                        'tahun' => self::YEAR,
                        'formcs_id' => $formcId,
                        'baki_stok' => $data->baki_stok,
                        'kayu_masuk' => $data->kayu_masuk,
                        'baki_stok_kehadapan' => $data->baki_stok_kehadapan,
                        'total_kayu_dibawa_bulan_hadapan' => $data->total_kayu_dibawa_bulan_hadapan,
                        'jumlah_stok_kayu_balak' => $data->jumlah_stok_kayu_balak,
                    ]);
                }
            }
        }
    }
}
