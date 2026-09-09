<?php

namespace Tests\Feature;

use App\Models\FormA;
use App\Models\FormB;
use App\Models\GunaTenaga;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression test for a real bug: once IBK submitted Form B, none of the
 * three shuttle types' fill routes blocked revisiting the same fill page.
 * For Shuttle 4/5, FormB's own mount() only reloads saved values when
 * status is exactly "Tidak Lengkap" - for any other submitted status
 * (Sedang Diproses, Dihantar ke IPJPSM, Lulus) every field showed blank,
 * so pressing submit again on that page would silently overwrite real
 * data with zeros. Shuttle 3 reloads real data regardless of status, so
 * it wasn't destructive the same way, but could still silently re-save
 * (and reset the status of) an already-reviewed/approved quarter.
 *
 * This test confirms two things fixed together:
 *  1. GET on the fill route redirects to the read-only view once the
 *     quarter is already submitted, instead of rendering the fillable
 *     form.
 *  2. Even if the Livewire component is reached directly with blank
 *     state (a stale page opened before the redirect existed, or via the
 *     back button), store() itself refuses to save over an
 *     already-submitted quarter.
 */
class FormBLockedAfterSubmissionTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SUKU = 1;

    /** @test */
    public function shuttle_3_form_b_is_locked_after_submission()
    {
        $this->runForShuttle('3', \App\Http\Livewire\ShuttleThree\FormB::class, 'user.shuttle-3-formB');
    }

    /** @test */
    public function shuttle_4_form_b_is_locked_after_submission()
    {
        $this->runForShuttle('4', \App\Http\Livewire\ShuttleFour\FormB::class, 'user.shuttle-4-formB');
    }

    /** @test */
    public function shuttle_5_form_b_is_locked_after_submission()
    {
        $this->runForShuttle('5', \App\Http\Livewire\ShuttleFive\FormB::class, 'user.shuttle-5-formB');
    }

    private function runForShuttle(string $shuttleType, string $formBComponent, string $fillRouteName): void
    {
        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $kategori = KategoriGunaTenaga::orderBy('id')->get();

        $this->actingAs($user)->get(route($fillRouteName, [self::SUKU, self::YEAR]))->assertOk();

        $test = Livewire::actingAs($user)->test($formBComponent, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            $test->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)->set("gaji_lelaki.{$i}", 5000);
        }
        $test->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $this->assertNotNull($formb, "Shuttle {$shuttleType}: FormB row missing after initial submit.");
        $this->assertSame('Sedang Diproses', $formb->status, "Shuttle {$shuttleType}: expected Sedang Diproses after initial submit.");

        // ── 1. GET the fill route again - must redirect away, not render
        // the fillable form. ─────────────────────────────────────────────
        $this->actingAs($user)->get(route($fillRouteName, [self::SUKU, self::YEAR]))
            ->assertRedirect(route('pengguna.shuttle-3-view-formB', $formb->id));

        // ── 2. Even bypassing the controller entirely (a stale page or a
        // direct Livewire hit), store() must refuse to overwrite already
        // -submitted data. ──────────────────────────────────────────────
        $stale = Livewire::actingAs($user)->test($formBComponent, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        $stale->call('store');

        $formb->refresh();
        $this->assertSame('Sedang Diproses', $formb->status,
            "Shuttle {$shuttleType}: a stale/direct store() call must not change an already-submitted quarter's status.");

        $rows = GunaTenaga::where('formbs_id', $formb->id)->get()->keyBy('kategori_guna_tenaga_id');
        foreach ($kategori as $k) {
            $row = $rows->get($k->id);
            $this->assertNotNull($row, "Shuttle {$shuttleType}: category {$k->id} row disappeared after the stale store() call.");
            $this->assertSame(100 + $k->id, (int) $row->pekerja_wargabumi_lelaki,
                "Shuttle {$shuttleType}: category {$k->id} ({$k->keterangan}) was overwritten by a stale store() call on an already-submitted quarter - "
                . "this is the exact data-loss bug reported (blank reload + resubmit wipes real data).");
        }
    }

    private function fillFormA(User $user, $shuttle): void
    {
        $hakMilik = HakMilik::first();
        $this->actingAs($user)->get(route("user.shuttle-{$user->shuttle_type}-formA"))->assertOk();
        $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM-LOCK-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'lock-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-LOCK-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
}
