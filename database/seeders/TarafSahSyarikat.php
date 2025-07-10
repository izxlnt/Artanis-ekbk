<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TarafSahSyarikat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taraf_syarikats')-> insert(
            [

            'keterangan' => 'Hak Milik Perseorangan',
            ]
        );

        DB::table('taraf_syarikats')-> insert(
            [

            'keterangan' => 'Perkongsian',
            ]
        );

        DB::table('taraf_syarikats')-> insert(
            [

            'keterangan' => 'Syarikat Sendirian Berhad',
            ]
        );

        DB::table('taraf_syarikats')-> insert(
            [

            'keterangan' => 'Syarikat Awam Berhad',
            ]
        );

        DB::table('taraf_syarikats')-> insert(
            [

            'keterangan' => 'Lain-lain',

            ]
        );
    }
}
