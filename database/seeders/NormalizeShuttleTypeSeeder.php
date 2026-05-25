<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormalizeShuttleTypeSeeder extends Seeder
{
    public function run()
    {
        $tables = ['users', 'shuttles', 'pengguna_kilangs', 'formbs', 'form_c_s', 'form_d_s'];
        $fixed  = 0;

        foreach ($tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table) && DB::getSchemaBuilder()->hasColumn($table, 'shuttle_type')) {
                $count = DB::table($table)
                    ->whereRaw("shuttle_type != TRIM(shuttle_type)")
                    ->update(['shuttle_type' => DB::raw("TRIM(shuttle_type)")]);
                if ($count) {
                    $this->command->line("  FIXED {$count} row(s) in '{$table}'");
                    $fixed += $count;
                }
            }
        }

        $this->command->info("Done. Total shuttle_type rows fixed: {$fixed}");
    }
}
