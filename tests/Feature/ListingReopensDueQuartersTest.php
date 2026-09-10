<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\FormB;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Regression test for a real bug reported from production: on
 * /phd/shuttle-5-listB/2026 (and its shuttle 3/4 and JPN/IPJPSM siblings),
 * the "Suku Ketiga" and "Suku Keempat" columns showed nothing at all for
 * most factories, even though those quarters had already opened.
 *
 * Root cause: every FormB row for a factory's four quarters is created up
 * front when the IBK's registration is approved (see
 * PermohonanPenggunaController), and any quarter that hasn't started yet AT
 * THAT TIME is seeded with a placeholder status of "Ditutup" - a value that
 * is never revisited afterwards except by the IBK's own fill-page
 * controller, which flips a single row from "Ditutup" to "Tidak Diisi" only
 * once that specific IBK actually opens it (see e.g.
 * ShuttleFive\MainController::shuttle_5_formB). These listing/status-grid
 * pages read the raw rows directly and their Blade templates have no
 * "Ditutup" branch at all (confirmed already correctly handled for the
 * newer "borang keseluruhan" pages via partials.cell-borang-quarterly,
 * whose comment literally documents this exact seeded-placeholder problem)
 * - so a quarter that has genuinely opened, but that its IBK hasn't visited
 * yet, renders as a blank cell here instead of the correct "belum diisi"
 * icon.
 *
 * The fix is FormB::reopenDueQuarters(), called from every listing
 * controller right before it queries FormB for display: it bulk-flips any
 * "Ditutup" row whose tarikh_buka_borang has already passed to "Tidak
 * Diisi", exactly mirroring what the IBK fill-page controllers already do
 * for a single row.
 */
class ListingReopensDueQuartersTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function phd_shuttle_3_listing_reopens_a_due_quarter()
    {
        $this->assertListingReopensDueQuarter('3', 'phd.shuttle-3-listB', fn($phd) => $phd);
    }

    /** @test */
    public function phd_shuttle_4_listing_reopens_a_due_quarter()
    {
        $this->assertListingReopensDueQuarter('4', 'phd.shuttle-4-listB', fn($phd) => $phd);
    }

    /** @test */
    public function phd_shuttle_5_listing_reopens_a_due_quarter()
    {
        $this->assertListingReopensDueQuarter('5', 'phd.shuttle-5-listB', fn($phd) => $phd);
    }

    /** @test */
    public function jpn_shuttle_3_listing_reopens_a_due_quarter()
    {
        $this->assertListingReopensDueQuarter('3', 'jpn.shuttle-3-listB-jpn', fn($phd, $shuttle) => $this->makeJpn($shuttle));
    }

    /** @test */
    public function ipjpsm_shuttle_5_listing_reopens_a_due_quarter()
    {
        // This older IPJPSM view spells the "not filled in" tooltip
        // differently ("tidak diisi" instead of "belum diisi") from its
        // PHD/JPN siblings.
        $this->assertListingReopensDueQuarter('5', 'shuttle-5-listB', fn($phd, $shuttle) => $this->makeIpjpsm(), 'Borang tidak diisi');
    }

    /** @test */
    public function a_quarter_that_has_not_opened_yet_shows_the_closed_icon_instead_of_a_blank_cell()
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd('5');

        $formb = FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR,
            'suku_tahun' => 4, 'status' => 'Ditutup',
            'tarikh_buka_borang' => '2026-12-01', 'tarikh_tutup_borang' => '2026-12-31',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'B-DITUTUP-FUTURE', 'no_lesen' => 'LB-DITUTUP-FUTURE',
        ]);

        // Reported from a production screenshot: months/quarters that
        // genuinely have not opened yet (e.g. Oct/Nov/Dec while it's still
        // September) rendered as a completely blank cell instead of the
        // grey "Borang ditutup" calendar icon every other status already
        // gets. The seeded placeholder "Ditutup" is still normalized away
        // to "Tidak Diisi" (nothing distinguishes the two anywhere else -
        // see FormB::reopenDueQuarters()'s docblock) - it's the view's own
        // "Tidak Diisi" branch, with its own tarikh_buka_borang check, that
        // must now correctly draw the closed icon instead of nothing.
        $html = $this->actingAs($phd)->get(route('phd.shuttle-5-listB', self::YEAR))->assertOk()->getContent();

        $this->assertSame('Tidak Diisi', $formb->fresh()->status);
        $this->assertStringContainsString('Borang ditutup', $html,
            'A quarter that has not opened yet must show the closed/calendar icon, not render as a blank cell.');
        $this->assertStringNotContainsString('Borang belum diisi', $html,
            'A quarter that has not opened yet must not show the "belum diisi" icon - it has not started, no one has failed to fill it in.');
    }

    private function assertListingReopensDueQuarter(string $shuttleType, string $routeName, \Closure $makeViewer, string $expectedTitle = 'Borang belum diisi'): void
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd($shuttleType);
        $viewer = $makeViewer($phd, $shuttle);

        // Quarter 3 (Jul-Sep) opened on 1 Sep, well before "today" (10 Sep
        // 2026 per the test clock), but this factory's IBK never visited
        // their own fill page for it - so it is still sitting at the seeded
        // "Ditutup" placeholder, exactly like the real production data.
        $formb = FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => $shuttleType, 'tahun' => self::YEAR,
            'suku_tahun' => 3, 'status' => 'Ditutup',
            'tarikh_buka_borang' => '2026-09-01', 'tarikh_tutup_borang' => '2026-10-01',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'B-DITUTUP-DUE-' . $shuttleType . '-' . $routeName,
            'no_lesen' => 'LB-DITUTUP-DUE-' . $shuttleType,
        ]);

        $html = $this->actingAs($viewer)->get(route($routeName, self::YEAR))->assertOk()->getContent();

        $this->assertSame('Tidak Diisi', $formb->fresh()->status,
            "{$routeName}: a quarter whose open date has already passed must be reopened from the seeded \"Ditutup\" placeholder so it renders correctly.");
        $this->assertStringContainsString($expectedTitle, $html,
            "{$routeName}: the reopened quarter must show the \"belum diisi\" icon instead of rendering as a blank cell.");
    }

    /** @return array{0: \App\Models\Shuttle, 1: User} */
    private function makeShuttleAndPhd(string $shuttleType): array
    {
        $ibk = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $ibk->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);

        $daerah = Daerah::firstOrFail();
        $shuttle->update(['daerah_id' => $daerah->id]);

        $phd = User::create([
            'name' => 'PHD Reviewer', 'email' => 'phd-reopen-' . uniqid() . '@example.com',
            'login_id' => 'phd-reopen-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1, 'daerah' => $daerah->daerah_hutan,
        ]);

        return [$shuttle, $phd];
    }

    private function makeJpn($shuttle): User
    {
        return User::create([
            'name' => 'JPN Reviewer', 'email' => 'jpn-reopen-' . uniqid() . '@example.com',
            'login_id' => 'jpn-reopen-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'JPN', 'status' => 1, 'is_approved' => 1, 'negeri' => $shuttle->negeri_id,
        ]);
    }

    private function makeIpjpsm(): User
    {
        return User::create([
            'name' => 'IPJPSM Reviewer', 'email' => 'ipjpsm-reopen-' . uniqid() . '@example.com',
            'login_id' => 'ipjpsm-reopen-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'BPE', 'status' => 1, 'is_approved' => 1,
        ]);
    }
}
