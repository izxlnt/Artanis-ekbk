<?php

namespace Tests\Feature;

use App\Models\FormB;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * After PHD decides a Form B (Simpan or Tidak Lengkap), they used to land
 * back on the general shuttle Form B list (phd.shuttle-X-listB). Per
 * request, they should land on their own Senarai Tugasan (task list) page
 * instead (phd.senarai-tugasan-XB) - the page they actually came from to
 * review the form.
 */
class PhdFormBRedirectsToSenaraiTugasanTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;
    private const SUKU = 1;

    /** @test */
    public function phd_deciding_shuttle_3_form_b_redirects_to_senarai_tugasan()
    {
        $this->runForShuttle('3', \App\Http\Livewire\ShuttleThree\FormB::class, 'user.shuttle-3-formB', 'phd.senarai-tugasan-3B');
    }

    /** @test */
    public function phd_deciding_shuttle_4_form_b_redirects_to_senarai_tugasan()
    {
        $this->runForShuttle('4', \App\Http\Livewire\ShuttleFour\FormB::class, 'user.shuttle-4-formB', 'phd.senarai-tugasan-4B');
    }

    /** @test */
    public function phd_deciding_shuttle_5_form_b_redirects_to_senarai_tugasan()
    {
        $this->runForShuttle('5', \App\Http\Livewire\ShuttleFive\FormB::class, 'user.shuttle-5-formB', 'phd.senarai-tugasan-5B');
    }

    private function runForShuttle(string $shuttleType, string $formBComponent, string $fillRouteName, string $expectedRouteName): void
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
            $fill->set("pekerja_wargabumi_lelaki.{$i}", 1)->set("gaji_lelaki.{$i}", 5000);
        }
        $fill->call('store');

        $formb = FormB::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('suku_tahun', self::SUKU)->first();
        $phd = User::factory()->create(['kategori_pengguna' => 'PHD', 'status' => 1, 'is_approved' => 1]);

        // Approving redirects to the Senarai Tugasan page, not the shuttle list.
        $this->actingAs($phd)->post(route('update_status_form3B', $formb->id), [
            'status' => 'Dihantar ke IPJPSM',
            'ulasan_phd' => 'Lengkap.',
        ])->assertRedirect(route($expectedRouteName, date('Y')));

        // Rejecting must also redirect there, not just approving.
        $formb->status = 'Sedang Diproses';
        $formb->save();
        $this->actingAs($phd)->post(route('update_status_form3B', $formb->id), [
            'status' => 'Tidak Lengkap',
            'ulasan_phd' => 'Sila perbetulkan.',
        ])->assertRedirect(route($expectedRouteName, date('Y')));
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
            'no_ssm' => 'SSM-REDIRECT-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'redirect-test-kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-REDIRECT-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ])->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
}
