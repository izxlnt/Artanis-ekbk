<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\FormC;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Regression test for the Form C ("Borang C") counterpart of the Form B bug
 * covered by ListingReopensDueQuartersTest: reported from production on
 * /phd/shuttle-5-listC/2026, where a month's column showed nothing at all
 * even though that month had already opened.
 *
 * Same root cause, one level finer-grained: every FormC row for a factory's
 * twelve months is seeded up front when the IBK's registration is approved
 * (PermohonanPenggunaController's "checker C" block), and any month that
 * hasn't started yet AT THAT TIME is stamped with the placeholder status
 * "Ditutup". Confirmed live in the local dev DB: 110 shuttle-5 FormC rows
 * for 2026 were still sitting at "Ditutup" despite their tarikh_buka_borang
 * having already passed. The fix, FormC::reopenDueMonths(), mirrors
 * FormB::reopenDueQuarters() exactly and is wired into every FormC listing
 * controller the same way.
 */
class ListingReopensDueMonthsTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function phd_shuttle_3_listing_reopens_a_due_month()
    {
        $this->assertListingReopensDueMonth('3', 'phd.shuttle-3-listC', fn($phd) => $phd);
    }

    /** @test */
    public function phd_shuttle_4_listing_reopens_a_due_month()
    {
        $this->assertListingReopensDueMonth('4', 'phd.shuttle-4-listC', fn($phd) => $phd);
    }

    /** @test */
    public function phd_shuttle_5_listing_reopens_a_due_month()
    {
        $this->assertListingReopensDueMonth('5', 'phd.shuttle-5-listC', fn($phd) => $phd);
    }

    /** @test */
    public function jpn_shuttle_3_listing_reopens_a_due_month()
    {
        $this->assertListingReopensDueMonth('3', 'jpn.shuttle-3-listC-jpn', fn($phd, $shuttle) => $this->makeJpn($shuttle));
    }

    /** @test */
    public function a_month_that_has_not_opened_yet_shows_the_closed_icon_instead_of_a_blank_cell()
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd('5');

        $formc = FormC::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR,
            'bulan' => 12, 'status' => 'Ditutup',
            'tarikh_buka_borang' => '2026-12-01', 'tarikh_tutup_borang' => '2026-12-31',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'C-DITUTUP-FUTURE', 'no_lesen' => 'LC-DITUTUP-FUTURE',
        ]);

        // Reported from a production screenshot (shuttle-5-listC): Oct/Nov/
        // Dec, which genuinely have not opened yet, rendered as blank cells
        // instead of the grey "Borang ditutup" calendar icon every other
        // status already gets.
        $html = $this->actingAs($phd)->get(route('phd.shuttle-5-listC', self::YEAR))->assertOk()->getContent();

        $this->assertSame('Tidak Diisi', $formc->fresh()->status);
        $this->assertStringContainsString('Borang ditutup', $html,
            'A month that has not opened yet must show the closed/calendar icon, not render as a blank cell.');
        $this->assertStringNotContainsString('Borang belum diisi', $html,
            'A month that has not opened yet must not show the "belum diisi" icon - it has not started, no one has failed to fill it in.');
    }

    private function assertListingReopensDueMonth(string $shuttleType, string $routeName, \Closure $makeViewer): void
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd($shuttleType);
        $viewer = $makeViewer($phd, $shuttle);

        // September opened on 1 Sep, well before "today" (10 Sep 2026 per
        // the test clock), but this factory's IBK never visited their own
        // fill page for it - so it is still sitting at the seeded "Ditutup"
        // placeholder, exactly like the real production data.
        $formc = FormC::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => $shuttleType, 'tahun' => self::YEAR,
            'bulan' => 9, 'status' => 'Ditutup',
            'tarikh_buka_borang' => '2026-09-01', 'tarikh_tutup_borang' => '2026-10-01',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'C-DITUTUP-DUE-' . $shuttleType . '-' . $routeName,
            'no_lesen' => 'LC-DITUTUP-DUE-' . $shuttleType,
        ]);

        $html = $this->actingAs($viewer)->get(route($routeName, self::YEAR))->assertOk()->getContent();

        $this->assertSame('Tidak Diisi', $formc->fresh()->status,
            "{$routeName}: a month whose open date has already passed must be reopened from the seeded \"Ditutup\" placeholder so it renders correctly.");
        $this->assertStringContainsString('Borang belum diisi', $html,
            "{$routeName}: the reopened month must show the \"belum diisi\" icon instead of rendering as a blank cell.");
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
            'name' => 'PHD Reviewer', 'email' => 'phd-reopen-c-' . uniqid() . '@example.com',
            'login_id' => 'phd-reopen-c-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1, 'daerah' => $daerah->daerah_hutan,
        ]);

        return [$shuttle, $phd];
    }

    private function makeJpn($shuttle): User
    {
        return User::create([
            'name' => 'JPN Reviewer', 'email' => 'jpn-reopen-c-' . uniqid() . '@example.com',
            'login_id' => 'jpn-reopen-c-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'JPN', 'status' => 1, 'is_approved' => 1, 'negeri' => $shuttle->negeri_id,
        ]);
    }
}
