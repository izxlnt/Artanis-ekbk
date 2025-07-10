<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class JenisPembeliShuttle4 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pembuat & pengilang perabot',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pembinaan bangunan dan kontraktor ("shuttering boards" dan "formwork plywood")',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pengilang kotak (boxes), tong (crates), dan pengalas kayu (pallets)',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Penghiasan dalam bangunan dan rumah (interior decoration for partitioning and various panel uses)',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Agen / Pengedar (Dealer)',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pembekal stor kayu dan barangan logam (Timber Merchant)',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Lain-lain (Nyatakan)',
            'shuttle' => '4',
            'aktif' => 1,

            ]
        );

    }
}
