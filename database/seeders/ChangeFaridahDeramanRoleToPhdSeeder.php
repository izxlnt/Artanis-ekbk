<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Converts Faridah Deraman (login_id 810720115450) from a JPN user
 * (negeri-scoped) to a PHD user (daerah-scoped), assigning her to
 * Terengganu Utara.
 */
class ChangeFaridahDeramanRoleToPhdSeeder extends Seeder
{
    private const LOGIN_ID = '810720115450';
    private const TARGET_DAERAH = 'Terengganu Utara';

    public function run()
    {
        $user = User::where('login_id', self::LOGIN_ID)->first();

        if (! $user) {
            $this->command->error('User not found: login_id ' . self::LOGIN_ID);
            return;
        }

        $this->command->line("Found user #{$user->id}: {$user->name}");
        $this->command->line("  Current kategori_pengguna : {$user->kategori_pengguna}");
        $this->command->line("  Current negeri            : {$user->negeri}");
        $this->command->line("  Current daerah             : " . ($user->daerah ?? 'NULL'));

        if ($user->kategori_pengguna === 'PHD' && $user->daerah === self::TARGET_DAERAH) {
            $this->command->info('Already PHD / ' . self::TARGET_DAERAH . ' - nothing to do.');
            return;
        }

        $user->kategori_pengguna = 'PHD';
        $user->daerah = self::TARGET_DAERAH;
        $user->save();

        $this->command->info("Updated user #{$user->id}:");
        $this->command->info("  kategori_pengguna : JPN → PHD");
        $this->command->info("  daerah            : NULL → " . self::TARGET_DAERAH);
        $this->command->info("  negeri unchanged  : {$user->negeri}");
    }
}
