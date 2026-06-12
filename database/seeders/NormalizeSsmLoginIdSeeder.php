<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormalizeSsmLoginIdSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('--- shuttles.no_ssm ---');
        $this->normalizeShuttlesNoSsm();

        $this->command->info('--- users.login_id (Kilang company accounts) ---');
        $this->normalizeKilangLoginId();
    }

    private function normalizeShuttlesNoSsm()
    {
        $fixed   = 0;
        $skipped = 0;

        DB::table('shuttles')
            ->whereNotNull('no_ssm')
            ->whereNotNull('shuttle_type')
            ->get(['id', 'no_ssm', 'shuttle_type'])
            ->each(function ($shuttle) use (&$fixed, &$skipped) {
                $cleanSsm   = preg_replace('/[\/\\\\].*$/', '', $shuttle->no_ssm);
                $normalized = $cleanSsm . '/' . $shuttle->shuttle_type;

                if ($shuttle->no_ssm === $normalized) {
                    return;
                }

                $conflict = DB::table('shuttles')
                    ->where('no_ssm', $normalized)
                    ->where('id', '!=', $shuttle->id)
                    ->exists();

                if ($conflict) {
                    $this->command->warn("  SKIP  Shuttle ID {$shuttle->id}: '{$shuttle->no_ssm}' → '{$normalized}' already taken");
                    $skipped++;
                } else {
                    DB::table('shuttles')->where('id', $shuttle->id)->update(['no_ssm' => $normalized]);
                    $this->command->line("  FIXED Shuttle ID {$shuttle->id}: '{$shuttle->no_ssm}' → '{$normalized}'");
                    $fixed++;
                }
            });

        $this->command->info("Done. Fixed: {$fixed}, Skipped (conflict): {$skipped}");
    }

    private function normalizeKilangLoginId()
    {
        $fixed   = 0;
        $skipped = 0;

        // Kilang company accounts: linked to a shuttle but not to an individual pengguna_kilang
        DB::table('users')
            ->whereNotNull('shuttle_id')
            ->whereNull('pengguna_kilang_id')
            ->whereNotNull('login_id')
            ->get(['id', 'login_id', 'shuttle_id', 'shuttle_type'])
            ->each(function ($user) use (&$fixed, &$skipped) {
                $shuttleType = $user->shuttle_type
                    ?: DB::table('shuttles')->where('id', $user->shuttle_id)->value('shuttle_type');

                if (!$shuttleType) {
                    $this->command->warn("  SKIP  User ID {$user->id}: cannot determine shuttle_type");
                    $skipped++;
                    return;
                }

                $cleanId    = preg_replace('/[\/\\\\].*$/', '', $user->login_id);
                $normalized = $cleanId . '/' . $shuttleType;

                if ($user->login_id === $normalized) {
                    return;
                }

                $conflict = DB::table('users')
                    ->where('login_id', $normalized)
                    ->where('id', '!=', $user->id)
                    ->exists();

                if ($conflict) {
                    $this->command->warn("  SKIP  User ID {$user->id}: '{$user->login_id}' → '{$normalized}' already taken");
                    $skipped++;
                } else {
                    DB::table('users')->where('id', $user->id)->update(['login_id' => $normalized]);
                    $this->command->line("  FIXED User ID {$user->id}: '{$user->login_id}' → '{$normalized}'");
                    $fixed++;
                }
            });

        $this->command->info("Done. Fixed: {$fixed}, Skipped (conflict): {$skipped}");
    }
}
