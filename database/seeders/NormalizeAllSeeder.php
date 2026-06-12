<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NormalizeAllSeeder extends Seeder
{
    public function run()
    {
        // 1. Fix shuttle_type whitespace first — subsequent steps depend on a clean value
        $this->command->info('=== [1/4] Normalize shuttle_type whitespace ===');
        $this->call(NormalizeShuttleTypeSeeder::class);

        // 2. Append /shuttle_type to no_ssm (shuttles) and login_id (Kilang company users)
        $this->command->info('=== [2/4] Normalize no_ssm and login_id → SSM/shuttle_type format ===');
        $this->call(NormalizeSsmLoginIdSeeder::class);

        // 3. Collapse any remaining double-slash login_ids (e.g. SSM/3/3 → SSM/3)
        $this->command->info('=== [3/4] Normalize login_id double slashes ===');
        $this->call(NormalizeDoubleSlashSeeder::class);

        // 4. Resolve daerah_id → correct daerahs.id integer; negeri_id → full state name text
        $this->command->info('=== [4/4] Fix daerah_id (→ integer ID) and negeri_id (→ state name) ===');
        $this->call(FixShuttleDaerahNegeriIdSeeder::class);
    }
}
