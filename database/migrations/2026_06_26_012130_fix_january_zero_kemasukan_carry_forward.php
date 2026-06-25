<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixJanuaryZeroKemasukanCarryForward extends Migration
{
    public function up()
    {
        // Find all January FormC records that are NOT yet fully submitted.
        // We leave Sedang Diproses / Lulus / Dihantar / Tiada Pengeluaran untouched —
        // those were submitted by the user intentionally (even if baki_stok looks wrong).
        $janFormCs = DB::table('form_c_s')
            ->where('bulan', 1)
            ->whereIn('status', ['Sedang Diisi', 'Tidak Diisi', 'Tidak Lengkap'])
            ->get(['id', 'shuttle_id', 'tahun', 'status']);

        $deleted  = 0;
        $skipped  = 0;
        $noRows   = 0;

        foreach ($janFormCs as $fc) {
            $totalRows = DB::table('kemasukan_bahans')->where('formcs_id', $fc->id)->count();

            if ($totalRows === 0) {
                $noRows++;
                continue;
            }

            // If any row has real entered data, leave this record alone
            $nonZero = DB::table('kemasukan_bahans')
                ->where('formcs_id', $fc->id)
                ->where(function ($q) {
                    $q->where('proses_masuk', '>', 0)
                      ->orWhere('kayu_masuk', '>', 0)
                      ->orWhere('baki_stok', '>', 0);
                })
                ->count();

            if ($nonZero > 0) {
                $skipped++;
                continue;
            }

            // All rows are zero — but only reset if December of the previous year
            // actually has carry-forward data. If December is also empty, January's
            // zeros are correct and the user does NOT need to reopen the form.
            $decFormC = DB::table('form_c_s')
                ->where('shuttle_id', $fc->shuttle_id)
                ->where('tahun', $fc->tahun - 1)
                ->where('bulan', 12)
                ->first(['id']);

            $decHasCarryForward = $decFormC && DB::table('kemasukan_bahans')
                ->where('formcs_id', $decFormC->id)
                ->where('baki_stok_kehadapan', '>', 0)
                ->exists();

            if (!$decHasCarryForward) {
                $noRows++; // December also empty — January zeros are correct, skip
                continue;
            }

            // December has carry-forward data but January shows zeros — bug confirmed.
            // Delete January rows so controller recreates with correct values on next open.
            DB::table('kemasukan_bahans')->where('formcs_id', $fc->id)->delete();

            // Extend window so user can fill the form
            DB::table('form_c_s')
                ->where('id', $fc->id)
                ->update([
                    'tarikh_buka_borang'  => DB::raw('IFNULL(tarikh_buka_borang, CURDATE())'),
                    'tarikh_tutup_borang' => '2099-12-31',
                    'updated_at'          => now(),
                ]);

            $deleted++;
        }

        echo PHP_EOL;
        echo 'Fix January carry-forward selesai:' . PHP_EOL;
        echo '  FormC Januari ditemui           : ' . $janFormCs->count() . ' rekod' . PHP_EOL;
        echo '  Tiada kemasukan rows (skip)     : ' . $noRows   . ' rekod' . PHP_EOL;
        echo '  Ada data nyata (skip)           : ' . $skipped  . ' rekod' . PHP_EOL;
        echo '  Rows dipadam, window dibuka     : ' . $deleted  . ' FormC' . PHP_EOL;
        echo PHP_EOL;
        echo '  Pengguna perlu buka semula Borang C Januari — nilai' . PHP_EOL;
        echo '  dari Disember tahun lepas akan diisi secara automatik.' . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        // Cannot restore deleted kemasukan rows — data was all-zero, no real loss
    }
}
