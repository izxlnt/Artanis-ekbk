<?php

namespace Tests\Feature;

use App\Http\Livewire\ShuttleThree\EditForm3C;
use App\Models\FormA;
use App\Models\FormC;
use App\Models\Batch;
use App\Models\KemasukanBahan;
use App\Models\RecoveryRate;
use App\Models\Spesis;
use App\Models\UlasanPhd;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression tests for shuttle 3's "correct a Form C that PHD returned"
 * page (/pengguna/edit-shuttle-3C/{id}, the EditForm3C Livewire component),
 * reported from production:
 *
 * 1. Columns (04) "Jumlah Stok Kayu Balak" and (07) "Baki Stok ... Dibawa
 *    Ke Bulan Hadapan" showed no total at all when the page was opened.
 * 2. The saved total for (04)/(07) was wrong after editing an earlier
 *    column and resubmitting.
 * 3. The HANTAR (submit) button was missing/unusable after updating the
 *    form.
 *
 * Root causes:
 * - (1) and the JS side of (2)/(3): the outer wrapper around the entire
 *   edit form was a <table> directly wrapping a <form> (invalid HTML - a
 *   <table>'s only valid direct children are <caption>/<colgroup>/
 *   <thead>/<tbody>/<tfoot>/<tr>), which browsers "fix" by foster-parenting
 *   the <form> (and everything in it, including the HANTAR button) out of
 *   the table during parsing - the same class of bug already found and
 *   fixed for the Form B correction tool. Also, the readonly (04)/(07)
 *   cells have no wire:model of their own and are only ever populated by a
 *   JS function wired to OTHER fields' oninput - never automatically after
 *   wire:init='loadData' populates the real data - so they rendered blank
 *   until the user happened to retype something.
 * - The saved-value bug: this component's update() persisted
 *   $this->jumlah_stok_kayu_balak/$this->baki_stok_kehadapan directly, but
 *   those are only ever set once by loadData() from the record's OLD,
 *   pre-edit values - nothing in the view calls the calc*() methods that
 *   would otherwise keep them in sync with an edit to baki_stok/kayu_masuk/
 *   proses_masuk. This test covers that part directly, since it is the one
 *   piece with real, testable server-side behavior.
 */
class EditForm3CRecalculatesOnSaveTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function updating_an_earlier_column_recomputes_jumlah_stok_and_baki_stok_kehadapan_on_save()
    {
        RecoveryRate::firstOrCreate(
            ['shuttle_type' => '3'],
            ['min_recovery_rate' => 0.15, 'max_recovery_rate' => 0.99]
        );

        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => '3']);
        $user->shuttle_type = '3';
        $user->save();

        FormA::create(['shuttle_id' => $shuttle->id, 'tahun' => 2026, 'status' => 'Lulus']);

        $formc = FormC::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => 2026, 'bulan' => 3,
            'status' => 'Tidak Lengkap',
        ]);

        Batch::create(['shuttle_id' => $shuttle->id, 'tahun' => 2026, 'bulan' => 3, 'status' => 'Sedang Diproses']);

        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', 1)->get()->values();
        $target = $species[0];
        $indexOfTarget = 0;

        // Original submission: baki_stok=10, kayu_masuk=5 -> jumlah_stok_kayu_balak
        // should be 15, proses_masuk=2 -> baki_stok_kehadapan should be 13.
        // Stored here exactly as it would have been saved the first time.
        $row = KemasukanBahan::create([
            'spesis_id' => $target->id, 'shuttle_id' => $shuttle->id, 'formcs_id' => $formc->id,
            'bulan' => 3, 'tahun' => 2026,
            'baki_stok' => 10, 'kayu_masuk' => 5, 'jumlah_stok_kayu_balak' => 15,
            'proses_masuk' => 2, 'proses_keluar' => 1, 'baki_stok_kehadapan' => 13,
        ]);

        UlasanPhd::create(['ulasan' => 'Sila betulkan kemasukan kayu.', 'formcs_id' => $formc->id]);

        $test = Livewire::actingAs($user)->test(EditForm3C::class, ['shuttle_id' => $formc->id]);
        $test->call('loadData');

        // PHD rejected because kayu_masuk was wrong - IBK corrects it from 5 to 20.
        // jumlah_stok_kayu_balak must become 10+20=30, baki_stok_kehadapan 30-2=28.
        $test->set("kayu_masuk.{$indexOfTarget}", 20);
        $test->call('update');

        $row->refresh();

        $this->assertEquals(30, (float) $row->jumlah_stok_kayu_balak,
            'Jumlah Stok Kayu Balak (04) must be recomputed from the corrected kayu_masuk (10+20), not left at the stale original (15).');
        $this->assertEquals(28, (float) $row->baki_stok_kehadapan,
            'Baki Stok ... Dibawa Ke Bulan Hadapan (07) must be recomputed from the corrected total (30-2), not left at the stale original (13).');
    }

    /** @test */
    public function page_renders_without_the_invalid_table_wrapping_form_and_recomputes_on_load()
    {
        $user = User::factory()->create(['kategori_pengguna' => 'IBK', 'status' => 1, 'is_approved' => 1]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => '3']);

        $formc = FormC::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => 2026, 'bulan' => 3,
            'status' => 'Tidak Lengkap',
        ]);

        UlasanPhd::create(['ulasan' => 'Sila betulkan.', 'formcs_id' => $formc->id]);

        $html = $this->actingAs($user)->get(route('edit-form3c', $formc->id))->assertOk()->getContent();

        $this->assertStringNotContainsString('<table class="table table-striped table-bordered" id="" style="width: 100%;">',
            $html, 'The outer wrapper must no longer be a <table> directly wrapping a <form> (invalid HTML that gets foster-parented out of the table by the browser).');
        $this->assertStringContainsString("livewire:update", $html,
            'The page must recompute the readonly (04)/(07) cells once wire:init=\'loadData\' actually lands, not only on the next keystroke.');
    }
}
