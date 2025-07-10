<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class JenisKayuKumai extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_kayus')-> insert(
            [

            'keterangan' => 'A. Komponen Pintu (Door Components)',
            'aktif' => 1,

            ]
        );

        DB::table('jenis_kayus')-> insert(
            [

            'keterangan' => 'B. Bingkai Gambar (Picture Frames)',
            'aktif' => 1,

            ]
        );

        DB::table('jenis_kayus')-> insert(
            [

            'keterangan' => 'C. Gelendong Tangga (Staircase Spindle)',
            'aktif' => 1,

            ]
        );

        DB::table('jenis_kayus')-> insert(
            [

            'keterangan' => 'D. Tanggam / Produk Alat Ganti (Joinery / Turned Products)',
            'aktif' => 1,

            ]
        );

        DB::table('jenis_kayus')-> insert(
            [

            'keterangan' => 'E. Lain-lain Profil Kumai (Other Moulding Profiles) (Nyatakan)',
            'aktif' => 1,

            ]
        );
    }
}
