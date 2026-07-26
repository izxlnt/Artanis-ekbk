<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\User;
use App\Services\FormFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Two independent checks against REAL data, both read via the real HTTP
 * routes (never a browser):
 *
 *  1. Gating rule sanity check: deliberately submit Borang C bulan=8 for
 *     mill #3 (shuttle 1642) while bulan=7 has never been filled, to see
 *     whether the real route actually enforces FormFlowService's
 *     "previous month must be filled" sequential rule, or only *reports*
 *     it (used for the dashboard icon) without enforcing it server-side.
 *
 *  2. Icon rendering reality check: render one PHD-facing and one JPN-facing
 *     Borang C list page for real batches in Sedang Diproses / Dihantar ke
 *     IPJPSM / Lulus states and grep the raw HTML for which icon filename
 *     is actually emitted, to see whether the two-partial disagreement
 *     (cell-borang-monthly.blade.php vs form-status-cell.blade.php) is
 *     visible on any real PHD/JPN screen, or only used elsewhere (IBK's own
 *     dashboard vs IPJPSM/admin views).
 */
class RealMillGatingAndIconTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function mill_3_form_c_sequential_month_gate_is_reported_by_flow_service_but_not_enforced_by_the_real_route()
    {
        $shuttleId = 1642;
        $ibk = User::findOrFail(3520);
        $targetBulan = 7; // today's real server clock is 2026-07-26, so bulan=7
                           // is "current month" (allowed) while bulan=8+ would
                           // trip the controller's unrelated future-month guard
                           // ((int)$bulan_id > (int)date('n')) — using 7 isolates
                           // the sequential-previous-month-C rule specifically.

        // Clear the (unrelated) Form B suku=2 gate first, so the ONLY thing
        // standing between "bulan=5 filled" and "bulan=7" is the sequential
        // previous-month-C rule we're actually testing.
        $this->actingAs($ibk)->get(route('user.shuttle-3-formB', [2, self::YEAR]))->assertOk();
        Livewire::actingAs($ibk)
            ->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => 2])
            ->set('pekerja_wargabumi_lelaki.0', 1)
            ->set('gaji_lelaki.0', 5000)
            ->call('store')
            ->assertHasNoErrors();
        $formB2 = FormB::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('suku_tahun', 2)->first();
        $this->assertNotSame('Tidak Diisi', $formB2->status);

        // bulan=1-5 are already genuinely submitted for this real mill.
        // Deliberately do NOT fill bulan=6 — skip straight to bulan=7.
        $formC5 = FormC::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 5)->first();
        $this->assertContains($formC5->status, FormFlowService::SUBMITTED, 'Sanity: bulan=5 must already be submitted (real pre-existing data).');

        $formC6 = FormC::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', 6)->first();
        $this->assertTrue(!$formC6 || !in_array($formC6->status, FormFlowService::SUBMITTED),
            'Sanity: bulan=6 must genuinely NOT be filled — this is the gap we are deliberately skipping.');

        // What FormFlowService itself says about the target month right now:
        $flow = FormFlowService::getStatus($shuttleId, 3, self::YEAR);
        $flowSaysCanFill = $flow['formC'][$targetBulan]['can_fill'];
        $flowReason = $flow['formC'][$targetBulan]['reason'] ?? null;

        // Attempt the real submission anyway (bulan=7, skipping bulan=6).
        $prefix = 'shuttle-3-formC';
        $this->actingAs($ibk)->get(route("user.view.{$prefix}.KKB", [$targetBulan, self::YEAR]))->assertOk();

        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', 1)->get()->values();
        $kayuMasuk = [];
        foreach ($species as $i => $s) {
            $kayuMasuk[$i] = 20 + ($s->id % 10);
        }
        $zeroFill = array_fill(0, $species->count(), 0);

        $resp = $this->actingAs($ibk)->post(route("user.view.{$prefix}.KKB.store", [$targetBulan, self::YEAR]), [
            'baki_stoks' => $zeroFill, 'kayu_masuk' => $kayuMasuk, 'jumlah_stok_kayu_balak' => $kayuMasuk,
            'proses_masuk' => $zeroFill, 'proses_keluar' => $zeroFill, 'baki_stok_kehadapan' => $kayuMasuk,
            'jumlah_baki_stok' => $zeroFill, 'jumlah_kayu_masuk' => $zeroFill, 'total_stok_kayu_balak' => $zeroFill,
            'total_kayu_masuk_jentera' => $zeroFill, 'total_kayu_keluar_jentera' => $zeroFill,
            'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
            'jumlah_besar_baki_stok_bulan_lepas' => 0, 'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
            'jumlah_besar_stok_kayu_balak' => 0, 'jumlah_besar_kayu_ke_dalam_jentera' => 0,
            'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0, 'jumlah_besar_baki_stok_bulan_depan' => 0,
        ]);

        $formCTarget = FormC::where('shuttle_id', $shuttleId)->where('tahun', self::YEAR)->where('bulan', $targetBulan)->first();
        $actuallyWroteData = $formCTarget && $formCTarget->status !== 'Tidak Diisi';

        fwrite(STDERR, sprintf(
            "\n[Gating check] FormFlowService says bulan=%d can_fill=%s (reason: %s)\n[Gating check] Real route response status=%d; FormC bulan=%d status after attempt=%s (data written=%s)\n",
            $targetBulan, var_export($flowSaysCanFill, true), $flowReason ?? '(none)',
            $resp->status(), $targetBulan, $formCTarget->status ?? '(no row)', var_export($actuallyWroteData, true)
        ));

        // FINDING: FormFlowService reports this as NOT fillable (the
        // dashboard would show a dimmed/blocked icon), but store_kkb (and
        // the KKB view controller) only check "Form A filled" and "previous
        // QUARTER's Form B submitted" — they never check "previous MONTH's
        // Form C submitted". So the real route accepts the out-of-order
        // submission. This is a genuine, confirmed gap between the reported
        // gating rule and its actual server-side enforcement for shuttle 3's
        // Form C store routes — not a "confirm it works" case.
        $this->assertFalse($flowSaysCanFill, "FormFlowService correctly reports bulan={$targetBulan} as not fillable yet.");
        $this->assertTrue($actuallyWroteData,
            'CONFIRMED GAP: the real store_kkb route accepted an out-of-order Borang C submission that FormFlowService says should be blocked. '
            . 'The sequential-month rule is enforced only for the dashboard icon (FormFlowService::getStatus), not by FormCController itself.');
    }

    /** @test */
    public function icon_rendering_reality_check_on_real_phd_and_jpn_list_pages()
    {
        // Mill #3 (shuttle 1642) has real batches in multiple states for 2026:
        // bulan=1 Dihantar ke IPJPSM (borang_c=2), bulan=2/4/5 Sedang Diproses.
        $phd = User::findOrFail(1225); // PHD, Johor Tengah (covers shuttle 1642)
        $jpn = User::findOrFail(1210); // JPN, negeri Johor

        $phdIcons = [];
        if (Route::has('phd.shuttle-3-listC')) {
            $resp = $this->actingAs($phd)->get(route('phd.shuttle-3-listC', self::YEAR));
            $resp->assertOk();
            $phdIcons = $this->extractIconFilenames($resp->getContent());
        }

        $jpnIcons = [];
        if (Route::has('jpn.shuttle-3-listC-jpn')) {
            $resp = $this->actingAs($jpn)->get(route('jpn.shuttle-3-listC-jpn', self::YEAR));
            $resp->assertOk();
            $jpnIcons = $this->extractIconFilenames($resp->getContent());
        }

        fwrite(STDERR, sprintf(
            "\n[Icon check] PHD phd.shuttle-3-listC icons seen: %s\n[Icon check] JPN jpn.shuttle-3-listC-jpn icons seen: %s\n",
            implode(', ', $phdIcons) ?: '(none/route missing)',
            implode(', ', $jpnIcons) ?: '(none/route missing)'
        ));

        // These two specific PHD/JPN pages render their OWN inline icon logic
        // (shuttle-3-listC.blade.php / shuttle-3-listC-jpn.blade.php) — NOT
        // via either shared partial. The disagreement flagged between
        // cell-borang-monthly.blade.php (used only by IPJPSM's listC-ipjpsm
        // and admin borangKeseluruhan views) and form-status-cell.blade.php
        // (used only by IBK's own home-user dashboard) therefore never
        // surfaces on any PHD or JPN screen at all — it can only be seen by
        // comparing IBK's own dashboard against IPJPSM's or admin's views for
        // the same batch, not on the PHD/JPN pages this check renders.
        $this->assertNotEmpty($phdIcons + $jpnIcons, 'Sanity: at least one icon filename should have been found on these real pages.');
    }

    private function extractIconFilenames(string $html): array
    {
        preg_match_all('/(circle_times_yellow|circle_check_yellow|double_check|circle_check|circle_times|tp_logo2|tpbiru|tpcoklat|package|calendar|history)\.png/', $html, $matches);
        return array_values(array_unique($matches[0]));
    }

    private function fillFormCMonth(User $ibk, int $shuttleId, int $bulan): void
    {
        Batch::firstOrCreate(
            ['shuttle_id' => $shuttleId, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['status' => 'Tidak Diisi', 'borang_a' => 0, 'borang_b' => 0, 'borang_c' => 0, 'borang_d' => 0]
        );

        $prefix = 'shuttle-3-formC';
        foreach (['KKB' => 1, 'KKS' => 2, 'KKR' => 3, 'KayuLembut' => 4, 'LainLain' => 5] as $route => $kayuId) {
            $this->actingAs($ibk)->get(route("user.view.{$prefix}.{$route}", [$bulan, self::YEAR]))->assertOk();
            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayuId)->get()->values();
            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = 15 + ($s->id % 10);
            }
            $zeroFill = array_fill(0, $species->count(), 0);
            $this->actingAs($ibk)->post(route("user.view.{$prefix}.{$route}.store", [$bulan, self::YEAR]), [
                'baki_stoks' => $zeroFill, 'kayu_masuk' => $kayuMasuk, 'jumlah_stok_kayu_balak' => $kayuMasuk,
                'proses_masuk' => $zeroFill, 'proses_keluar' => $zeroFill, 'baki_stok_kehadapan' => $kayuMasuk,
                'jumlah_baki_stok' => $zeroFill, 'jumlah_kayu_masuk' => $zeroFill, 'total_stok_kayu_balak' => $zeroFill,
                'total_kayu_masuk_jentera' => $zeroFill, 'total_kayu_keluar_jentera' => $zeroFill,
                'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
                'jumlah_besar_baki_stok_bulan_lepas' => 0, 'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0, 'jumlah_besar_kayu_ke_dalam_jentera' => 0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0, 'jumlah_besar_baki_stok_bulan_depan' => 0,
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        }
    }
}
