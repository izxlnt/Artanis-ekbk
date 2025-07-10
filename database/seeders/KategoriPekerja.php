<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class KategoriPekerja extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Pemilik dan Rakan Kongsi',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Pengurusan Profesional',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Pengurusan Bukan Profesional',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Juruteknik dan Penyeliaan',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Perkeranian',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Pekerja Am',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Pekerja Kilang',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );

        DB::table('kategori_guna_tenagas')-> insert(
            [

            'keterangan' => 'Pekerja Kilang Yang Diambil Bekerja Melalui Kontraktor',
            'gaji_min' => '1200',
            'gaji_max' => '2000',
            'aktif' => 1,

            ]
        );
    }
}
