<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NormalizeAllSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('=== Normalize shuttle_type whitespace ===');
        $this->call(NormalizeShuttleTypeSeeder::class);

        $this->command->info('=== Normalize login_id slashes (max 1 slash) ===');
        $this->call(NormalizeDoubleSlashSeeder::class);

        $this->command->info('=== Normalize negeri_id and daerah_id (IDs → names) ===');
        $this->call(NormalizeNegeriDaerahSeeder::class);
    }
}
