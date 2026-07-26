<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormC;
use App\Models\HakMilik;
use App\Models\KemasukanBahan;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Notifications\PHD\BorangTidakLengkapNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * REAL-DATA test: mill #1 (shuttle 1027, IBK user 2302, PHD user 133).
 * Exercises the reject -> resubmit -> approve review cycle for Borang C
 * bulan=1 through the real routes/controllers, using Notification::fake()
 * (never real mail — MAIL_MAILER=array under phpunit.xml regardless) to
 * confirm the IBK-side "Tidak Lengkap" notification actually dispatches to
 * the correct real user without touching any real mailbox.
 */
class RealMillPhdVerifyTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SHUTTLE_ID = 1027;
    private const IBK_USER_ID = 2302;
    private const PHD_USER_ID = 133;

    /** @test */
    public function mill_1_phd_can_reject_then_ibk_resubmits_then_phd_approves()
    {
        Notification::fake();

        $ibk = User::findOrFail(self::IBK_USER_ID);
        $phd = User::findOrFail(self::PHD_USER_ID);
        $shuttle = Shuttle::findOrFail(self::SHUTTLE_ID);
        $this->assertSame('PHD', $phd->kategori_pengguna);
        $this->assertContains((int) $shuttle->daerah_id, $phd->daerah_ids,
            'Sanity: PHD 133 should cover shuttle 1027\'s daerah_id via daerah_ids mapping.');

        // Same fresh-mill seeding as RealMillFreshChainTest (shuttle 1027 has
        // no Batch/FormA rows for 2026 in the real DB).
        Batch::firstOrCreate(
            ['shuttle_id' => self::SHUTTLE_ID, 'tahun' => self::YEAR, 'bulan' => 1],
            ['status' => 'Tidak Diisi', 'borang_a' => 0, 'borang_b' => 0, 'borang_c' => 0, 'borang_d' => 0]
        );
        FormA::firstOrCreate(['shuttle_id' => self::SHUTTLE_ID, 'tahun' => self::YEAR], ['status' => 'Tidak Diisi']);

        $hakMilik = HakMilik::first();
        $this->actingAs($ibk)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $this->fillFormCBulan1($ibk);

        $formc = FormC::where('shuttle_id', self::SHUTTLE_ID)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertSame('Sedang Diproses', $formc->status, 'Form C bulan=1 should be submitted (Sedang Diproses) before PHD review.');
        $beforeReject = ['formc_status' => $formc->status, 'batch_borang_c' => Batch::where('shuttle_id', self::SHUTTLE_ID)->where('tahun', self::YEAR)->where('bulan', 1)->first()->borang_c];

        // FIXED: ShuttleThree\FormCController's firstOrCreate() calls (and the
        // UserController "ensure all 12 months exist" pre-creation loops) now
        // always stamp `shuttle_type`, so update_status_phd_form3C's final
        // redirect branch (keyed on `$formC->shuttle_type == '3'`) now matches
        // and returns a proper redirect+flash instead of a blank 200. The 296
        // pre-existing real rows with NULL shuttle_type were backfilled via
        // the 2026_07_26_120000_backfill_form_c_s_shuttle_type migration.
        $this->assertSame('3', $formc->shuttle_type,
            'FIX confirmed: freshly-autocreated FormC rows now have shuttle_type stamped.');

        // ── PHD rejects with a comment ────────────────────────────────────
        $rejectResp = $this->actingAs($phd)->post(route('update_status_form3C', $formc->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila perbetulkan data KKB - nilai tidak konsisten.',
        ]);
        $rejectResp->assertStatus(302)->assertSessionHas('success', 'Borang Berjaya Dihantar Semula ke IBK.');

        $formc->refresh();
        $this->assertSame('Tidak Lengkap', $formc->status, 'Form C should be Tidak Lengkap after PHD rejects.');

        $batch = Batch::where('shuttle_id', self::SHUTTLE_ID)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertSame(0, (int) $batch->borang_c, 'batches.borang_c should reset to 0 after rejection.');

        $comment = UlasanPhd::where('formcs_id', $formc->id)->latest('id')->first();
        $this->assertNotNull($comment, 'A UlasanPhd comment row should be stored.');
        $this->assertSame('Sila perbetulkan data KKB - nilai tidak konsisten.', $comment->ulasan);
        $this->assertSame($phd->id, $comment->user_id);

        // IBK's own account is linked via pengguna_kilang_id -> PenggunaKilang(shuttle_id=1027).
        Notification::assertSentTo($ibk, BorangTidakLengkapNotification::class);

        // ── IBK reopens and resubmits the rejected month ─────────────────
        $this->actingAs($ibk)->get(route('user.view.shuttle-3-formC.KKB', [1, self::YEAR]))->assertOk();
        $this->fillFormCBulan1($ibk, 60); // slightly different values on resubmit

        $formc->refresh();
        $this->assertNotSame('Tidak Lengkap', $formc->status, 'Form C should have left Tidak Lengkap once IBK resubmits.');
        $this->assertSame('Sedang Diproses', $formc->status);

        // ── PHD approves ──────────────────────────────────────────────────
        $approveResp = $this->actingAs($phd)->post(route('update_status_form3C', $formc->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data sudah betul selepas pembetulan.',
        ]);
        $approveResp->assertStatus(302)->assertSessionHas('success', 'Borang Berjaya Disahkan.');

        $formc->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formc->status, 'Form C should be Dihantar ke IPJPSM after PHD approves.');

        $batch->refresh();
        $this->assertSame(2, (int) $batch->borang_c, 'batches.borang_c should be 2 after PHD approval.');

        fwrite(STDERR, sprintf(
            "\n[Mill #1 PHD verify] BEFORE reject: formC=%s batch.borang_c=%d\n[Mill #1 PHD verify] AFTER reject: formC=Tidak Lengkap batch.borang_c=0 comment=\"%s\"\n[Mill #1 PHD verify] AFTER resubmit+approve: formC=%s batch.borang_c=%d\n",
            $beforeReject['formc_status'], $beforeReject['batch_borang_c'],
            $comment->ulasan,
            $formc->status, $batch->borang_c
        ));
    }

    private function fillFormCBulan1(User $ibk, int $base = 50): void
    {
        $prefix = 'shuttle-3-formC';
        $groups = ['KKB' => 1, 'KKS' => 2, 'KKR' => 3, 'KayuLembut' => 4, 'LainLain' => 5];

        foreach ($groups as $route => $kayuId) {
            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayuId)->get()->values();
            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = $base + ($s->id % 20);
            }
            $zeroFill = array_fill(0, $species->count(), 0);

            // The GET view route is what firstOrCreate()s the month's FormC
            // row — required before the POST store route can find it.
            $this->actingAs($ibk)->get(route("user.view.{$prefix}.{$route}", [1, self::YEAR]))->assertOk();

            $this->actingAs($ibk)->post(route("user.view.{$prefix}.{$route}.store", [1, self::YEAR]), [
                'baki_stoks' => $zeroFill,
                'kayu_masuk' => $kayuMasuk,
                'jumlah_stok_kayu_balak' => $kayuMasuk,
                'proses_masuk' => $zeroFill,
                'proses_keluar' => $zeroFill,
                'baki_stok_kehadapan' => $kayuMasuk,
                'jumlah_baki_stok' => $zeroFill,
                'jumlah_kayu_masuk' => $zeroFill,
                'total_stok_kayu_balak' => $zeroFill,
                'total_kayu_masuk_jentera' => $zeroFill,
                'total_kayu_keluar_jentera' => $zeroFill,
                'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
                'jumlah_besar_baki_stok_bulan_lepas' => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0,
                'jumlah_besar_kayu_ke_dalam_jentera' => 500,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        }
    }
}
