<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RecoveryRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recovery_rates')->insert(
            [
                'shuttle_type' => '3',
                'min_recovery_rate' => '0.65',
                'max_recovery_rate' => '0.85',
            ]
        );

        DB::table('recovery_rates')->insert(
            [
                'shuttle_type' => '4',
                'min_recovery_rate' => '0.50',
                'max_recovery_rate' => '0.80',
            ]
        );

        DB::table('recovery_rates')->insert(
            [
                'shuttle_type' => '5',
                'min_recovery_rate' => '0.80',
                'max_recovery_rate' => '0.95',
            ]
        );
    }
}
