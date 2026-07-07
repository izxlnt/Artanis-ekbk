<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\RecoveryRate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression test for the "Tiada Pengeluaran" (no production this month)
 * button on Form C. This is a separate code path from the normal
 * fill-every-species store flow: it directly marks the month's Form C as
 * 'Tiada Pengeluaran', zero-fills every species' KemasukanBahan row (using
 * the same spesis_id-keyed carry-forward lookup as the normal store flow),
 * and flips the month's Batch row to submitted. It had no test coverage
 * before this file. Also chains into month 2 to exercise the "last month"
 * lookup branch (only taken when bulan_id != 1).
 */
class TiadaPengeluaranTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function shuttle_3_can_mark_form_c_as_tiada_pengeluaran_for_two_consecutive_months()
    {
        $this->assertTiadaPengeluaranWorksAcrossTwoMonths('3');
    }

    /** @test */
    public function shuttle_4_can_mark_form_c_as_tiada_pengeluaran_for_two_consecutive_months()
    {
        $this->assertTiadaPengeluaranWorksAcrossTwoMonths('4');
    }

    /** @test */
    public function shuttle_5_can_mark_form_c_as_tiada_pengeluaran_for_two_consecutive_months()
    {
        $this->assertTiadaPengeluaranWorksAcrossTwoMonths('5');
    }

    private function assertTiadaPengeluaranWorksAcrossTwoMonths(string $shuttleType): void
    {
        $user = $this->makeUser($shuttleType);
        $shuttle = $user->shuttle;

        $this->fillFormA($user, $shuttle, $shuttleType);
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 1);

        foreach ([1, 2] as $bulan) {
            $prefix = "shuttle-{$shuttleType}-formC";

            Batch::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['status' => 'Sedang Diproses', 'borang_a' => 1]
            );
            // Shuttle 4/5's Form C view controllers expect the month's FormC
            // row to already exist (plain ->first(), no firstOrCreate).
            FormC::firstOrCreate(
                ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
                ['shuttle_type' => $shuttleType, 'status' => 'Tidak Diisi']
            );

            // Visiting the KKB view page is what a real IBK user does before
            // seeing the "Tiada Pengeluaran" button; this also auto-creates
            // the month's Form C row (firstOrCreate) that the button's route
            // requires to already exist.
            $this->actingAs($user)
                ->get(route("user.view.{$prefix}.KKB", [$bulan, self::YEAR]))
                ->assertOk();

            $response = $this->actingAs($user)
                ->get(route("user.{$prefix}.tiadaPengeluaran", [$bulan, self::YEAR]));
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();
            $this->assertFalse(
                $response->getSession()->has('error'),
                "Shuttle {$shuttleType} bulan={$bulan}: Tiada Pengeluaran should not be rejected: " . $response->getSession()->get('error')
            );

            $formc = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($formc, "Shuttle {$shuttleType} bulan={$bulan}: Form C row must exist.");
            $this->assertSame('Tiada Pengeluaran', $formc->status,
                "Shuttle {$shuttleType} bulan={$bulan}: Form C status should be Tiada Pengeluaran.");
            $this->assertSame(1, (int) $formc->tiada_pengeluaran);

            $batch = Batch::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', $bulan)->first();
            $this->assertNotNull($batch);
            $this->assertSame(1, (int) $batch->borang_c,
                "Shuttle {$shuttleType} bulan={$bulan}: Batch borang_c should be marked submitted (1).");

            $speciesCount = \App\Models\Spesis::count();
            $rowCount = \App\Models\KemasukanBahan::where('shuttle_id', $shuttle->id)->where('formcs_id', $formc->id)->count();
            $this->assertSame($speciesCount, $rowCount,
                "Shuttle {$shuttleType} bulan={$bulan}: every species must have a zero-filled KemasukanBahan row.");
        }
    }

    // ── Shared setup helpers (same conventions as FullFormChainTest) ──────

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
        $viewRoute = "user.shuttle-{$shuttleType}-formB";
        $this->actingAs($user)->get(route($viewRoute, [$suku, self::YEAR]))->assertOk();

        KategoriGunaTenaga::get();

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
