<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormalizeDoubleSlashSeeder extends Seeder
{
    public function run()
    {
        $fixed   = 0;
        $skipped = 0;

        DB::table('users')
            ->where('login_id', 'like', '%/%/%')
            ->get(['id', 'login_id'])
            ->each(function ($user) use (&$fixed, &$skipped) {
                $parts      = explode('/', $user->login_id);
                $normalized = implode('/', array_slice($parts, 0, 2));

                $conflict = DB::table('users')
                    ->where('login_id', $normalized)
                    ->where('id', '!=', $user->id)
                    ->exists();

                if ($conflict) {
                    $this->command->warn("  SKIP  User ID {$user->id}: '{$user->login_id}' → '{$normalized}' already taken");
                    $skipped++;
                } else {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['login_id' => $normalized]);
                    $this->command->line("  FIXED User ID {$user->id}: '{$user->login_id}' → '{$normalized}'");
                    $fixed++;
                }
            });

        $this->command->info("Done. Fixed: {$fixed}, Skipped (conflict): {$skipped}");
    }
}
