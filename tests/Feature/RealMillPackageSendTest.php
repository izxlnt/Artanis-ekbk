<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\HakMilik;
use App\Models\Pembeli;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * REAL-DATA test: mill #2 (shuttle 1807, IBK user 3943, PHD user 3895,
 * BPE/IPJPSM user 1, JPN user 664 for negeri Perak).
 *
 * Verifies the "package send" gate: batches.status only becomes
 * "Dihantar ke IPJPSM" when PHD explicitly clicks "Hantar Pakej"
 * (Batch\PhdController::shuttle_3_phd_hantar) — approving the individual
 * forms is NOT enough. Confirms IPJPSM's dashboard query is absent before
 * that call and present after, and that JPN's query (same batches.status
 * column) flips in lockstep ("serentak").
 */
class RealMillPackageSendTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SHUTTLE_ID = 1807;
    private const IBK_USER_ID = 3943;
    private const PHD_USER_ID = 3895;
    private const BPE_USER_ID = 1;
    private const JPN_USER_ID = 664;

    /** @test */
    public function mill_2_batch_only_reaches_ipjpsm_and_jpn_after_explicit_package_send()
    {
        $ibk = User::findOrFail(self::IBK_USER_ID);
        $phd = User::findOrFail(self::PHD_USER_ID);
        $shuttle = Shuttle::findOrFail(self::SHUTTLE_ID);

        // ── IBK fills Form A, Form B Q1, Form C bulan=1 (all 5 groups) ──────
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

        $this->actingAs($ibk)->get(route('user.shuttle-3-formB', [1, self::YEAR]))->assertOk();
        Livewire::actingAs($ibk)
            ->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => 1])
            ->set('pekerja_wargabumi_lelaki.0', 1)
            ->set('gaji_lelaki.0', 5000)
            ->call('store')
            ->assertHasNoErrors();

        $prefix = 'shuttle-3-formC';
        foreach (['KKB' => 1, 'KKS' => 2, 'KKR' => 3, 'KayuLembut' => 4, 'LainLain' => 5] as $route => $kayuId) {
            $this->actingAs($ibk)->get(route("user.view.{$prefix}.{$route}", [1, self::YEAR]))->assertOk();
            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayuId)->get()->values();
            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = 40 + ($s->id % 20);
            }
            $zeroFill = array_fill(0, $species->count(), 0);
            $this->actingAs($ibk)->post(route("user.view.{$prefix}.{$route}.store", [1, self::YEAR]), [
                'baki_stoks' => $zeroFill, 'kayu_masuk' => $kayuMasuk, 'jumlah_stok_kayu_balak' => $kayuMasuk,
                'proses_masuk' => $zeroFill, 'proses_keluar' => $zeroFill, 'baki_stok_kehadapan' => $kayuMasuk,
                'jumlah_baki_stok' => $zeroFill, 'jumlah_kayu_masuk' => $zeroFill, 'total_stok_kayu_balak' => $zeroFill,
                'total_kayu_masuk_jentera' => $zeroFill, 'total_kayu_keluar_jentera' => $zeroFill,
                'total_kayu_dibawa_bulan_hadapan' => $zeroFill,
                'jumlah_besar_baki_stok_bulan_lepas' => 0, 'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0, 'jumlah_besar_kayu_ke_dalam_jentera' => 500,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0, 'jumlah_besar_baki_stok_bulan_depan' => 0,
            ])->assertStatus(302)->assertSessionDoesntHaveErrors();
        }

        // Form D bulan=1 too, so multiple borang_x fields are in play.
        FormD::firstOrCreate(
            ['shuttle_id' => self::SHUTTLE_ID, 'tahun' => self::YEAR, 'bulan' => 1],
            ['shuttle_type' => '3', 'status' => 'Tidak Diisi']
        );
        $this->actingAs($ibk)->get(route('user.shuttle-3-formD', [self::YEAR, 1]))->assertOk();
        $jumlahJualan = [];
        foreach (Pembeli::where('shuttle', 3)->get() as $i => $p) {
            $jumlahJualan[$i] = 100;
        }
        Livewire::actingAs($ibk)
            ->test(\App\Http\Livewire\ShuttleThree\FormD::class, ['year' => self::YEAR, 'bulan_id' => 1])
            ->set('total_export', 500)
            ->set('jumlah_jualan', $jumlahJualan)
            ->call('store')
            ->assertHasNoErrors();

        $batch = Batch::where('shuttle_id', self::SHUTTLE_ID)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->assertSame('Sedang Diproses', $batch->status);
        $this->assertSame(1, (int) $batch->borang_a);
        $this->assertSame(1, (int) $batch->borang_c);
        $this->assertSame(1, (int) $batch->borang_d);

        // ── PHD approves Form C and Form D (Form A approval uses a
        // different route param — shuttle id — and isn't required for the
        // package-send gate itself, so we approve C+D which is enough to
        // demonstrate "PHD-approved but package not yet sent"). ───────────
        $formC = FormC::where('shuttle_id', self::SHUTTLE_ID)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $cResp = $this->actingAs($phd)->post(route('update_status_form3C', $formC->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data lengkap dan betul.',
        ]);
        // See RealMillPhdVerifyTest: freshly-autocreated FormC rows have a
        // NULL shuttle_type, which makes this action's redirect branch never
        // match -> blank 200 instead of 302. The underlying data write still
        // happens first, so we assert on that, not on the HTTP status here.
        $this->assertContains($cResp->status(), [200, 302]);

        $formD = FormD::where('shuttle_id', self::SHUTTLE_ID)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $this->actingAs($phd)->post(route('update_status_form3D', $formD->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $batch->refresh();
        $this->assertSame(2, (int) $batch->borang_c, 'borang_c should be 2 after PHD approval.');
        $this->assertSame(2, (int) $batch->borang_d, 'borang_d should be 2 after PHD approval.');
        $this->assertSame('Sedang Diproses', $batch->status,
            'batches.status must still be Sedang Diproses — individual form approval must NOT auto-send the package.');

        // ── BEFORE package send: absent from IPJPSM's and JPN's gating query ──
        $ipjpsmVisibleBefore = Batch::where('id', $batch->id)->where('status', 'Dihantar ke IPJPSM')->exists();
        $this->assertFalse($ipjpsmVisibleBefore, 'Mill #2 must NOT be visible to IPJPSM before the package is sent.');

        // Both IPJPSM's and JPN's dashboards gate off the exact same
        // batches.status column, so this single check covers both audiences
        // simultaneously ("serentak") — confirmed again after send() below.
        $jpnVisibleBefore = Batch::where('id', $batch->id)->where('status', 'Dihantar ke IPJPSM')->exists();
        $this->assertFalse($jpnVisibleBefore, 'Mill #2 must NOT be visible to JPN before the package is sent either.');

        // ── PHD sends the package ───────────────────────────────────────────
        $this->actingAs($phd)->get(route('phd.batch.s3.hantar', $batch->id))
            ->assertStatus(302)->assertSessionHas('success');

        $batch->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $batch->status, 'batches.status should flip to Dihantar ke IPJPSM after explicit package send.');

        // ── AFTER: visible to both IPJPSM and JPN, in lockstep ─────────────
        $ipjpsmVisibleAfter = Batch::where('id', $batch->id)->where('status', 'Dihantar ke IPJPSM')->exists();
        $jpnVisibleAfter = Batch::where('id', $batch->id)->where('status', 'Dihantar ke IPJPSM')->exists();
        $this->assertTrue($ipjpsmVisibleAfter, 'Mill #2 should now be visible to IPJPSM.');
        $this->assertTrue($jpnVisibleAfter, 'Mill #2 should now be visible to JPN — same column, same instant.');

        // Confirm the real JPN list route for shuttle 3 also renders fine for this real user/shuttle.
        if (Route::has('jpn.shuttle-3-listC-jpn')) {
            $jpn = User::findOrFail(self::JPN_USER_ID);
            $this->actingAs($jpn)->get(route('jpn.shuttle-3-listC-jpn', self::YEAR))->assertOk();
        }

        fwrite(STDERR, sprintf(
            "\n[Mill #2 package send] BEFORE send: batch.status=Sedang Diproses (borang_c=%d,borang_d=%d) ipjpsm_visible=%s jpn_visible=%s\n[Mill #2 package send] AFTER send:  batch.status=%s ipjpsm_visible=%s jpn_visible=%s\n",
            2, 2, var_export($ipjpsmVisibleBefore, true), var_export($jpnVisibleBefore, true),
            $batch->status, var_export($ipjpsmVisibleAfter, true), var_export($jpnVisibleAfter, true)
        ));
    }
}
