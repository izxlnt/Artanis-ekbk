<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormD;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Form D/E counterpart of ListingReopensDueMonthsTest (Form C) and
 * ListingReopensDueQuartersTest (Form B): same seeded-placeholder bug
 * ("Ditutup"), same fix (FormD::reopenDueMonths() / Form4D:: / Form5D:: /
 * Form4E:: / Form5E::), wired into every Form D/E listing controller.
 */
class ListingReopensDueMonthsFormDETest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function phd_shuttle_3_form_d_listing_reopens_a_due_month()
    {
        $this->assertReopens(FormD::class, '3', 'phd.shuttle-3-listD', 'no_ssm');
    }

    /** @test */
    public function phd_shuttle_4_form_d_listing_reopens_a_due_month()
    {
        $this->assertReopens(Form4D::class, '4', 'phd.shuttle-4-listD', 'no_ssm');
    }

    /** @test */
    public function phd_shuttle_5_form_d_listing_reopens_a_due_month()
    {
        $this->assertReopens(Form5D::class, '5', 'phd.shuttle-5-listD', 'no_ssm');
    }

    /** @test */
    public function phd_shuttle_4_form_e_listing_reopens_a_due_month()
    {
        $this->assertReopens(Form4E::class, '4', 'phd.shuttle-4-listE', 'no_ssm');
    }

    /** @test */
    public function phd_shuttle_5_form_e_listing_reopens_a_due_month()
    {
        $this->assertReopens(Form5E::class, '5', 'phd.shuttle-5-listE', 'no_ssm');
    }

    /** @test */
    public function a_form_d_month_that_has_not_opened_yet_shows_the_closed_icon_instead_of_a_blank_cell()
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd('5');

        $row = Form5D::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR,
            'bulan' => 12, 'status' => 'Ditutup',
            'tarikh_buka_borang' => '2026-12-01', 'tarikh_tutup_borang' => '2026-12-31',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'D-DITUTUP-FUTURE', 'no_lesen' => 'LD-DITUTUP-FUTURE',
        ]);

        $html = $this->actingAs($phd)->get(route('phd.shuttle-5-listD', self::YEAR))->assertOk()->getContent();

        $this->assertSame('Tidak Diisi', $row->fresh()->status);
        $this->assertStringContainsString('Borang ditutup', $html,
            'A month that has not opened yet must show the closed/calendar icon, not render as a blank cell.');
        $this->assertStringNotContainsString('Borang belum diisi', $html,
            'A month that has not opened yet must not show the "belum diisi" icon - it has not started, no one has failed to fill it in.');
    }

    private function assertReopens(string $modelClass, string $shuttleType, string $routeName, string $ssmField): void
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd($shuttleType);

        $row = $modelClass::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => $shuttleType, 'tahun' => self::YEAR,
            'bulan' => 9, 'status' => 'Ditutup',
            'tarikh_buka_borang' => '2026-09-01', 'tarikh_tutup_borang' => '2026-10-01',
            'nama_kilang' => $shuttle->nama_kilang, $ssmField => 'DITUTUP-DUE-' . $shuttleType . '-' . $routeName,
            'no_lesen' => 'LX-DITUTUP-DUE-' . $shuttleType,
        ]);

        $html = $this->actingAs($phd)->get(route($routeName, self::YEAR))->assertOk()->getContent();

        $this->assertSame('Tidak Diisi', $row->fresh()->status,
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
            'name' => 'PHD Reviewer', 'email' => 'phd-reopen-de-' . uniqid() . '@example.com',
            'login_id' => 'phd-reopen-de-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1, 'daerah' => $daerah->daerah_hutan,
        ]);

        return [$shuttle, $phd];
    }
}
