<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillFormCSShuttleType extends Migration
{
    /**
     * form_c_s.shuttle_type was left NULL by several creation paths that
     * forgot to stamp it (UserController's "ensure all 12 months exist"
     * loops for shuttle 3/4/5, and ShuttleThree\FormCController's
     * firstOrCreate calls — all now fixed to always set it). This backfills
     * existing NULL rows from each row's own shuttle, rather than assuming
     * shuttle_type 3 — the NULLs span all three shuttle types.
     */
    public function up()
    {
        $shuttleTypes = DB::table('shuttles')->pluck('shuttle_type', 'id');

        $rows = DB::table('form_c_s')->whereNull('shuttle_type')->get(['id', 'shuttle_id']);

        $updated = 0;
        $skipped = 0;
        foreach ($rows as $row) {
            $type = $shuttleTypes[$row->shuttle_id] ?? null;
            if ($type === null) {
                $skipped++;
                continue;
            }
            DB::table('form_c_s')->where('id', $row->id)->update(['shuttle_type' => $type]);
            $updated++;
        }

        echo PHP_EOL;
        echo 'Backfill form_c_s.shuttle_type selesai:' . PHP_EOL;
        echo '  Rekod dikemaskini : ' . $updated . PHP_EOL;
        echo '  Rekod dilangkau (shuttle tiada/dipadam): ' . $skipped . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        // Data correction — cannot automatically reverse (original NULLs weren't backed up per-row)
    }
}
