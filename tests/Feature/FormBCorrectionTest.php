<?php

namespace Tests\Feature;

use App\Models\FormB;
use App\Models\GunaTenaga;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * PHD and IPJPSM/BPE were explicitly asked to lose all editing power over
 * Form B (see FormBIpjpsmReadOnlyViewTest) - but the user then said that
 * change went too far: PHD and BPE both need to be able to correct a
 * submitted Form B's figures before making their Sahkan/Tolak decision,
 * just not via the old "Data Cleaning" tool's confusing side-by-side
 * layout (original value shown, then a separate blank box next to it) or
 * its bug of silently forcing approval as part of saving a correction.
 *
 * This tests the replacement: a single editable box per field (pre-filled
 * with the current effective value), a save that only touches the
 * *_laporan columns (never IBK's original submission, and never the form's
 * status), and a reset that restores the *_laporan columns to match IBK's
 * original submission.
 */
class FormBCorrectionTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SUKU = 1;

    /** @test */
    public function phd_can_correct_and_reset_shuttle_3_before_deciding()
    {
        $this->runForShuttle('3', \App\Http\Livewire\ShuttleThree\FormB::class, 'user.shuttle-3-formB');
    }

    /** @test */
    public function phd_can_correct_and_reset_shuttle_4_before_deciding()
    {
        $this->runForShuttle('4', \App\Http\Livewire\ShuttleFour\FormB::class, 'user.shuttle-4-formB');
    }

    /** @test */
    public function phd_can_correct_and_reset_shuttle_5_before_deciding()
    {
        $this->runForShuttle('5', \App\Http\Livewire\ShuttleFive\FormB::class, 'user.shuttle-5-formB');
    }

    /**
     * Regression test for a real bug reported from a production screenshot:
     * entering a value in the "Bukan Warganegara Malaysia - P" column (07)
     * left the "Jumlah Pekerja - P" total (09) stuck at its pre-edit value
     * (0) instead of picking up the new figure, even though the matching
     * "L" column (06/08) calculated correctly. Root cause: the original
     * inputs combined wire:model.defer with an explicit wire:change on the
     * very same element - Livewire doesn't guarantee that pairing applies
     * the just-typed value before the wire:change action runs, so the calc
     * could run against the stale pre-edit value. Fixed by moving the
     * recalculation into updated(), which Livewire only calls after a
     * property already holds its new value - no such race is possible.
     *
     * @test
     */
    public function correcting_only_the_asing_columns_still_updates_both_totals()
    {
        $shuttleType = '3';
        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $kategori = KategoriGunaTenaga::orderBy('id')->get();

        // Only category 0 needs a non-zero headcount (FormB::store() only
        // validates jumlah_pekerja[0] > 0) - every other category,
        // including the target row below, starts genuinely empty so the
        // "only touch the asing columns" scenario is exact, not off by
        // whatever the fill step happened to pre-populate.
        $this->actingAs($user)->get(route('user.shuttle-3-formB', [self::SUKU, self::YEAR]))->assertOk();
        $fill = Livewire::actingAs($user)->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        $fill->set('pekerja_wargabumi_lelaki.0', 1)->set('gaji_lelaki.0', 5000);
        $fill->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);
        $correction = Livewire::actingAs($phd)->test(\App\Http\Livewire\ShuttleThree\FormBCorrection::class, ['formbId' => $formb->id]);

        $lastCategoryKey = $kategori->count() - 1;

        // Mirrors the screenshot exactly: only the two "asing" (foreign
        // worker) columns get typed into for this row - (06) then (07) -
        // each set() simulating one field's blur, with no other field in
        // this row ever touched.
        $correction->set("pekerja_asing_lelaki.{$lastCategoryKey}", 32);
        $correction->set("pekerja_asing_perempuan.{$lastCategoryKey}", 22);

        $correction->assertSet("jumlah_lelaki.{$lastCategoryKey}", 32);
        $correction->assertSet("jumlah_perempuan.{$lastCategoryKey}", 22,
            'Jumlah Pekerja (P) must reflect the just-entered (07) value, not stay stuck at its pre-edit total.');
        $correction->assertSet("jumlah_pekerja.{$lastCategoryKey}", 54);
    }

    private function runForShuttle(string $shuttleType, string $formBComponent, string $fillRouteName): void
    {
        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $kategori = KategoriGunaTenaga::orderBy('id')->get();

        $this->actingAs($user)->get(route($fillRouteName, [self::SUKU, self::YEAR]))->assertOk();
        $fill = Livewire::actingAs($user)->test($formBComponent, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            $fill->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)->set("gaji_lelaki.{$i}", 5000);
        }
        $fill->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $this->assertNotNull($formb, "Shuttle {$shuttleType}: FormB row missing after submit.");
        $this->assertSame('Sedang Diproses', $formb->status);

        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);

        // PHD's actionable view (status still Sedang Diproses) must show
        // the correction tool, pre-filled with IBK's real figures - not a
        // blank box, and not the old dual side-by-side layout.
        $html = $this->actingAs($phd)->get(route('phd.shuttle-3-view-formB', $formb->id))->assertOk()->getContent();
        $this->assertStringContainsString('value="' . (100 + $kategori->first()->id) . '"', $html,
            "Shuttle {$shuttleType}: PHD's correction box should be pre-filled with IBK's submitted value, not blank.");

        $correction = Livewire::actingAs($phd)->test(\App\Http\Livewire\ShuttleThree\FormBCorrection::class, ['formbId' => $formb->id]);

        // Sanity: mount() loaded IBK's real figures, not zeros.
        foreach ($kategori as $i => $k) {
            $correction->assertSet("pekerja_wargabumi_lelaki.{$i}", (string) (100 + $k->id));
        }

        // PHD corrects category 1's headcount from 101 to 999 - no explicit
        // "save" click or calc call involved: set() alone triggers
        // Livewire's updated() hook, which recalculates the row and
        // auto-persists on its own, exactly like a real blur in the browser.
        $correction->set('pekerja_wargabumi_lelaki.0', 999);

        $formb->refresh();
        $this->assertSame('Sedang Diproses', $formb->status,
            "Shuttle {$shuttleType}: correcting a field must not change the form's status - that's a separate Sahkan/Tolak decision.");

        $row = GunaTenaga::where('formbs_id', $formb->id)->where('kategori_guna_tenaga_id', $kategori->first()->id)->first();
        $this->assertSame('101', (string) (int) $row->pekerja_wargabumi_lelaki,
            "Shuttle {$shuttleType}: IBK's original submission must stay untouched by a correction.");
        $this->assertEquals(999, (float) $row->pekerja_wargabumi_lelaki_laporan,
            "Shuttle {$shuttleType}: the correction must auto-save to the _laporan column that reports read from, with no separate save step.");

        // Reset must restore the *_laporan columns to match IBK's original submission.
        $correction->call('resetToOriginal');

        $row->refresh();
        $this->assertEquals(101, (float) $row->pekerja_wargabumi_lelaki_laporan,
            "Shuttle {$shuttleType}: reset should revert the correction back to IBK's original value.");
        $correction->assertSet('pekerja_wargabumi_lelaki.0', 101);
    }

    /** @test */
    public function bpe_can_correct_before_deciding_but_not_after()
    {
        $shuttleType = '3';
        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $kategori = KategoriGunaTenaga::orderBy('id')->get();

        $this->actingAs($user)->get(route('user.shuttle-3-formB', [self::SUKU, self::YEAR]))->assertOk();
        $fill = Livewire::actingAs($user)->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            $fill->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)->set("gaji_lelaki.{$i}", 5000);
        }
        $fill->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();

        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);
        $this->actingAs($phd)->post(route('update_status_form3B', $formb->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formb->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formb->status);

        $bpe = User::factory()->create(['kategori_pengguna' => 'BPE', 'status' => 1, 'is_approved' => 1]);

        // While pending IPJPSM's decision, the correction tool must be there.
        $html = $this->actingAs($bpe)->get(route('ipjpsm.shuttle-3-view-formB', $formb->id))->assertOk()->getContent();
        $this->assertStringContainsString('Reset Kepada Rekod Lama', $html,
            'BPE should see the correction tool while the form is still Dihantar ke IPJPSM.');

        $correction = Livewire::actingAs($bpe)->test(\App\Http\Livewire\ShuttleThree\FormBCorrection::class, ['formbId' => $formb->id]);
        $correction->set('gaji_lelaki.0', 6000)->call('calcJumlahPekerjaLelaki', 0);

        $row = GunaTenaga::where('formbs_id', $formb->id)->where('kategori_guna_tenaga_id', $kategori->first()->id)->first();
        $this->assertEquals(6000, (float) $row->gaji_lelaki_laporan);
        $this->assertEquals(5000, (float) $row->gaji_lelaki, "IBK's original salary figure must stay untouched.");

        // IPJPSM now certifies it.
        $this->actingAs($bpe)->post(route('update_status_form3B_ipjpsm', $formb->id), [
            'status' => 'Lulus',
            'ulasan_ipjpsm' => 'Diperaku.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formb->refresh();
        $this->assertSame('Lulus', $formb->status);

        // Once decided, the page must go back to being purely read-only -
        // no more correction tool for an already-certified form.
        $htmlAfter = $this->actingAs($bpe)->get(route('ipjpsm.shuttle-3-view-formB', $formb->id))->assertOk()->getContent();
        $this->assertStringNotContainsString('Reset Kepada Rekod Lama', $htmlAfter,
            'An already-certified (Lulus) Form B must not show the correction tool any more.');
    }

    private function fillFormA(User $user, $shuttle): void
    {
        $hakMilik = HakMilik::first();
        $this->actingAs($user)->get(route("user.shuttle-{$user->shuttle_type}-formA"))->assertOk();
        $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM-CORRECTION-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'correction-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-CORRECTION-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
}
