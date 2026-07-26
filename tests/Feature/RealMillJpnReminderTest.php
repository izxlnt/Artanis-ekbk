<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\User;
use App\Notifications\JPN\BorangTidakDiambilTindakan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * REAL-DATA verification of ShuttleThree\ListAController::notifikasi_peringatan
 * (the JPN "un-actioned forms" reminder) and its recent fix for batches where
 * PHD approved every submitted borang_x but never clicked "Hantar Pakej".
 *
 * Everything here is read-only against real existing 2026 production rows
 * (the mills' data is NOT mutated by this test — DatabaseTransactions is used
 * defensively only, since send_email() does write to the notifications
 * system, faked here so nothing real is dispatched).
 */
class RealMillJpnReminderTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function terengganu_jpn_reminder_includes_mill_9_approved_but_unsent_batches()
    {
        $jpn = User::findOrFail(310); // JPN, negeri=Terengganu
        $data = $this->hitReminder($jpn);

        $belumHantarIds = collect($data['batches_belum_hantar'])->pluck('id')->toArray();

        // Mill #9 = shuttle 1489. bulan 1,2,3,5 are Sedang Diproses with every
        // relevant borang_x at 0 or 2 (never 1) and at least one at 2 — the
        // exact "approved but unsent" case the fix targets.
        $expectedBulans = [1, 2, 3, 5];
        $millBatches = Batch::where('shuttle_id', 1489)->where('tahun', self::YEAR)->whereIn('bulan', $expectedBulans)->get();
        $this->assertCount(4, $millBatches, 'Sanity: expected exactly 4 real Sedang Diproses batches for shuttle 1489 bulan 1/2/3/5.');

        foreach ($millBatches as $b) {
            $this->assertContains($b->id, $belumHantarIds,
                "Shuttle 1489 bulan={$b->bulan}: should be flagged as 'approved but unsent' for JPN Terengganu after the fix.");
        }

        fwrite(STDERR, "\n[JPN Terengganu] batches_belum_hantar count=" . count($belumHantarIds) . ", includes mill#9 bulans " . $millBatches->pluck('bulan')->implode(',') . "\n");
    }

    /** @test */
    public function perak_jpn_reminder_includes_mill_8_approved_but_unsent_batch()
    {
        $jpn = User::findOrFail(664); // JPN, negeri=Perak
        $data = $this->hitReminder($jpn);

        $belumHantarIds = collect($data['batches_belum_hantar'])->pluck('id')->toArray();

        // Mill #8 = shuttle 310, bulan=2: Sedang Diproses, borang_c=2, all
        // others 0 -> "at least one approved, none pending" -> should count.
        $batch = Batch::where('shuttle_id', 310)->where('tahun', self::YEAR)->where('bulan', 2)->first();
        $this->assertNotNull($batch);
        $this->assertSame('Sedang Diproses', $batch->status);
        $this->assertSame(2, (int) $batch->borang_c);

        $this->assertContains($batch->id, $belumHantarIds,
            'Shuttle 310 bulan=2: should be flagged as approved-but-unsent for JPN Perak after the fix.');

        fwrite(STDERR, "\n[JPN Perak] batches_belum_hantar count=" . count($belumHantarIds) . ", includes mill#8 shuttle=310 bulan=2: yes\n");
    }

    /** @test */
    public function perak_jpn_reminder_still_counts_mill_6_pending_first_look_without_double_counting_in_belum_hantar()
    {
        $jpn = User::findOrFail(664); // JPN, negeri=Perak (covers mill #6, shuttle 1003)
        $data = $this->hitReminder($jpn);

        $belumHantarIds = collect($data['batches_belum_hantar'])->pluck('id')->toArray();
        $formAIds = collect($data['form_a'])->pluck('id')->toArray();
        $formBIds = collect($data['form_b'])->pluck('id')->toArray();
        $formCIds = collect($data['form_c'])->pluck('id')->toArray();

        // Mill #6 = shuttle 1003, bulan 1-6: batches.borang_a=1 (bulan 1) /
        // borang_c=1 (bulan 1-6) / borang_b=1 (bulan 3,6) -> genuinely
        // "awaiting PHD's first look", must NOT appear in batches_belum_hantar
        // (that collection is only for "approved but unsent", not "pending").
        $mill6Batches = Batch::where('shuttle_id', 1003)->where('tahun', self::YEAR)->whereIn('bulan', [1, 2, 3, 4, 5, 6])->get();
        foreach ($mill6Batches as $b) {
            $this->assertNotContains($b->id, $belumHantarIds,
                "Shuttle 1003 bulan={$b->bulan}: still has a pending borang_x==1 field, must NOT be double-counted in batches_belum_hantar.");
        }

        // Regression check: Form A's annual pending-review IS still counted
        // (pre-existing behaviour, unrelated to the fix) — shuttle 1003's
        // FormA.status == 'Sedang Diproses' for 2026.
        $shuttle1003FormAId = \App\Models\FormA::where('shuttle_id', 1003)->where('tahun', self::YEAR)->value('id');
        $this->assertContains($shuttle1003FormAId, $formAIds,
            'Regression: shuttle 1003\'s pending Form A must still be counted by $form_a (pre-existing behaviour).');

        // Form B suku 1 & 2 are 'Sedang Diproses' for shuttle 1003 -> must
        // still be counted by $form_b (pre-existing behaviour).
        $formBRows = \App\Models\FormB::where('shuttle_id', 1003)->where('tahun', self::YEAR)->whereIn('suku_tahun', [1, 2])->pluck('id');
        foreach ($formBRows as $id) {
            $this->assertContains($id, $formBIds, 'Regression: shuttle 1003 pending Form B (suku 1/2) must still be counted.');
        }

        // FIXED: shuttle 1003's Form C rows for bulan 1-6 are status
        // 'Tiada Pengeluaran' (submitted via the "no production" path), which
        // batches.borang_c=1 correctly still treats as "awaiting PHD's first
        // look". $form_c now matches both 'Sedang Diproses' AND
        // 'Tiada Pengeluaran', so these 6 real pending months are counted.
        $mill6FormCRows = \App\Models\FormC::where('shuttle_id', 1003)->where('tahun', self::YEAR)->whereIn('bulan', [1, 2, 3, 4, 5, 6])->get();
        foreach ($mill6FormCRows as $fc) {
            $this->assertSame('Tiada Pengeluaran', $fc->status, 'Confirms observed real state (not Sedang Diproses).');
            $this->assertContains($fc->id, $formCIds,
                "FIX confirmed: shuttle 1003 bulan={$fc->bulan} Form C ('Tiada Pengeluaran', borang_c=1 pending) is now counted by \$form_c.");
        }

        fwrite(STDERR, "\n[JPN Perak regression] mill#6 batches_belum_hantar=NOT present (correct); form_a counted=yes; form_b counted=yes; form_c (Tiada Pengeluaran rows) counted=yes (fixed)\n");
    }

    /** @test */
    public function johor_jpn_reminder_now_counts_mill_3_shuttle_type_3_form_d_backlog()
    {
        $jpn = User::findOrFail(1210); // JPN, negeri=Johor (covers mill #3, shuttle 1642, shuttle_type=3)
        $data = $this->hitReminder($jpn);

        $belumHantarIds = collect($data['batches_belum_hantar'])->pluck('id')->toArray();
        $formDIds = collect($data['form_d'])->pluck('id')->toArray();

        // Mill #3 = shuttle 1642 (shuttle_type=3), bulan 2,4,5: batches.borang_d=1
        // (Form D awaiting PHD's first look), borang_c=2 already approved.
        $mill3PendingD = Batch::where('shuttle_id', 1642)->where('tahun', self::YEAR)->whereIn('bulan', [2, 4, 5])->get();
        foreach ($mill3PendingD as $b) {
            $this->assertSame(1, (int) $b->borang_d, "Sanity: shuttle 1642 bulan={$b->bulan} borang_d should be 1 (pending).");
            // Correctly excluded from batches_belum_hantar (something IS pending).
            $this->assertNotContains($b->id, $belumHantarIds);
        }

        // FIXED: notifikasi_peringatan() now also queries the generic
        // `App\Models\FormD` model (shuttle type 3's own Form D), so mill #3's
        // 3 real pending-D months (bulan 2,4,5) are now counted.
        $mill3FormDRows = \App\Models\FormD::where('shuttle_id', 1642)->where('tahun', self::YEAR)->whereIn('bulan', [2, 4, 5])->get();
        $this->assertCount(3, $mill3FormDRows, 'Sanity: expected exactly 3 real pending Form D rows for shuttle 1642.');
        foreach ($mill3FormDRows as $fd) {
            $this->assertContains($fd->id, $formDIds,
                "FIX confirmed: shuttle 1642 bulan={$fd->bulan} Form D (pending PHD review) is now counted by \$form_d.");
        }

        fwrite(STDERR, "\n[JPN Johor] mill#3 pending-D bulans=2,4,5 -> now counted via \$form_d (fixed).\n");
    }

    /** @test */
    public function send_email_notifies_only_phd_users_in_the_targeted_district()
    {
        Notification::fake();

        // Perak Selatan covers mill #6 (shuttle 1003) and its PHD, user 727.
        $daerahHutan = 'Perak Selatan';
        $inDistrictPhd = User::where('kategori_pengguna', 'PHD')->where('daerah', $daerahHutan)->get();
        $this->assertGreaterThan(0, $inDistrictPhd->count(), 'Sanity: at least one real PHD user must be assigned to Perak Selatan.');
        $this->assertTrue($inDistrictPhd->pluck('id')->contains(727), 'Sanity: PHD 727 should be one of them.');

        $outsidePhd = User::where('kategori_pengguna', 'PHD')->where('daerah', '!=', $daerahHutan)->whereNotNull('daerah')->first();
        $this->assertNotNull($outsidePhd, 'Sanity: need at least one PHD user outside the district to prove isolation.');

        $jpn = User::findOrFail(664);
        $this->actingAs($jpn)->get(route('jpn.shuttle-list-jpn.email', ['daerah_hutan' => $daerahHutan]))
            ->assertStatus(302)->assertSessionHas('success');

        foreach ($inDistrictPhd as $phd) {
            Notification::assertSentTo($phd, BorangTidakDiambilTindakan::class);
        }
        Notification::assertNotSentTo($outsidePhd, BorangTidakDiambilTindakan::class);

        fwrite(STDERR, sprintf(
            "\n[send_email] district=%s notified=%d real PHD user(s) (incl. #727); outside PHD #%d correctly NOT notified.\n",
            $daerahHutan, $inDistrictPhd->count(), $outsidePhd->id
        ));
    }

    private function hitReminder(User $jpn): array
    {
        $resp = $this->actingAs($jpn)->get(route('jpn.notifikasi.list'));
        $resp->assertOk();
        /** @var \Illuminate\View\View $view */
        $view = $resp->original;
        return $view->getData();
    }
}
