<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class KumpulanKayuKayan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kumpulan_kayus')-> insert(
            [

            'keterangan' => 'Kayu Keras Berat',
            'singkatan' => 'KKB / HHW',
            ]
        );

        DB::table('kumpulan_kayus')-> insert(
            [

            'keterangan' => 'Kayu Keras Sederhana',
            'singkatan' => 'KKS / MHW',
            ]
        );

        DB::table('kumpulan_kayus')-> insert(
            [

            'keterangan' => 'Kayu Keras Ringan',
            'singkatan' => 'KKR / LHW',
            ]
        );

        DB::table('kumpulan_kayus')-> insert(
            [

            'keterangan' => 'Kayu  Lembut',
            'singkatan' => 'Kayu Lembut / Softwood',
            ]
        );

        DB::table('kumpulan_kayus')-> insert(
            [

            'keterangan' => 'Lain-lain',
            'singkatan' => 'Lain-lain',
            ]
        );
    }
}
