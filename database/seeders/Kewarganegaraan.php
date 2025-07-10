<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class Kewarganegaraan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warganegaras')-> insert(
            [

            'keterangan' => 'Bumiputera',
            'aktif' => 1,

            ]
        );

        DB::table('warganegaras')-> insert(
            [

            'keterangan' => 'Bukan Bumiputera',
            'aktif' => 1,

            ]
        );

        DB::table('warganegaras')-> insert(
            [

            'keterangan' => 'Bukan Warganegara',
            'aktif' => 1,

            ]
        );
    }
}
