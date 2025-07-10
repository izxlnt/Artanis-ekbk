<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hashed_random_password = Hash::make("1234567890");

        DB::table('users')-> delete();
        DB::table('users')-> insert(
            [

            'name' => 'IPJPSM',
            'email' => 'ipjpsm@ekbk.com',
            'password' => $hashed_random_password,
            'login_id'=> '1',
            'kategori_pengguna' => 'BPE',
            'bahagian' => 'BPE',
            'is_approved_ipjpsm' => 1



            ]
        );

        // DB::table('users')-> insert(
        //     [

        //     'name' => 'User',
        //     'email' => 'user@ekbk.com',
        //     'password' => $hashed_random_password,
        //     'kategori_pengguna' => 'IBK',
        //     'login_id'=> '2',
        //     'is_approved' => 1


        //     ]
        // );

        DB::table('users')-> insert(
            [

            'name' => 'BPM',
            'email' => 'bpm@ekbk.com',
            'password' => $hashed_random_password,
            'kategori_pengguna' => 'BPM',
            'login_id'=> '10',
            'kategori_pengguna' => 'BPM',
            'is_approved_ipjpsm' => 1


            ]
        );

        DB::table('users')-> insert(
            [

            'name' => 'JPN',
            'email' => 'jpn@ekbk.com',
            'password' => $hashed_random_password,
            'login_id'=> '3',
            'kategori_pengguna' => 'JPN',
            'is_approved_ipjpsm' => 1,
            'negeri' => 'Johor',
            'daerah' => 'Johor Selatan'



            ]
        );


        DB::table('users')-> insert(
            [

            'name' => 'PHD',
            'email' => 'phd@ekbk.com',
            'password' => $hashed_random_password,
            'login_id'=> '4',
            'kategori_pengguna' => 'PHD',
            'is_approved_ipjpsm' => 1,
            'negeri' => 'Johor',
            'daerah' => 'Johor Selatan'



            ]
        );

        // DB::table('users')-> insert(
        //     [

        //     'name' => 'SEKH',
        //     'email' => 'sekh@ekbk.com',
        //     'password' => $hashed_random_password,
        //     'login_id'=> '5',
        //     'kategori_pengguna' => 'SEKH',
        //     'is_approved' => 1



        //     ]
        // );

        // DB::table('users')-> insert(
        //     [

        //     'name' => 'BPE',
        //     'email' => 'bpe@ekbk.com',
        //     'password' => $hashed_random_password,
        //     'login_id'=> '6',
        //     'kategori_pengguna' => 'BPE',
        //     'is_approved' => 1



        //     ]
        // );

        // \App\Models\Shuttle::factory(30)
        // ->create();

        // \App\Models\PenggunaKilang::factory(30)
        // ->create();


        // \App\Models\User::factory(10)
        // ->create();
    }
}
