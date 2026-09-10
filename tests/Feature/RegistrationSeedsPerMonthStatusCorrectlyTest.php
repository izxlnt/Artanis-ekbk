<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormD;
use App\Models\HakMilik;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Regression test for a real bug found while investigating a production
 * report ("August shows as already filled even though July was never
 * filled"): PermohonanPenggunaController's registration-approval step seeds
 * a factory's 12 Form D/Form E rows for the year using a `$status` variable
 * that was never recomputed inside the Form D/E creation loops - it was
 * simply left over from the LAST iteration of the earlier Form C loop
 * (bulan=12), so every one of the 12 Form D/E rows for a newly-approved
 * factory got the exact same status, regardless of `$i` (the month being
 * created).
 *
 * This bug was invisible through the normal "fill" flow because the IBK's
 * own fill-page controllers self-heal a single row's stale "Ditutup" status
 * the moment that row is actually visited - but the raw seeded data was
 * wrong from the moment of approval, which is what this test checks
 * directly, before any page visit has a chance to mask it.
 */
class RegistrationSeedsPerMonthStatusCorrectlyTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function shuttle_3_form_d_gets_independent_status_per_month()
    {
        $shuttle = $this->registerAndApprove('3');

        // Approval happens "today" (month 9 per the test clock) - month 1
        // has already started, month 11 has not.
        $monthAlreadyOpen = FormD::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 1)->first();
        $monthNotYetOpen = FormD::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 11)->first();

        $this->assertNotNull($monthAlreadyOpen);
        $this->assertNotNull($monthNotYetOpen);
        $this->assertSame('Tidak Diisi', $monthAlreadyOpen->status, 'Month 1 (already started) must be seeded as fillable.');
        $this->assertSame('Ditutup', $monthNotYetOpen->status, 'Month 11 (not started yet) must be seeded as the closed placeholder.');
    }

    /** @test */
    public function shuttle_4_form_d_and_e_get_independent_status_per_month()
    {
        $shuttle = $this->registerAndApprove('4');

        foreach ([Form4D::class, Form4E::class] as $model) {
            $monthAlreadyOpen = $model::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 1)->first();
            $monthNotYetOpen = $model::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 11)->first();

            $this->assertNotNull($monthAlreadyOpen);
            $this->assertNotNull($monthNotYetOpen);
            $this->assertSame('Tidak Diisi', $monthAlreadyOpen->status, "{$model}: month 1 (already started) must be seeded as fillable.");
            $this->assertSame('Ditutup', $monthNotYetOpen->status, "{$model}: month 11 (not started yet) must be seeded as the closed placeholder.");
        }
    }

    /** @test */
    public function shuttle_5_form_d_and_e_get_independent_status_per_month()
    {
        $shuttle = $this->registerAndApprove('5');

        foreach ([Form5D::class, Form5E::class] as $model) {
            $monthAlreadyOpen = $model::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 1)->first();
            $monthNotYetOpen = $model::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->where('bulan', 11)->first();

            $this->assertNotNull($monthAlreadyOpen);
            $this->assertNotNull($monthNotYetOpen);
            $this->assertSame('Tidak Diisi', $monthAlreadyOpen->status, "{$model}: month 1 (already started) must be seeded as fillable.");
            $this->assertSame('Ditutup', $monthNotYetOpen->status, "{$model}: month 11 (not started yet) must be seeded as the closed placeholder.");
        }
    }

    private function registerAndApprove(string $shuttleType): Shuttle
    {
        $unique = $shuttleType . '-statuscheck-' . Str::random(6) . '-' . now()->timestamp;
        $daerah = Daerah::inRandomOrder()->first();
        $this->assertNotNull($daerah, 'Daerah lookup table must be seeded.');
        $hakMilik = HakMilik::inRandomOrder()->first();
        $this->assertNotNull($hakMilik, 'HakMilik lookup table must be seeded.');

        $fakeImage = fn () => UploadedFile::fake()->create('doc.jpg', 50, 'image/jpeg');

        $response = $this->post(route('register'), [
            'name' => 'Test Pengguna ' . $unique,
            'email' => "sub-{$unique}@example.test",
            'email_kilang' => "kilang-{$unique}@example.test",
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'jawatan' => 'Pengurus',
            'jantina' => 'Lelaki',
            'warganegara' => 'Malaysia',
            'kaum' => 'Melayu',
            'no_kad_pengenalan' => '900115' . '14' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT),
            'gambar_ic_hadapan' => $fakeImage(),
            'gambar_ic_belakang' => $fakeImage(),
            'gambar_passport' => $fakeImage(),
            'shuttle_type' => $shuttleType,
            'tahun' => (string) self::YEAR,
            'negeri_id' => (string) $daerah->id,
            'daerah_id' => (string) $daerah->id,
            'nama_kilang' => 'Kilang Ujian ' . $unique,
            'alamat_kilang_1' => 'No. 1, Jalan Ujian',
            'alamat_kilang_poskod' => '50000',
            'alamat_kilang_daerah' => $daerah->daerah_hutan,
            'alamat_sama' => '1',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM' . $unique,
            'tarikh_tubuh' => '2010-01-01',
            'tarikh_operasi' => '2010-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '500000',
            'no_lesen' => 'LESEN' . $unique,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
            'sijil_ssm' => $fakeImage(),
            'lesen_kilang' => $fakeImage(),
        ]);

        $response->assertSessionDoesntHaveErrors();
        $response->assertStatus(302);

        $shuttle = Shuttle::where('no_ssm', 'like', 'SSM' . $unique . '%')->first();
        $this->assertNotNull($shuttle, 'Registration must create a Shuttle row.');

        $pengguna = PenggunaKilang::where('email', "sub-{$unique}@example.test")->first();
        $this->assertNotNull($pengguna, 'Registration must create a PenggunaKilang row.');

        $bpe = User::where('kategori_pengguna', 'BPE')->first();
        $this->assertNotNull($bpe, 'A BPE/IPJPSM user must exist to approve registrations.');

        $this->actingAs($bpe)->post(route('sahkan_permohonan_pengguna_ipjpsm', $pengguna->id))
            ->assertStatus(302)->assertSessionDoesntHaveErrors();

        return $shuttle->fresh();
    }
}
