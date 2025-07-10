<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class BufferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buffers')-> insert(
            [

            'shuttle' => '3',
            'borang' => 'B',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '3',
            'borang' => 'C',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '3',
            'borang' => 'D',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '4',
            'borang' => 'B',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '4',
            'borang' => 'C',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '4',
            'borang' => 'D',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '4',
            'borang' => 'E',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '5',
            'borang' => 'B',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '5',
            'borang' => 'C',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '5',
            'borang' => 'D',
            'delay' => 1,

            ]
        );

        DB::table('buffers')-> insert(
            [

            'shuttle' => '5',
            'borang' => 'E',
            'delay' => 1,

            ]
        );
    }
}
