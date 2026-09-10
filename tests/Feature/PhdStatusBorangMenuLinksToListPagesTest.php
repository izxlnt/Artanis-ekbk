<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Regression test for a reported navigation bug: the PHD sidebar's "Status
 * Borang" menu was pointing at the "Senarai Tugasan" task-list pages
 * (phd.senarai-tugasan-XA) instead of the form-status overview pages
 * (phd.shuttle-X-listA) - the same destination "Pengesahan Maklumat" >
 * "Pengesahan Borang" already correctly uses.
 */
class PhdStatusBorangMenuLinksToListPagesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function status_borang_menu_links_to_the_shuttle_list_pages_not_senarai_tugasan()
    {
        $daerah = Daerah::firstOrFail();
        $phd = User::factory()->create([
            'kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1, 'daerah' => $daerah->daerah_hutan,
        ]);

        $html = $this->actingAs($phd)->get(route('home-phd'))->assertOk()->getContent();

        foreach (['3', '4', '5'] as $shuttleType) {
            // "Pengesahan Maklumat" > "Pengesahan Borang" already links here,
            // so the Status Borang menu must add a SECOND occurrence, not
            // just any occurrence, to prove it was actually rewired.
            $listHref = 'href="' . route("phd.shuttle-{$shuttleType}-listA", date('Y')) . '"';
            $this->assertSame(2, substr_count($html, $listHref),
                "Both Pengesahan Borang and Status Borang menus must link to phd.shuttle-{$shuttleType}-listA.");

            $tugasanHref = 'href="' . route("phd.senarai-tugasan-{$shuttleType}A", date('Y')) . '"';
            $this->assertStringNotContainsString($tugasanHref, $html,
                "Status Borang menu must no longer link to phd.senarai-tugasan-{$shuttleType}A.");
        }
    }
}
