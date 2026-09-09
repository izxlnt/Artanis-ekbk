<?php

namespace Tests\Feature;

use App\Models\FormB;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression test for a real bug reported from a production screenshot: the
 * read-only Form B view listed categories in reverse order (Pekerja Kilang
 * Yang Diambil Bekerja Melalui Kontraktor first, Pemilik dan Rakan Kongsi
 * last) instead of the canonical 1-8 order shown on the fill-in form. Each
 * row's label was still correctly paired with its own values (via the
 * kategori_guna_tenaga relationship), so this wasn't data corruption - but
 * ViewFormBController built $form_b with orderBy('id','desc') (meant only
 * to pick the newest row when a category has duplicate rows) and that same
 * order leaked into the display, reversing it since rows are normally
 * created in ascending category order. Fixed by re-sorting the deduped
 * collection by kategori_guna_tenaga_id before display.
 */
class FormBViewRowOrderTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SUKU = 1;

    /** @test */
    public function shuttle_3_form_b_view_lists_categories_in_canonical_order()
    {
        $this->runForShuttle('3', \App\Http\Livewire\ShuttleThree\FormB::class, 'user.shuttle-3-formB', 'pengguna.shuttle-3-view-formB');
    }

    /** @test */
    public function shuttle_4_form_b_view_lists_categories_in_canonical_order()
    {
        $this->runForShuttle('4', \App\Http\Livewire\ShuttleFour\FormB::class, 'user.shuttle-4-formB', 'pengguna.shuttle-3-view-formB');
    }

    /** @test */
    public function shuttle_5_form_b_view_lists_categories_in_canonical_order()
    {
        $this->runForShuttle('5', \App\Http\Livewire\ShuttleFive\FormB::class, 'user.shuttle-5-formB', 'pengguna.shuttle-3-view-formB');
    }

    /** @test */
    public function phd_dedicated_form_b_view_lists_categories_in_canonical_order()
    {
        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => '3']);
        $user->shuttle_type = '3';
        $user->save();
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $kategori = KategoriGunaTenaga::orderBy('id')->get();

        $this->actingAs($user)->get(route('user.shuttle-3-formB', [self::SUKU, self::YEAR]))->assertOk();

        $test = Livewire::actingAs($user)->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            $test->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)->set("gaji_lelaki.{$i}", 5000);
        }
        $test->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $this->assertNotNull($formb, 'FormB row missing after submit.');

        // PHD's own dedicated view route (phd.shuttle-3-view-formB-phd) is
        // gated by the 'phd' middleware, which redirects any non-PHD role
        // away - it must be visited as a PHD user, not the IBK who filled
        // the form.
        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);
        $html = $this->actingAs($phd)->get(route('phd.shuttle-3-view-formB-phd', $formb->id))->assertOk()->getContent();

        $lastPos = -1;
        foreach ($kategori as $k) {
            $pos = strpos($html, $k->keterangan);
            $this->assertNotFalse($pos, "PHD view: category '{$k->keterangan}' not found in the view.");
            $this->assertGreaterThan($lastPos, $pos,
                "PHD view: category '{$k->keterangan}' (id {$k->id}) rendered out of order - "
                . "the read-only view must list categories 1-8 in the same order as the fill-in form, not reversed.");
            $lastPos = $pos;
        }
    }

    private function runForShuttle(string $shuttleType, string $formBComponent, string $fillRouteName, string $viewRouteName): void
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
        $this->assertNotNull($formb, "Shuttle {$shuttleType}: FormB row missing after submit.");

        $html = $this->actingAs($user)->get(route($viewRouteName, $formb->id))->assertOk()->getContent();

        // The category labels must appear in the same order as their ids
        // (1. Pemilik dan Rakan Kongsi ... 8. Pekerja Kilang Yang Diambil
        // Bekerja Melalui Kontraktor), not reversed.
        $lastPos = -1;
        foreach ($kategori as $k) {
            $pos = strpos($html, $k->keterangan);
            $this->assertNotFalse($pos, "Shuttle {$shuttleType}: category '{$k->keterangan}' not found in the view.");
            $this->assertGreaterThan($lastPos, $pos,
                "Shuttle {$shuttleType}: category '{$k->keterangan}' (id {$k->id}) rendered out of order - "
                . "the read-only view must list categories 1-8 in the same order as the fill-in form, not reversed.");
            $lastPos = $pos;
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
            'no_ssm' => 'SSM-ROW-ORDER-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'row-order-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-ROW-ORDER-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
}
