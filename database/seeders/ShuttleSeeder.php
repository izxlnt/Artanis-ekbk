<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class ShuttleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shuttles')-> insert(
            [

            'shuttle_type' => '3',
            'tahun' => '2021',
            'daerah_id'=> 1,
            'nama_kilang' => 'Kilang Papan Rimba Timor (J) Sdn. Bhd.',
            'alamat_kilang_1' => 'No. B-202-01, Jalan Laman Puteri 2,',
            'alamat_kilang_2' => 'Bandar Puteri, 47100, Puchong, Selangor, 47100 Puchong',
            'alamat_kilang_poskod' => '47100 ',
            'alamat_surat_menyurat_1' => 'No. B-202-01, Jalan Laman Puteri 2,',
            'alamat_surat_menyurat_2' => 'Bandar Puteri, 47100, Puchong, Selangor, 47100 Puchong',
            'alamat_surat_menyurat_poskod' => '47100',
            'longtitude_x' => '1.245',
            'langtitude_y' => '2.323',
            'no_telefon' => '010522345',
            'no_faks' => '56565',
            'no_ssm' => 'a-4351',
            'tarikh_tubuh' => now(),
            'tarikh_operasi' => now(),
            'taraf_syarikat_catatan' => 'ya',
            'nilai_harta' => '2434',
            'catatan_1' => 'ya',
            'catatan_2' => 'tidak',
            'status' => 1,
            'negeri_id' => rand(1,5),

            ]
        );

        DB::table('shuttles')-> insert(
            [

            'shuttle_type' => '3',
            'tahun' => '2021',
            'daerah_id' => 1,
            'nama_kilang' => 'Sawmill Welcome Sentosa Sdn Bhd',
            'alamat_kilang_1' => '6-1, Jalan SS 22/25, Damansara Jaya',
            'alamat_kilang_2' => '47400 Petaling Jaya, Selangor',
            'alamat_kilang_poskod' => '47400 ',
            'alamat_surat_menyurat_1' => '6-1, Jalan SS 22/25, Damansara Jaya',
            'alamat_surat_menyurat_2' => 'Kuala Lumpur',
            'alamat_surat_menyurat_poskod' => '41000',
            'longtitude_x' => '7.235',
            'langtitude_y' => '5.123',
            'no_telefon' => '016422485',
            'no_faks' => '56565',
            'no_ssm' => 'C-3442',
            'tarikh_tubuh' => now(),
            'tarikh_operasi' => now(),
            'taraf_syarikat_catatan' => 'ya',
            'nilai_harta' => '6464',
            'catatan_1' => 'ya',
            'catatan_2' => 'tidak',
            'status' => 1,
            'negeri_id' => rand(1,5),

            ]
        );

        DB::table('shuttles')-> insert(
            [

            'shuttle_type' => '4',
            'tahun' => '2021',
            'daerah_id' => 1,
            'nama_kilang' => 'KPS WOOD SDN. BHD.',
            'alamat_kilang_1' => 'TBG, 1306, Jalan Pasar',
            'alamat_kilang_2' => '1400 Klang, Selangor',
            'alamat_kilang_poskod' => '41400',
            'alamat_surat_menyurat_1' => 'TBG, 1306, Jalan Pasar',
            'alamat_surat_menyurat_2' => 'Kuala Lumpur',
            'alamat_surat_menyurat_poskod' => '41000',
            'longtitude_x' => '8.245',
            'langtitude_y' => '2.843',
            'no_telefon' => '0112522345',
            'no_faks' => '51625',
            'no_ssm' => 'a-4353',
            'tarikh_tubuh' => now(),
            'tarikh_operasi' => now(),
            'taraf_syarikat_catatan' => 'ya',
            'nilai_harta' => '6464',
            'catatan_1' => 'ya',
            'catatan_2' => 'tidak',
            'status' => 1,
            'negeri_id' => rand(1,5),

            ]
        );

        DB::table('shuttles')-> insert(
            [

            'shuttle_type' => '4',
            'tahun' => '2021',
            'daerah_id' => 1,
            'nama_kilang' => 'Far East Timber Industries Sdn Bhd',
            'alamat_kilang_1' => 'Jalan Welfare, Kampung Baru Sungai Buloh',
            'alamat_kilang_2' => '47000 Kampung Baru Sungai Buloh, Selangor',
            'alamat_kilang_poskod' => '47000 ',
            'alamat_surat_menyurat_1' => 'Jalan Welfare, Kampung Baru Sungai Buloh',
            'alamat_surat_menyurat_2' => 'Kuala Lumpur',
            'alamat_surat_menyurat_poskod' => '41000',
            'longtitude_x' => '1.245',
            'langtitude_y' => '2.323',
            'no_telefon' => '010522345',
            'no_faks' => '56565',
            'no_ssm' => 'a-4354',
            'tarikh_tubuh' => now(),
            'tarikh_operasi' => now(),
            'taraf_syarikat_catatan' => 'ya',
            'nilai_harta' => '6464',
            'catatan_1' => 'ya',
            'catatan_2' => 'tidak',
            'status' => 1,
            'negeri_id' => rand(1,5),

            ]
        );


        DB::table('shuttles')-> insert(
            [

            'shuttle_type' => '5',
            'tahun' => '2021',
            'daerah_id' => 1,
            'nama_kilang' => 'Timber Industries Sdn Bhd',
            'alamat_kilang_1' => 'Jalan Welfare, Kampung Baru Sungai Buloh',
            'alamat_kilang_2' => '47000 Kampung Baru Sungai Buloh, Selangor',
            'alamat_kilang_poskod' => '47000 ',
            'alamat_surat_menyurat_1' => 'Jalan Welfare, Kampung Baru Sungai Buloh',
            'alamat_surat_menyurat_2' => 'Kuala Lumpur',
            'alamat_surat_menyurat_poskod' => '41000',
            'longtitude_x' => '1.245',
            'langtitude_y' => '2.323',
            'no_telefon' => '010522345',
            'no_faks' => '56565',
            'no_ssm' => 'a-435',
            'tarikh_tubuh' => now(),
            'tarikh_operasi' => now(),
            'taraf_syarikat_catatan' => 'ya',
            'nilai_harta' => '6464',
            'catatan_1' => 'ya',
            'catatan_2' => 'tidak',
            'status' => 1,
            'negeri_id' => rand(1,5),

            ]
        );


        DB::table('shuttles')-> insert(
            [

            'shuttle_type' => '5',
            'tahun' => '2021',
            'daerah_id' => 1,
            'nama_kilang' => 'Kilang Kayu Queen Sdn Bhd',
            'alamat_kilang_1' => 'Jalan Welfare, Kampung Baru Sungai Buloh',
            'alamat_kilang_2' => '47000 Kampung Baru Sungai Buloh, Selangor',
            'alamat_kilang_poskod' => '47000 ',
            'alamat_surat_menyurat_1' => 'Jalan Welfare, Kampung Baru Sungai Buloh',
            'alamat_surat_menyurat_2' => 'Kuala Lumpur',
            'alamat_surat_menyurat_poskod' => '41000',
            'longtitude_x' => '1.245',
            'langtitude_y' => '2.323',
            'no_telefon' => '010522345',
            'no_faks' => '56565',
            'no_ssm' => 'a-4356',
            'tarikh_tubuh' => now(),
            'tarikh_operasi' => now(),
            'taraf_syarikat_catatan' => 'ya',
            'nilai_harta' => '6464',
            'catatan_1' => 'ya',
            'catatan_2' => 'tidak',
            'status' => 1,
            'negeri_id' => rand(1,5),

            ]
        );
    }
}
