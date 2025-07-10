<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class HakMilikSyarikat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hak_miliks')-> insert(
            [

            'keterangan' => 'Warganegara Malaysia',
            'aktif' => 1,

            ]
        );

        DB::table('hak_miliks')-> insert(
            [

            'keterangan' => 'Bukan Warganegara Malaysia',
            'aktif' => 1,

            ]
        );
    }
}
