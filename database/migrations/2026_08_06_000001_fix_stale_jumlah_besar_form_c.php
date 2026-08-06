<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixStaleJumlahBesarFormC extends Migration
{
    /**
     * "Jumlah Besar" (grand total across all 5 wood groups) was only ever computed
     * and saved when the Lain-Lain (final wizard) step was submitted. Editing an
     * earlier group afterwards without resubmitting Lain-Lain left the stored grand
     * total stale. This recomputes it from each group's own current totals for
     * every FormC record where the two disagree.
     */
    public function up()
    {
        $groupTotals = DB::table('kemasukan_bahans as kb')
            ->join('spesis as sp', 'sp.id', '=', 'kb.spesis_id')
            ->select(
                'kb.formcs_id',
                'sp.kumpulan_kayu_id as kkid',
                DB::raw('MAX(kb.jumlah_baki_stok) as jumlah_baki_stok'),
                DB::raw('MAX(kb.jumlah_kayu_masuk) as jumlah_kayu_masuk'),
                DB::raw('MAX(kb.total_stok_kayu_balak) as total_stok_kayu_balak'),
                DB::raw('MAX(kb.total_kayu_masuk_jentera) as total_kayu_masuk_jentera'),
                DB::raw('MAX(kb.total_kayu_keluar_jentera) as total_kayu_keluar_jentera'),
                DB::raw('MAX(kb.total_kayu_dibawa_bulan_hadapan) as total_kayu_dibawa_bulan_hadapan')
            )
            ->groupBy('kb.formcs_id', 'sp.kumpulan_kayu_id')
            ->get()
            ->groupBy('formcs_id');

        $lainLainRows = DB::table('kemasukan_bahans as kb')
            ->join('spesis as sp', 'sp.id', '=', 'kb.spesis_id')
            ->where('sp.kumpulan_kayu_id', 5)
            ->select(
                'kb.id',
                'kb.formcs_id',
                'kb.jumlah_besar_baki_stok_bulan_lepas',
                'kb.jumlah_besar_kemasukan_kayu_ke_kilang',
                'kb.jumlah_besar_stok_kayu_balak',
                'kb.jumlah_besar_kayu_ke_dalam_jentera',
                'kb.jumlah_besar_pengeluaran_kayu_daripada_jentera',
                'kb.jumlah_besar_baki_stok_bulan_depan'
            )
            ->get()
            ->groupBy('formcs_id');

        $checked = 0;
        $fixed = 0;

        foreach ($lainLainRows as $formcsId => $rows) {
            $groups = $groupTotals[$formcsId] ?? collect();
            if ($groups->count() !== 5) {
                continue; // incomplete month, matches live controller's guard
            }
            $checked++;

            $computed = [
                'jumlah_besar_baki_stok_bulan_lepas' => 0.0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0.0,
                'jumlah_besar_stok_kayu_balak' => 0.0,
                'jumlah_besar_kayu_ke_dalam_jentera' => 0.0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0.0,
                'jumlah_besar_baki_stok_bulan_depan' => 0.0,
            ];
            foreach ($groups as $g) {
                $computed['jumlah_besar_baki_stok_bulan_lepas'] += (float) $g->jumlah_baki_stok;
                $computed['jumlah_besar_kemasukan_kayu_ke_kilang'] += (float) $g->jumlah_kayu_masuk;
                $computed['jumlah_besar_stok_kayu_balak'] += (float) $g->total_stok_kayu_balak;
                $computed['jumlah_besar_kayu_ke_dalam_jentera'] += (float) $g->total_kayu_masuk_jentera;
                $computed['jumlah_besar_pengeluaran_kayu_daripada_jentera'] += (float) $g->total_kayu_keluar_jentera;
                $computed['jumlah_besar_baki_stok_bulan_depan'] += (float) $g->total_kayu_dibawa_bulan_hadapan;
            }

            $stored = $rows->first();
            $isStale = false;
            foreach ($computed as $field => $value) {
                if (abs($value - (float) $stored->$field) > 0.05) {
                    $isStale = true;
                    break;
                }
            }

            if (!$isStale) {
                continue;
            }

            DB::table('kemasukan_bahans')
                ->whereIn('id', $rows->pluck('id'))
                ->update($computed + ['updated_at' => now()]);

            $fixed++;
        }

        echo PHP_EOL;
        echo 'Fix stale Jumlah Besar selesai:' . PHP_EOL;
        echo '  FormC Lain-Lain diperiksa (5 kumpulan lengkap): ' . $checked . ' rekod' . PHP_EOL;
        echo '  Jumlah Besar diperbetulkan                     : ' . $fixed . ' rekod' . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        // Data correction — the stale values being replaced were wrong; not restored.
    }
}
