<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Regression test for a real bug reported from a production screenshot,
 * on the "Status Borang 5B" listing page: a Form B PHD had already
 * approved (status "Dihantar ke IPJPSM") but whose package hadn't been
 * sent onward yet - correctly showing "Pakej Belum Dihantar" in the Status
 * column - still had a "Tindakan" action icon/link routing back to the
 * "needs verification" page, labelled "Borang Perlu Disahkan PHD", as if
 * PHD hadn't reviewed it yet.
 *
 * This exact bug (an `$data->status == 'Dihantar ke IPJPSM' && !$packageSent`
 * condition bundled into the "still needs action" branch) turned out to be
 * copy-pasted across all 13 PHD "senarai-tugasan" listing pages (every form
 * type A-E, every shuttle type), not just Form 5D (already covered by
 * PhdFormDDecisionButtonsHiddenAfterDecisionTest) - this test covers a
 * representative sample of the rest: Form B (all three shuttle types,
 * reproducing the exact report) and Form A/Form C for shuttle 3 (different
 * route-naming and an extra "Tiada Pengeluaran" branch respectively).
 */
class PhdListingRoutesAlreadyDecidedFormsCorrectlyTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function shuttle_3_form_b_listing_routes_an_already_decided_form_to_the_read_only_view()
    {
        $this->assertFormBListingRoutesCorrectly('3');
    }

    /** @test */
    public function shuttle_4_form_b_listing_routes_an_already_decided_form_to_the_read_only_view()
    {
        $this->assertFormBListingRoutesCorrectly('4');
    }

    /** @test */
    public function shuttle_5_form_b_listing_routes_an_already_decided_form_to_the_read_only_view()
    {
        $this->assertFormBListingRoutesCorrectly('5');
    }

    private function assertFormBListingRoutesCorrectly(string $shuttleType): void
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd($shuttleType);

        $formb = FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => $shuttleType, 'tahun' => self::YEAR,
            'suku_tahun' => 1, 'status' => 'Dihantar ke IPJPSM',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'B-LIST-TEST-' . $shuttleType, 'no_lesen' => 'LB-LIST-TEST-' . $shuttleType,
        ]);

        // No Batch row exists, so packageSent is false - matching "Pakej
        // Belum Dihantar" from the screenshot.
        $html = $this->actingAs($phd)->get(route("phd.senarai-tugasan-{$shuttleType}B", self::YEAR))->assertOk()->getContent();

        $this->assertStringContainsString('Pakej Belum Dihantar', $html);
        $this->assertStringContainsString(route('phd.shuttle-3-view-formB-phd', $formb->id), $html,
            "Shuttle {$shuttleType}: an already-decided Form B must route to the read-only view from the listing page.");
        $this->assertStringNotContainsString('href="' . route('phd.shuttle-3-view-formB', $formb->id) . '"', $html,
            "Shuttle {$shuttleType}: an already-decided Form B must not still link to the actionable view from the listing page.");
    }

    /** @test */
    public function shuttle_3_form_a_listing_routes_an_already_decided_form_to_the_read_only_view()
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd('3');

        $forma = FormA::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR,
            'status' => 'Dihantar ke IPJPSM', 'nama_kilang' => $shuttle->nama_kilang,
            'no_ssm' => 'A-LIST-TEST', 'no_lesen' => 'LA-LIST-TEST',
        ]);

        $html = $this->actingAs($phd)->get(route('phd.senarai-tugasan-3A', self::YEAR))->assertOk()->getContent();

        $this->assertStringContainsString(route('phd.shuttle-3-view-formA-phd', $forma->id), $html);
        $this->assertStringNotContainsString('href="' . route('phd.shuttle-3-view-formA', $forma->id) . '"', $html);
    }

    /** @test */
    public function shuttle_3_form_c_listing_routes_an_already_decided_form_to_the_read_only_view()
    {
        [$shuttle, $phd] = $this->makeShuttleAndPhd('3');

        $formc = FormC::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR, 'bulan' => 1,
            'status' => 'Dihantar ke IPJPSM', 'nama_kilang' => $shuttle->nama_kilang,
            'no_ssm' => 'C-LIST-TEST', 'no_lesen' => 'LC-LIST-TEST',
        ]);

        $html = $this->actingAs($phd)->get(route('phd.senarai-tugasan-3C', self::YEAR))->assertOk()->getContent();

        $this->assertStringContainsString(route('phd.shuttle-3-view-formC-phd', $formc->id), $html);
        $this->assertStringNotContainsString('href="' . route('phd.shuttle-3-view-formC', $formc->id) . '"', $html);
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
            'name' => 'PHD Reviewer', 'email' => 'phd-listing-' . uniqid() . '@example.com',
            'login_id' => 'phd-listing-' . uniqid(), 'password' => Hash::make('password'),
            'kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1, 'daerah' => $daerah->daerah_hutan,
        ]);

        return [$shuttle, $phd];
    }
}
