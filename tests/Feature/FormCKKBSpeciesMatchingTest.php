<?php

namespace Tests\Feature;

use App\Models\FormA;
use App\Models\FormC;
use App\Models\KemasukanBahan;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Regression tests for the Form C "species swap" bug: carry-forward stock and
 * saved values must be matched by spesis_id, never by array/row position.
 *
 * These tests exercise the live route flow (ShuttleThree\FormCController),
 * which is what user.shuttle-3-formC.KKB actually redirects to in production.
 */
class FormCKKBSpeciesMatchingTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $shuttle;
    private $speciesA;
    private $speciesB;

    protected function setUp(): void
    {
        parent::setUp();

        RecoveryRate::firstOrCreate(
            ['shuttle_type' => '3'],
            ['min_recovery_rate' => 0.15, 'max_recovery_rate' => 0.99]
        );

        // The first two species in the KKB (kumpulan_kayu_id = 1) group, in the
        // exact order the app iterates them (Spesis::orderBy('kumpulan_kayu_id')->where(...)->get()).
        $ordered = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', 1)->get()->values();
        $this->speciesA = $ordered[0];
        $this->speciesB = $ordered[1];

        $this->user = User::factory()->create([
            'kategori_pengguna' => 'IBK',
            'status' => 1,
            'is_approved' => 1,
        ]);
        $this->shuttle = $this->user->shuttle;
        $this->shuttle->update(['shuttle_type' => '3']);
        $this->user->shuttle_type = '3';
        $this->user->save();

        FormA::create([
            'shuttle_id' => $this->shuttle->id,
            'tahun' => 2026,
            'status' => 'Lengkap',
        ]);
    }

    /** @test */
    public function view_page_carries_forward_stock_to_the_correct_species_when_last_month_rows_are_stored_out_of_order()
    {
        $formJan = FormC::create([
            'shuttle_id' => $this->shuttle->id,
            'shuttle_type' => '3',
            'tahun' => 2026,
            'bulan' => 1,
            'status' => 'Sedang Diisi',
        ]);

        // Insert January's rows with speciesB FIRST (lower id) and speciesA SECOND
        // (higher id) so an unordered SELECT returns them in the opposite order to
        // $this->species, reproducing the exact conditions that triggered the bug.
        KemasukanBahan::create([
            'spesis_id' => $this->speciesB->id,
            'shuttle_id' => $this->shuttle->id,
            'bulan' => 1,
            'tahun' => 2026,
            'formcs_id' => $formJan->id,
            'baki_stok_kehadapan' => 111,
            'total_kayu_dibawa_bulan_hadapan' => 222,
        ]);
        KemasukanBahan::create([
            'spesis_id' => $this->speciesA->id,
            'shuttle_id' => $this->shuttle->id,
            'bulan' => 1,
            'tahun' => 2026,
            'formcs_id' => $formJan->id,
            'baki_stok_kehadapan' => 333,
            'total_kayu_dibawa_bulan_hadapan' => 444,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('user.view.shuttle-3-formC.KKB', [2, 2026]));

        $response->assertOk();

        $bakiStoks = $response->viewData('baki_stoks');
        $species = $response->viewData('species')->values();

        $indexA = $species->search(fn ($s) => $s->id === $this->speciesA->id);
        $indexB = $species->search(fn ($s) => $s->id === $this->speciesB->id);

        $this->assertSame(333.0, (float) $bakiStoks[$indexA],
            'Species A must carry forward its OWN January stock (333), not species B\'s.');
        $this->assertSame(111.0, (float) $bakiStoks[$indexB],
            'Species B must carry forward its OWN January stock (111), not species A\'s.');
    }

    /** @test */
    public function store_updates_the_correct_species_row_when_existing_records_are_out_of_order()
    {
        $formFeb = FormC::create([
            'shuttle_id' => $this->shuttle->id,
            'shuttle_type' => '3',
            'tahun' => 2026,
            'bulan' => 2,
            'status' => 'Sedang Diisi',
        ]);

        // Existing February rows already saved out of species order.
        KemasukanBahan::create([
            'spesis_id' => $this->speciesB->id,
            'shuttle_id' => $this->shuttle->id,
            'bulan' => 2,
            'tahun' => 2026,
            'formcs_id' => $formFeb->id,
            'baki_stok' => 10,
            'kayu_masuk' => 0,
        ]);
        KemasukanBahan::create([
            'spesis_id' => $this->speciesA->id,
            'shuttle_id' => $this->shuttle->id,
            'bulan' => 2,
            'tahun' => 2026,
            'formcs_id' => $formFeb->id,
            'baki_stok' => 20,
            'kayu_masuk' => 0,
        ]);

        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', 1)->get()->values();
        $indexA = $species->search(fn ($s) => $s->id === $this->speciesA->id);
        $indexB = $species->search(fn ($s) => $s->id === $this->speciesB->id);

        $kayuMasuk = [];
        $bakiStoks = [];
        foreach ($species as $i => $s) {
            $bakiStoks[$i] = $i === $indexA ? 20 : ($i === $indexB ? 10 : 0);
            $kayuMasuk[$i] = $i === $indexA ? 555 : ($i === $indexB ? 777 : 0);
        }

        $this->actingAs($this->user)
            ->post(route('user.view.shuttle-3-formC.KKB.store', [2, 2026]), [
                'baki_stoks' => $bakiStoks,
                'kayu_masuk' => $kayuMasuk,
                'jumlah_stok_kayu_balak' => $bakiStoks,
                'proses_masuk' => array_fill(0, count($species), 0),
                'proses_keluar' => array_fill(0, count($species), 0),
                'baki_stok_kehadapan' => $bakiStoks,
                'jumlah_baki_stok' => array_fill(0, count($species), 0),
                'jumlah_kayu_masuk' => array_fill(0, count($species), 0),
                'total_stok_kayu_balak' => array_fill(0, count($species), 0),
                'total_kayu_masuk_jentera' => array_fill(0, count($species), 0),
                'total_kayu_keluar_jentera' => array_fill(0, count($species), 0),
                'total_kayu_dibawa_bulan_hadapan' => array_fill(0, count($species), 0),
            ]);

        $rowA = KemasukanBahan::where('formcs_id', $formFeb->id)->where('spesis_id', $this->speciesA->id)->first();
        $rowB = KemasukanBahan::where('formcs_id', $formFeb->id)->where('spesis_id', $this->speciesB->id)->first();

        $this->assertEquals(555, $rowA->kayu_masuk,
            'Species A\'s row must be updated with species A\'s submitted value (555), not species B\'s.');
        $this->assertEquals(777, $rowB->kayu_masuk,
            'Species B\'s row must be updated with species B\'s submitted value (777), not species A\'s.');
    }
}
