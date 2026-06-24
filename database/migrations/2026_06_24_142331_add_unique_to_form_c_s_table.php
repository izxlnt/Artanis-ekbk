<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUniqueToFormCSTable extends Migration
{
    public function up()
    {
        // Step 1: Identify which FormC id to KEEP per (shuttle_id, tahun, bulan) group.
        // Priority: the filled record with the highest id. If all are empty, keep the highest id.
        $keepIds = DB::select("
            SELECT
                CASE
                    WHEN MAX(CASE WHEN status != 'Tidak Diisi' THEN id END) IS NOT NULL
                    THEN MAX(CASE WHEN status != 'Tidak Diisi' THEN id END)
                    ELSE MAX(id)
                END AS keep_id
            FROM form_c_s
            GROUP BY shuttle_id, tahun, bulan
        ");

        $keepIdList = array_column($keepIds, 'keep_id');

        if (empty($keepIdList)) {
            return;
        }

        $placeholders = implode(',', $keepIdList);

        // Step 2: Delete child rows linked to duplicate FormC records before removing them.
        DB::statement("
            DELETE FROM kemasukan_bahans
            WHERE formcs_id IS NOT NULL
              AND formcs_id NOT IN ({$placeholders})
        ");

        DB::statement("
            DELETE FROM ulasan_phds
            WHERE formcs_id IS NOT NULL
              AND formcs_id NOT IN ({$placeholders})
        ");

        DB::statement("
            DELETE FROM ulasan_ipjpsms
            WHERE formcs_id IS NOT NULL
              AND formcs_id NOT IN ({$placeholders})
        ");

        // Step 3: Delete the duplicate FormC records themselves.
        DB::statement("
            DELETE FROM form_c_s
            WHERE id NOT IN ({$placeholders})
        ");

        // Step 4: Add unique constraint so duplicates cannot happen again.
        Schema::table('form_c_s', function (Blueprint $table) {
            $table->unique(['shuttle_id', 'tahun', 'bulan'], 'form_c_s_shuttle_tahun_bulan_unique');
        });
    }

    public function down()
    {
        Schema::table('form_c_s', function (Blueprint $table) {
            $table->dropUnique('form_c_s_shuttle_tahun_bulan_unique');
        });
    }
}
