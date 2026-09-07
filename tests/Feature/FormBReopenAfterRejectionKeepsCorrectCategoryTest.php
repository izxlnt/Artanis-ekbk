<?php

namespace Tests\Feature;

use App\Models\FormA;
use App\Models\FormB;
use App\Models\GunaTenaga;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression test for a real bug: ShuttleFour\FormB and ShuttleFive\FormB
 * both reloaded a PHD-rejected ("Tidak Lengkap") form's saved values by row
 * position (GunaTenaga::orderBy('id','desc')) instead of matching each row
 * back to its actual kategori_guna_tenaga_id. Since the initial submission
 * creates GunaTenaga rows in ascending category-id order (matching
 * KategoriGunaTenaga's own order), ordering the reload by 'id' DESC is a
 * full reversal - category 1's label would show category 8's numbers,
 * category 2's label would show category 7's, and so on.
 *
 * This test fills Form B with a distinct, traceable value per category, has
 * PHD reject it, then re-mounts the same Livewire component (exactly what
 * happens when IBK re-opens the form to fix it) and asserts every
 * category's reloaded value is still its own - not swapped with another
 * category's.
 */
class FormBReopenAfterRejectionKeepsCorrectCategoryTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SUKU = 1;

    /** @test */
    public function shuttle_4_form_b_reopen_after_rejection_keeps_correct_category()
    {
        $this->runForShuttle('4', \App\Http\Livewire\ShuttleFour\FormB::class);
    }

    /** @test */
    public function shuttle_5_form_b_reopen_after_rejection_keeps_correct_category()
    {
        $this->runForShuttle('5', \App\Http\Livewire\ShuttleFive\FormB::class);
    }

    /** @test */
    public function shuttle_3_form_b_reopen_after_rejection_keeps_correct_category()
    {
        $this->runShuttle3ViaEditComponent();
    }

    /**
     * Shuttle 3's IBK-facing "reject -> refill" route uses a dedicated
     * EditForm3B component (mounted with the FormB row's own id), not
     * FormB's own mount() - unlike Shuttle 4/5, which use their FormB
     * component for both initial fill and reopening. Both were audited
     * this session; EditForm3B was fixed earlier and is re-checked here.
     */
    private function runShuttle3ViaEditComponent(): void
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

        $test = Livewire::actingAs($user)->test(\App\Http\Livewire\ShuttleThree\FormB::class, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            $test->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)->set("gaji_lelaki.{$i}", 5000);
        }
        $test->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $this->assertNotNull($formb, 'Shuttle 3: FormB row missing after initial submit.');

        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);
        $this->actingAs($phd)->post(route('update_status_form3B', $formb->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila perbetulkan data.',
        ])->assertStatus(302);

        $formb->refresh();
        $this->assertSame('Tidak Lengkap', $formb->status, 'Shuttle 3: PHD rejection did not set status to Tidak Lengkap.');

        // IBK re-opens via the real edit-form3b route's component, mounted
        // with the FormB row's own id (see EditForm3B::$shuttle_id, which
        // despite the name holds the formbs_id, not a Shuttle id).
        $reopened = Livewire::actingAs($user)->test(\App\Http\Livewire\ShuttleThree\EditForm3B::class, ['shuttle_id' => $formb->id]);
        $reloadedLelaki = $reopened->get('pekerja_wargabumi_lelaki');

        foreach ($kategori as $i => $k) {
            $this->assertArrayHasKey($i, $reloadedLelaki,
                "Shuttle 3: no reloaded value at position {$i} for category {$k->id} ({$k->keterangan}) after reopening a rejected form.");
            $this->assertSame(100 + $k->id, (int) $reloadedLelaki[$i],
                "Shuttle 3: category {$k->id} ({$k->keterangan}) shows the wrong value after reopening a PHD-rejected form via EditForm3B.");
        }
    }

    private function runForShuttle(string $shuttleType, string $formBComponent): void
    {
        $user = User::factory()->create([
            'kategori_pengguna' => 'IBK',
            'status' => 1,
            'is_approved' => 1,
        ]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();
        $user = $user->fresh();

        $this->fillFormA($user, $shuttle);

        $kategori = KategoriGunaTenaga::orderBy('id')->get();
        $this->assertGreaterThanOrEqual(2, $kategori->count(), 'Need at least 2 categories for this test to be meaningful.');

        // The GET view firstOrCreate()s this quarter's FormB row - store()
        // itself only ->first()s and crashes on a missing row.
        $this->actingAs($user)->get(route("user.shuttle-{$shuttleType}-formB", [self::SUKU, self::YEAR]))->assertOk();

        // ── IBK fills Form B: a distinct, traceable headcount per category ──
        $test = Livewire::actingAs($user)->test($formBComponent, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            // 100 + category id, so a swap between any two categories is
            // unmistakable in the assertion failure message.
            $test->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)
                ->set("gaji_lelaki.{$i}", 5000);
        }
        $test->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $this->assertNotNull($formb, "Shuttle {$shuttleType}: FormB row missing after initial submit.");

        // Confirm what actually landed in the database is correct before
        // rejection even enters the picture.
        $rows = GunaTenaga::where('formbs_id', $formb->id)->get()->keyBy('kategori_guna_tenaga_id');
        foreach ($kategori as $k) {
            $row = $rows->get($k->id);
            $this->assertNotNull($row, "Shuttle {$shuttleType}: category {$k->id} ({$k->keterangan}) row missing after initial submit.");
            $this->assertSame(100 + $k->id, (int) $row->pekerja_wargabumi_lelaki,
                "Shuttle {$shuttleType}: category {$k->id} ({$k->keterangan}) value wrong immediately after initial submit (before any rejection).");
        }

        // ── PHD rejects the form ("Tidak Lengkap") ──────────────────────
        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);
        $this->actingAs($phd)->post(route('update_status_form3B', $formb->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila perbetulkan data.',
        ])->assertStatus(302);

        $formb->refresh();
        $this->assertSame('Tidak Lengkap', $formb->status, "Shuttle {$shuttleType}: PHD rejection did not set status to Tidak Lengkap.");

        // ── IBK re-opens the form - this is the exact code path
        // (mount()/EditForm3B) that had the position-vs-id bug. ──────────
        $reopened = Livewire::actingAs($user)->test($formBComponent, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        $reloadedLelaki = $reopened->get('pekerja_wargabumi_lelaki');

        foreach ($kategori as $i => $k) {
            $this->assertArrayHasKey($i, $reloadedLelaki,
                "Shuttle {$shuttleType}: no reloaded value at position {$i} for category {$k->id} ({$k->keterangan}) after reopening a rejected form.");
            $this->assertSame(100 + $k->id, (int) $reloadedLelaki[$i],
                "Shuttle {$shuttleType}: category {$k->id} ({$k->keterangan}) shows the wrong value after reopening a PHD-rejected form - "
                . "expected " . (100 + $k->id) . " but the value that reloaded under this category's label belongs to a different category. "
                . "This is the exact category-swap bug reported.");
        }
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
            'no_ssm' => 'SSM-REOPEN-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'reopen-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-REOPEN-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
}
