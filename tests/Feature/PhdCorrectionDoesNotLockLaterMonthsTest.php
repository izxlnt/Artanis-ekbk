<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormA;
use App\Models\FormC;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use App\Services\FormFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Regression test for a reported production issue: "April was closed, then
 * May opened" — i.e. a month that was already filled and accessible
 * suddenly became blocked.
 *
 * Root cause: FormFlowService::checkFormC (and checkFormD/checkFormE) gated
 * a month's accessibility on the PREVIOUS month's status being "submitted"
 * BEFORE checking whether the month itself already had its own record. So
 * when PHD sends an EARLIER month back for correction ("Tidak Lengkap" —
 * which is not a "submitted" status), every LATER month that had already
 * been filled would retroactively lose access, even though nothing about
 * that later month changed. This test fills Jan–Apr, has PHD reject March,
 * and asserts April must remain fully reachable throughout.
 */
class PhdCorrectionDoesNotLockLaterMonthsTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function correcting_march_does_not_lock_ibk_out_of_the_already_filled_april_form_c()
    {
        $shuttleType = '3';
        $user = $this->makeUser($shuttleType);
        $shuttle = $user->shuttle;
        $phd = $this->makeReviewerUser('PHD');

        $this->fillFormA($user, $shuttle, $shuttleType);
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 1);

        foreach ([1, 2, 3, 4] as $bulan) {
            $this->fillFormCForMonth($user, $shuttle, $shuttleType, $bulan);
        }

        $marchBefore = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 3)->first();
        $aprilBefore = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 4)->first();
        $this->assertNotSame('Tidak Diisi', $aprilBefore->status, 'April should already be filled before the March correction.');

        // PHD sends March back for correction.
        $this->actingAs($phd)->post(route('update_status_form3C', $marchBefore->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila perbetulkan data.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $marchBefore->refresh();
        $this->assertSame('Tidak Lengkap', $marchBefore->status);

        // April must still be directly reachable via the real gate route —
        // this is the exact route real IBK users click through from the
        // listing page.
        $gateResponse = $this->actingAs($user)->get(route('user.shuttle-3-formC.KKB', [4, self::YEAR]));
        $gateResponse->assertRedirect(route('user.view.shuttle-3-formC.KKB', [4, self::YEAR]));

        $viewResponse = $this->actingAs($user)->get(route('user.view.shuttle-3-formC.KKB', [4, self::YEAR]));
        $viewResponse->assertOk();

        // Also confirm at the FormFlowService level (what drives the listing
        // page's button states) that April is not reported as blocked.
        $status = FormFlowService::getStatus($shuttle->id, (int) $shuttleType, self::YEAR);
        $this->assertTrue($status['formC'][4]['can_fill'], 'April must remain fillable/viewable after March is sent back for correction. Reason: ' . ($status['formC'][4]['reason'] ?? 'none'));

        $aprilAfter = FormC::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 4)->first();
        $this->assertSame($aprilBefore->status, $aprilAfter->status, "April's own status must not have changed just because March was corrected.");
    }

    /**
     * The exact reported symptom: "April suddenly cannot be filled but May
     * can". Cause 1 was the always-on closing-date rule — April's window
     * (opens 1 Apr, closes 1 May + delay) had expired by June/July while
     * later months' windows were still open, so April showed as closed while
     * May looked open. With buffer rules now OFF by default, an unfilled
     * April must stay fillable no matter how long ago its window expired —
     * and May must stay locked (in the correct sequential order) until April
     * is actually filled. It must never again be possible for a month to be
     * closed while the month after it is open.
     */
    /** @test */
    public function april_with_an_expired_window_stays_fillable_and_may_only_opens_after_april_is_filled()
    {
        $shuttleType = '3';
        $user = $this->makeUser($shuttleType);
        $shuttle = $user->shuttle;

        $this->fillFormA($user, $shuttle, $shuttleType);
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 1);
        $this->fillFormBForQuarter($user, $shuttle, $shuttleType, 2);

        foreach ([1, 2, 3] as $bulan) {
            $this->fillFormCForMonth($user, $shuttle, $shuttleType, $bulan);
        }

        // April exists untouched, with its real production date window —
        // which by now (July in test-year terms) has long expired.
        FormC::updateOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => 4],
            [
                'shuttle_type' => $shuttleType, 'status' => 'Tidak Diisi',
                'tarikh_buka_borang' => self::YEAR . '-04-01',
                'tarikh_tutup_borang' => self::YEAR . '-04-30',
            ]
        );
        FormC::updateOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => 5],
            [
                'shuttle_type' => $shuttleType, 'status' => 'Tidak Diisi',
                'tarikh_buka_borang' => self::YEAR . '-05-01',
                'tarikh_tutup_borang' => self::YEAR . '-05-31',
            ]
        );

        // Pin the buffer to "rules off, no grace delay" — the production DB
        // currently has delay=12 (set Nov 2024, likely as a workaround for
        // this very bug), which would mask the difference between the old
        // always-enforce behaviour and the new opt-in toggle. Rolled back by
        // the test transaction.
        Buffer::updateOrCreate(
            ['shuttle' => $shuttleType, 'borang' => 'C'],
            ['delay' => 0, 'aktif' => 0]
        );

        $status = FormFlowService::getStatus($shuttle->id, (int) $shuttleType, self::YEAR);

        // April: window expired, but with buffer rules off it must stay open.
        $this->assertTrue($status['formC'][4]['can_fill'],
            'April must stay fillable even though its date window expired. Reason: ' . ($status['formC'][4]['reason'] ?? 'none'));

        // May: must be LOCKED until April is filled — never the inverted
        // "April closed, May open" state that was reported.
        $this->assertFalse($status['formC'][5]['can_fill'],
            'May must stay locked while April is unfilled.');
        $this->assertSame('Sila isi Borang C bulan sebelumnya terlebih dahulu.', $status['formC'][5]['reason']);

        // The real gate route agrees: April goes through to the form.
        $this->actingAs($user)->get(route('user.shuttle-3-formC.KKB', [4, self::YEAR]))
            ->assertRedirect(route('user.view.shuttle-3-formC.KKB', [4, self::YEAR]));

        // Fill April -> May unlocks.
        $this->fillFormCForMonth($user, $shuttle, $shuttleType, 4);

        $status = FormFlowService::getStatus($shuttle->id, (int) $shuttleType, self::YEAR);
        $this->assertTrue($status['formC'][5]['can_fill'],
            'May must open once April is filled. Reason: ' . ($status['formC'][5]['reason'] ?? 'none'));
    }

    // ── Shared setup helpers (same conventions as ReviewWorkflowTest) ─────

    private function makeUser(string $shuttleType): User
    {
        RecoveryRate::firstOrCreate(
            ['shuttle_type' => $shuttleType],
            ['min_recovery_rate' => 0.15, 'max_recovery_rate' => 0.99]
        );

        $user = User::factory()->create([
            'kategori_pengguna' => 'IBK',
            'status' => 1,
            'is_approved' => 1,
        ]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();

        return $user->fresh();
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

    private function fillFormA(User $user, $shuttle, string $shuttleType): void
    {
        $hakMilik = \App\Models\HakMilik::first();

        $this->actingAs($user)->get(route("user.shuttle-{$shuttleType}-formA"))->assertOk();

        $response = $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
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
        ]);
        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    private function fillFormCForMonth(User $user, $shuttle, string $shuttleType, int $bulan): void
    {
        $prefix = "shuttle-{$shuttleType}-formC";

        Batch::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['status' => 'Sedang Diproses', 'borang_a' => 1]
        );
        FormC::firstOrCreate(
            ['shuttle_id' => $shuttle->id, 'tahun' => self::YEAR, 'bulan' => $bulan],
            ['shuttle_type' => $shuttleType, 'status' => 'Tidak Diisi']
        );

        $stages = [
            ['kayu_id' => 1, 'route' => 'KKB'],
            ['kayu_id' => 2, 'route' => 'KKS'],
            ['kayu_id' => 3, 'route' => 'KKR'],
            ['kayu_id' => 4, 'route' => 'KayuLembut'],
            ['kayu_id' => 5, 'route' => 'LainLain'],
        ];

        foreach ($stages as $stage) {
            $this->actingAs($user)->get(route("user.view.{$prefix}.{$stage['route']}", [$bulan, self::YEAR]))->assertOk();

            $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $stage['kayu_id'])->get()->values();
            $count = $species->count();
            $kayuMasuk = [];
            foreach ($species as $i => $s) {
                $kayuMasuk[$i] = 10 + $s->id;
            }
            $zeroFill = array_fill(0, $count, 0);

            $response = $this->actingAs($user)->post(route("user.view.{$prefix}.{$stage['route']}.store", [$bulan, self::YEAR]), [
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
            ]);
            $response->assertStatus(302)->assertSessionDoesntHaveErrors();
        }
    }

    private function fillFormBForQuarter(User $user, $shuttle, string $shuttleType, int $suku): void
    {
        $viewRoute = "user.shuttle-{$shuttleType}-formB";
        $this->actingAs($user)->get(route($viewRoute, [$suku, self::YEAR]))->assertOk();

        \App\Models\KategoriGunaTenaga::get();

        $namespace = [
            '3' => \App\Http\Livewire\ShuttleThree\FormB::class,
            '4' => \App\Http\Livewire\ShuttleFour\FormB::class,
            '5' => \App\Http\Livewire\ShuttleFive\FormB::class,
        ][$shuttleType];

        \Livewire\Livewire::actingAs($user)
            ->test($namespace, ['year' => self::YEAR, 'suku_id' => $suku])
            ->set('pekerja_wargabumi_lelaki.0', 1)
            ->set('gaji_lelaki.0', 5000)
            ->call('store')
            ->assertHasNoErrors();
    }
}
