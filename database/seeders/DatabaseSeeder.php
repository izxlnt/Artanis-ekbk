<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('Database\Seeders\UserSeeder');
        $this->call('Database\Seeders\HakMilikSyarikat');
        $this->call('Database\Seeders\Kewarganegaraan');
        $this->call('Database\Seeders\TarafSahSyarikat');
        $this->call('Database\Seeders\JenisKayuKumai');
        $this->call('Database\Seeders\JenisPembeliShuttle3');
        $this->call('Database\Seeders\JenisPembeliShuttle4');
        $this->call('Database\Seeders\KategoriPekerja');
        $this->call('Database\Seeders\KumpulanKayuKayan');
        $this->call('Database\Seeders\Spesies');
        $this->call('Database\Seeders\StatusOperasi');
        $this->call('Database\Seeders\BufferSeeder');
        $this->call('Database\Seeders\NegeriSeeder');
        // $this->call('Database\Seeders\ShuttleSeeder');
        $this->call('Database\Seeders\Daerah');
        $this->call('Database\Seeders\RecoveryRateSeeder');

    }
}
