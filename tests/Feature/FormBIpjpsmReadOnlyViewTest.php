<?php

namespace Tests\Feature;

use App\Models\FormB;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression test for a real bug reported from a production screenshot:
 * IPJPSM's "verify Form B" screen was rendering the editable "Data
 * Cleaning" Livewire component (shuttle-three.data-cleaning3-b) as the
 * primary view, showing each submitted figure immediately followed by a
 * separate blank editable input box next to it.
 *
 * IPJPSM (and PHD) were later given editing power back - see
 * FormBCorrectionTest - but as a single pre-filled box per field (the
 * shuttle-three.form-b-correction component), never that old side-by-side
 * layout or its component name. This test now confirms the legacy
 * component is gone for good and the Sahkan/Tolak form is still there,
 * regardless of which of the two (read-only vs. correctable) the page
 * renders for a given form status.
 */
class FormBIpjpsmReadOnlyViewTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SUKU = 1;

    /** @test */
    public function shuttle_3_ipjpsm_form_b_view_has_no_legacy_data_cleaning_tool()
    {
        $this->runForShuttle('3', \App\Http\Livewire\ShuttleThree\FormB::class, 'user.shuttle-3-formB', 'ipjpsm.shuttle-3-view-formB');
    }

    /** @test */
    public function shuttle_4_ipjpsm_form_b_view_has_no_legacy_data_cleaning_tool()
    {
        $this->runForShuttle('4', \App\Http\Livewire\ShuttleFour\FormB::class, 'user.shuttle-4-formB', 'ipjpsm.shuttle-4-view-formB');
    }

    /** @test */
    public function shuttle_5_ipjpsm_form_b_view_has_no_legacy_data_cleaning_tool()
    {
        $this->runForShuttle('5', \App\Http\Livewire\ShuttleFive\FormB::class, 'user.shuttle-5-formB', 'ipjpsm.shuttle-5-view-formB');
    }

    private function runForShuttle(string $shuttleType, string $formBComponent, string $fillRouteName, string $ipjpsmRouteName): void
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

        $test = Livewire::actingAs($user)->test($formBComponent, ['year' => self::YEAR, 'suku_id' => self::SUKU]);
        foreach ($kategori as $i => $k) {
            $test->set("pekerja_wargabumi_lelaki.{$i}", 100 + $k->id)->set("gaji_lelaki.{$i}", 5000);
        }
        $test->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $this->assertNotNull($formb, "Shuttle {$shuttleType}: FormB row missing after submit.");

        $phd = $this->makeReviewerUser('PHD');
        $this->actingAs($phd)->post(route('update_status_form3B', $formb->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Data lengkap.',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();

        $formb->refresh();
        $this->assertSame('Dihantar ke IPJPSM', $formb->status);

        $bpe = $this->makeReviewerUser('BPE');
        $response = $this->actingAs($bpe)->get(route($ipjpsmRouteName, $formb->id));
        $response->assertOk();
        $response->assertSee((string) (100 + $kategori->first()->id));
        $response->assertDontSee('pekerja_wargabumi_lelaki_cleaning', false);
        $response->assertDontSee('data-cleaning3-b', false);
        $response->assertSee(route('update_status_form3B_ipjpsm', $formb->id), false);
    }

    private function makeReviewerUser(string $kategoriPengguna): User
    {
        return User::factory()->create([
            'kategori_pengguna' => $kategoriPengguna,
            'status' => 1,
            'is_approved' => 1,
            'password' => Hash::make('password'),
        ]);
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
            'no_ssm' => 'SSM-IPJPSM-VIEW-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'ipjpsm-view-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-IPJPSM-VIEW-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
}
