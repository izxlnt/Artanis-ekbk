<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class JenisPembeliShuttle3 extends Seeder
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

            'keterangan' => 'Pembuat & pengilang perabot dan tanggam (joinery)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pengilang kayu kumai',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Industri pembinaan (termasuk pembina bangunan dan kontraktor)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pembuat kapal, bot dan perahu',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pengilang kotak (boxes), tong (crates), dan pengalas kayu (pallets)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Industri perlombongan',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Agen / pengedar (Dealer)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Pembekal stor kayu dan barangan logam (Timber Merchant)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Sektor awam (Nyatakan)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

        DB::table('pembelis')-> insert(
            [

            'keterangan' => 'Lain-lain (Nyatakan)',
            'shuttle' => '3',
            'aktif' => 1,

            ]
        );

    }
}
