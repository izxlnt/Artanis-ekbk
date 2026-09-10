<?php

namespace Tests\Feature;

use App\Models\FormA;
use App\Models\FormC;
use App\Models\KemasukanBahan;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * The "PHD's decision buttons are only gated by role, never by whether the
 * form is already decided" bug found on Form 5D (see
 * PhdFormDDecisionButtonsHiddenAfterDecisionTest) turned out to be systemic:
 * the same gap existed with zero exceptions across every PHD/IPJPSM
 * verification page in the app. This covers the two other form types most
 * exercised elsewhere in the test suite (Form A and Form C) as a
 * representative sample of the wider fix, applied identically across every
 * shuttle type/form combination.
 */
class PhdDecisionButtonsHiddenAfterDecisionSweepTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function form_a_decision_buttons_disappear_once_phd_has_decided()
    {
        $ibk = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $ibk->shuttle;
        $shuttle->update(['shuttle_type' => '3']);
        $phd = $this->makeReviewerUser('PHD');

        $forma = FormA::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR,
            'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
            'no_ssm' => 'A-SWEEP-TEST', 'no_lesen' => 'LA-SWEEP-TEST',
        ]);

        $htmlBefore = $this->actingAs($phd)->get(route('phd.shuttle-3-view-formA', $forma->id))->assertOk()->getContent();
        $this->assertStringContainsString('TIDAK LENGKAP</button>', $htmlBefore);

        $this->actingAs($phd)->post(route('update_status_form3A', $forma->id), [])
            ->assertStatus(302)->assertSessionDoesntHaveErrors();

        $forma->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $forma->status);

        $htmlAfter = $this->actingAs($phd)->get(route('phd.shuttle-3-view-formA', $forma->id))->assertOk()->getContent();
        $this->assertStringNotContainsString('TIDAK LENGKAP</button>', $htmlAfter,
            'PHD must not see the decision buttons again for a Form A they already decided.');
        $this->assertStringContainsString('telah pun disahkan', $htmlAfter);
    }

    /** @test */
    public function form_c_decision_buttons_disappear_once_phd_has_decided()
    {
        $ibk = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $ibk->shuttle;
        $shuttle->update(['shuttle_type' => '3']);
        $phd = $this->makeReviewerUser('PHD');

        $formc = FormC::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR, 'bulan' => 1,
            'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
            'no_ssm' => 'C-SWEEP-TEST', 'no_lesen' => 'LC-SWEEP-TEST',
        ]);

        // shuttle_3_formC_view() indexes species-level rows by position, so
        // it needs at least one KemasukanBahan row to render at all.
        $species = Spesis::first();
        KemasukanBahan::create([
            'formcs_id' => $formc->id, 'spesis_id' => $species->id,
            'shuttle_id' => $shuttle->id, 'bulan' => 1, 'tahun' => self::YEAR,
            'baki_stok' => 0, 'kayu_masuk' => 0, 'jumlah_stok_kayu_balak' => 0,
            'proses_masuk' => 0, 'proses_keluar' => 0, 'baki_stok_kehadapan' => 0,
        ]);

        $htmlBefore = $this->actingAs($phd)->get(route('phd.shuttle-3-view-formC', $formc->id))->assertOk()->getContent();
        $this->assertStringContainsString('TIDAK LENGKAP</button>', $htmlBefore);

        $this->actingAs($phd)->post(route('update_status_form3C', $formc->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formc->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formc->status);

        $htmlAfter = $this->actingAs($phd)->get(route('phd.shuttle-3-view-formC', $formc->id))->assertOk()->getContent();
        $this->assertStringNotContainsString('TIDAK LENGKAP</button>', $htmlAfter,
            'PHD must not see the decision buttons again for a Form C they already decided.');
        $this->assertStringContainsString('telah pun disahkan', $htmlAfter);
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
}
