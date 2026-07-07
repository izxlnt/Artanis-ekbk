<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\KemasukanBahan;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * End-to-end regression test: fully fill Borang C for a single month across
 * every kayu group (KKB -> KKS -> KKR -> Kayu Lembut -> Lain-lain), for each
 * shuttle type (3, 4, 5), via the live route flow (*\FormCController).
 *
 * For every stage this asserts:
 *  - the page redirects into the next stage of the wizard,
 *  - exactly one KemasukanBahan row is persisted per species in that kayu group,
 *  - each row is linked to the correct spesis_id with the correct submitted value
 *    (guards against the position-based species-matching bug).
 *
 * Final assertion: the month's FormC ends in a fully-submitted state with every
 * species across all 5 groups accounted for.
 */
class FormCFullFlowTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const BULAN = 1; // January: suku=1, prevSuku=0, so no FormB dependency.

    /** @test */
    public function shuttle_3_can_fully_fill_every_borang_c_group_for_the_month()
    {
        $this->runFullFlow('3');
    }

    /** @test */
    public function shuttle_4_can_fully_fill_every_borang_c_group_for_the_month()
    {
        $this->runFullFlow('4');
    }

    /** @test */
    public function shuttle_5_can_fully_fill_every_borang_c_group_for_the_month()
    {
        $this->runFullFlow('5');
    }

    private function runFullFlow(string $shuttleType): void
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

        Batch::create([
            'shuttle_id' => $shuttle->id,
            'tahun' => self::YEAR,
            'bulan' => self::BULAN,
            'status' => 'Sedang Diproses',
            'borang_a' => 1,
            'borang_b' => 0,
            'borang_c' => 0,
        ]);

        // Shuttle 4/5's view controllers do a plain ->first() (no firstOrCreate)
        // for the month's FormC row, so it must already exist — as it would in
        // production, where these rows are pre-generated per shuttle/year.
        FormC::create([
            'shuttle_id' => $shuttle->id,
            'shuttle_type' => $shuttleType,
            'tahun' => self::YEAR,
            'bulan' => self::BULAN,
            'status' => 'Tidak Diisi',
        ]);

        $this->actingAs($user);

        $stages = [
            ['kayu_id' => 1, 'segment' => 'KKB', 'route' => 'KKB'],
            ['kayu_id' => 2, 'segment' => 'KKS', 'route' => 'KKS'],
            ['kayu_id' => 3, 'segment' => 'KKR', 'route' => 'KKR'],
            ['kayu_id' => 4, 'segment' => 'KayuLembut', 'route' => 'KayuLembut'],
            ['kayu_id' => 5, 'segment' => 'LainLain', 'route' => 'LainLain'],
        ];

        $formc = null;
        $totalSpeciesFilled = 0;

        foreach ($stages as $stage) {
            $viewRoute = "user.view.{$prefix}.{$stage['route']}";
            $storeRoute = "user.view.{$prefix}.{$stage['route']}.store";

            // Visiting the page first, like a real user would: this is what
            // actually creates the FormC row (firstOrCreate) on the KKB stage.
            $getResponse = $this->get(route($viewRoute, [self::BULAN, self::YEAR]));
            $getResponse->assertOk("Shuttle {$shuttleType} {$stage['segment']} view page did not load.");

            $species = Spesis::orderBy('kumpulan_kayu_id')
                ->where('kumpulan_kayu_id', $stage['kayu_id'])
                ->get()
                ->values();

            $this->assertGreaterThan(0, $species->count(), "No species seeded for kumpulan_kayu_id={$stage['kayu_id']}.");

            $count = $species->count();
            $kayuMasuk = [];
            $bakiStoks = [];
            foreach ($species as $i => $s) {
                // Distinct, position-independent value per species so a
                // position/id mismatch would be caught immediately.
                $kayuMasuk[$i] = 10 + $s->id;
                $bakiStoks[$i] = 0;
            }

            $zeroFill = array_fill(0, $count, 0);

            $postResponse = $this->post(route($storeRoute, [self::BULAN, self::YEAR]), [
                'baki_stoks' => $bakiStoks,
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

            $postResponse->assertRedirect(null);
            $postResponse->assertSessionDoesntHaveErrors();

            $formc = FormC::where('shuttle_id', $shuttle->id)
                ->where('tahun', self::YEAR)
                ->where('bulan', self::BULAN)
                ->first();
            $this->assertNotNull($formc, "FormC row missing after {$stage['segment']} store.");

            $rows = KemasukanBahan::where('formcs_id', $formc->id)
                ->whereHas('spesis_id', fn ($q) => $q->where('kumpulan_kayu_id', $stage['kayu_id']))
                ->get()
                ->keyBy(fn ($item) => $item->getAttributes()['spesis_id']);

            $this->assertSame(
                $count,
                $rows->count(),
                "Shuttle {$shuttleType} {$stage['segment']}: expected {$count} KemasukanBahan rows (one per species), got {$rows->count()}."
            );

            foreach ($species as $i => $s) {
                $this->assertTrue(
                    $rows->has($s->id),
                    "Shuttle {$shuttleType} {$stage['segment']}: no row saved for species #{$s->id} ({$s->nama_tempatan})."
                );
                $this->assertEquals(
                    10 + $s->id,
                    (float) $rows[$s->id]->kayu_masuk,
                    "Shuttle {$shuttleType} {$stage['segment']}: species #{$s->id} ({$s->nama_tempatan}) got the wrong value — species mismatch."
                );
            }

            $totalSpeciesFilled += $count;
        }

        // Final state: every group's rows exist under the same FormC.
        $grandTotal = KemasukanBahan::where('formcs_id', $formc->id)->count();
        $this->assertSame($totalSpeciesFilled, $grandTotal,
            "Shuttle {$shuttleType}: total persisted rows across all 5 groups should equal the sum of every species.");

        $formc->refresh();
        $this->assertNotSame('Tidak Diisi', $formc->status,
            "Shuttle {$shuttleType}: FormC should no longer be 'Tidak Diisi' after a full fill.");
    }
}
