<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixFormCWronglyMarkedTiadaPengeluaran extends Migration
{
    /**
     * The Lain-Lain (final) wizard page only offered a "Hantar" (Submit) button
     * when besar_jumlah_kayu_masuk != 0 - otherwise the only button available was
     * "Tiada Pengeluaran" (No Production), forcing that label onto months where
     * the mill had processed existing stock (proses_masuk/proses_keluar > 0) but
     * simply received no new wood that month. This resets FormC records that were
     * marked Tiada Pengeluaran despite having real kayu_masuk/proses_masuk/
     * proses_keluar on file back to Sedang Diproses, matching the Batch status
     * they were already sitting at (none had progressed past PHD/JPN review).
     */
    public function up()
    {
        $affected = DB::table('form_c_s as fc')
            ->join('kemasukan_bahans as kb', 'kb.formcs_id', '=', 'fc.id')
            ->where('fc.status', 'Tiada Pengeluaran')
            ->groupBy('fc.id')
            ->havingRaw('SUM(kb.kayu_masuk) > 0 OR SUM(kb.proses_masuk) > 0 OR SUM(kb.proses_keluar) > 0')
            ->pluck('fc.id');

        DB::table('form_c_s')
            ->whereIn('id', $affected)
            ->update([
                'status' => 'Sedang Diproses',
                'tiada_pengeluaran' => 0,
                'updated_at' => now(),
            ]);

        echo PHP_EOL;
        echo 'Fix wrongly-marked Tiada Pengeluaran selesai:' . PHP_EOL;
        echo '  FormC direset ke Sedang Diproses: ' . $affected->count() . ' rekod' . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        // Data correction - the Tiada Pengeluaran label being replaced was wrong; not restored.
    }
}
