<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\Form5D;
use App\Models\FormA;
use App\Models\JenisKayu;
use App\Models\PengeluaranForm5D;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Regression test for a real bug reported from a production screenshot:
 * once PHD had already decided a Form 5D (moved its status past "Sedang
 * Diproses"), the "Status Borang 5D" listing page's action icon still
 * routed back to the fully-actionable verification page - which itself had
 * no status gate at all, so its SIMPAN/TIDAK LENGKAP buttons stayed live
 * and PHD could silently flip an already-decided form's status again. This
 * was worst for a "Dihantar ke IPJPSM" form whose package hadn't been sent
 * onward yet: the listing correctly showed "Pakej Belum Dihantar", but the
 * action icon right next to it still said "Borang perlu disahkan PHD" and
 * led to the actionable page as if nothing had happened yet.
 */
class PhdFormDDecisionButtonsHiddenAfterDecisionTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function decision_buttons_disappear_once_phd_has_decided_and_listing_routes_to_the_read_only_view()
    {
        $ibk = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $ibk->shuttle;
        $shuttle->update(['shuttle_type' => '5']);

        $phd = $this->makeReviewerUser('PHD');
        $daerah = Daerah::firstOrFail();
        $shuttle->update(['daerah_id' => $daerah->id]);
        $phd->update(['daerah' => $daerah->daerah_hutan]);

        // shuttle_5_formD_view() gates on FormA already being reviewed, plus
        // (for bulan > 1) the previous month's Form5D - bulan=1 sidesteps
        // the second gate, and this FormA satisfies the first.
        FormA::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR,
            'status' => 'Dihantar ke IPJPSM', 'nama_kilang' => $shuttle->nama_kilang,
            'no_ssm' => 'A-5-TEST', 'no_lesen' => 'LA-5-TEST',
        ]);

        $form5d = Form5D::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR, 'bulan' => 1,
            'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
            'no_ssm' => 'D-5-TEST', 'no_lesen' => 'LD-5-TEST',
        ]);

        // view-form5d.blade.php indexes $form_5d by position to match each
        // JenisKayu row, so it needs one PengeluaranForm5D row per species
        // to render at all.
        foreach (JenisKayu::all() as $jenis) {
            PengeluaranForm5D::create([
                'form5ds_id' => $form5d->id, 'jenis_kayu_id' => $jenis->id,
                'pengeluaran_kayu' => 0, 'total_jumlah_pengeluaran' => 0,
            ]);
        }

        // While still pending, PHD's actionable page must show the decision buttons.
        $htmlBefore = $this->actingAs($phd)->get(route('phd.shuttle-5-view-formD', $form5d->id))->assertOk()->getContent();
        $this->assertStringContainsString('SIMPAN</button>', $htmlBefore);
        $this->assertStringContainsString('TIDAK LENGKAP</button>', $htmlBefore);

        // PHD approves it.
        $this->actingAs($phd)->post(route('update_status_form5D', $form5d->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $form5d->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $form5d->status);

        // The listing page must now route this row's action icon to the
        // read-only "-phd" view, not the still-actionable one - regardless
        // of whether the package has been sent onward yet (no Batch row
        // exists in this test, matching the "Pakej Belum Dihantar" case
        // from the screenshot).
        $listHtml = $this->actingAs($phd)->get(route('phd.senarai-tugasan-5D', self::YEAR))->assertOk()->getContent();
        $this->assertStringContainsString(route('phd.shuttle-5-view-formD-phd', $form5d->id), $listHtml,
            'An already-decided Form 5D must route to the read-only view from the listing page.');
        $this->assertStringNotContainsString('href="' . route('phd.shuttle-5-view-formD', $form5d->id) . '"', $listHtml,
            'An already-decided Form 5D must not still link to the actionable view from the listing page.');

        // Both the actionable AND the read-only view must no longer show
        // the decision buttons for an already-decided form - a PHD who
        // still lands on the actionable page (e.g. a stale link) must not
        // be able to silently flip its status again.
        foreach (['phd.shuttle-5-view-formD', 'phd.shuttle-5-view-formD-phd'] as $routeName) {
            $html = $this->actingAs($phd)->get(route($routeName, $form5d->id))->assertOk()->getContent();
            $this->assertStringNotContainsString('SIMPAN</button>', $html,
                "{$routeName}: an already-decided form must not offer the Sahkan action again.");
            $this->assertStringNotContainsString('TIDAK LENGKAP</button>', $html,
                "{$routeName}: an already-decided form must not offer the Tidak Lengkap action again.");
            $this->assertStringContainsString('telah pun disahkan', $html,
                "{$routeName}: should show a plain already-decided message instead.");
        }
    }

    private function makeReviewerUser(string $kategoriPengguna): User
    {
        $unique = uniqid();

        return User::create([
            'name' => $kategoriPengguna . ' Reviewer',
            'email' => strtolower($kategoriPengguna) . '-' . $unique . '@example.com',
            'login_id' => strtolower($kategoriPengguna) . '-' . $unique,
            'password' => Hash::make('password'),
            'kategori_pengguna' => $kategoriPengguna,
            'status' => 1,
            'is_approved' => 1,
        ]);
    }
}
