<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class StatusOperasi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')-> insert(
            [

            'keterangan' => 'Operasi',
            ]
        );

        DB::table('statuses')-> insert(
            [

            'keterangan' => 'Tidak Operasi',
            ]
        );
    }
}
