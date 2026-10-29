<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Production testing: let only selected users into the system, then open it to everyone again.
 *
 *     php artisan testing:access on       only the users in the list can use the system
 *     php artisan testing:access status   show who is in the list and whether testing is on
 *     php artisan testing:access off      everyone can use the system again
 *
 * The list is storage/app/testing_access/ids.txt: one login_id per line, "#" starts a comment.
 * Edit it and run "on" again to change who is in; it can be run as often as needed.
 *
 * Nobody else's users.status is touched (the dashboard counts and the PHD/JPN limits read it),
 * so there is nothing to restore. The middleware shows everyone else the maintenance page.
 * A listed user who is Tidak Aktif is switched on, remembered, and switched back off by "off".
 */
class TestingAccess extends Command
{
    protected $signature = 'testing:access {action : on, off or status}';

    protected $description = 'Let only the users in storage/app/testing_access/ids.txt into the system (on), or everyone again (off).';

    private static $cached = false;
    private static $loginIds = null;

    public static function listFile()
    {
        return storage_path('app/testing_access/ids.txt');
    }

    public static function stateFile()
    {
        return storage_path('app/testing_access/active.json');
    }

    /** login_ids allowed in while testing is on, or null when testing is off. */
    public static function activeLoginIds()
    {
        if (!self::$cached) {
            self::$cached = true;
            $state = is_file(self::stateFile()) ? json_decode((string) file_get_contents(self::stateFile()), true) : null;
            self::$loginIds = is_array($state) && isset($state['login_ids']) ? array_map('strval', $state['login_ids']) : null;
        }

        return self::$loginIds;
    }

    public function handle()
    {
        $action = $this->argument('action');

        if ($action === 'on') {
            return $this->on();
        }
        if ($action === 'off') {
            return $this->off();
        }
        if ($action === 'status') {
            return $this->status();
        }

        $this->error('Use: php artisan testing:access on|off|status');
        return 1;
    }

    private function on()
    {
        $wanted = $this->readList();
        if ($wanted === null) {
            return 1;
        }

        $users = DB::table('users')->whereIn('login_id', array_keys($wanted))->whereNull('deleted_at')
            ->get(['id', 'login_id', 'name', 'kategori_pengguna', 'status'])->keyBy('login_id');

        $missing = array_diff(array_keys($wanted), $users->keys()->all());
        if ($missing) {
            $this->error('Not found in users, fix ids.txt and run again (nothing was changed):');
            foreach ($missing as $id) {
                $this->line("  {$id}  {$wanted[$id]}");
            }
            return 1;
        }

        $state = $this->readState();
        $activated = $state ? $state['activated'] : [];

        DB::transaction(function () use ($users, &$activated) {
            // Users switched on by an earlier run but no longer in the list go back to Tidak Aktif
            $listedIds = $users->pluck('id')->all();
            foreach (array_diff($activated, $listedIds) as $id) {
                DB::table('users')->where('id', $id)->update(['status' => '0', 'updated_at' => now()]);
                $this->line("Back to Tidak Aktif (no longer listed): user #{$id}");
            }
            $activated = array_values(array_intersect($activated, $listedIds));

            foreach ($users as $u) {
                if ((string) $u->status === '0') {
                    DB::table('users')->where('id', $u->id)->update(['status' => '1', 'updated_at' => now()]);
                    $activated[] = $u->id;
                    $this->line("Switched to Aktif for testing: #{$u->id} {$u->name}");
                }
            }
        });

        $this->writeState([
            'login_ids' => array_values($users->keys()->all()),
            'activated' => array_values(array_unique($activated)),
            'since'     => $state ? $state['since'] : now()->toDateTimeString(),
            'updated'   => now()->toDateTimeString(),
        ]);

        $this->info('Testing access ON: ' . count($users) . ' user(s) can use the system. Everyone else sees the maintenance page (BPE admins still get in).');
        $this->table(['login_id', 'User', 'Kategori', 'From list'], $users->map(function ($u) use ($wanted) {
            return [$u->login_id, "#{$u->id} {$u->name}", $u->kategori_pengguna, $wanted[$u->login_id]];
        })->values()->all());

        return 0;
    }

    private function off()
    {
        $state = $this->readState();
        if (!$state) {
            $this->info('Testing access is already OFF.');
            return 0;
        }

        if ($state['activated']) {
            $n = DB::table('users')->whereIn('id', $state['activated'])->update(['status' => '0', 'updated_at' => now()]);
            $this->line("Back to Tidak Aktif (were switched on only for testing): {$n} user(s)");
        }

        unlink(self::stateFile());
        $this->info('Testing access OFF: everyone can use the system again (unless maintenance mode is on).');

        return 0;
    }

    private function status()
    {
        $state = $this->readState();
        $this->line($state
            ? "Testing access is ON since {$state['since']} (last change {$state['updated']}): " . count($state['login_ids']) . ' user(s).'
            : 'Testing access is OFF.');

        $wanted = $this->readList();
        if ($wanted === null) {
            return 1;
        }

        $users = DB::table('users')->whereIn('login_id', array_keys($wanted))->whereNull('deleted_at')
            ->get(['id', 'login_id', 'name', 'kategori_pengguna', 'status'])->keyBy('login_id');

        $rows = [];
        foreach ($wanted as $id => $label) {
            $u = $users->get($id);
            $rows[] = [$id, $label, $u ? "#{$u->id} {$u->name}" : 'NOT FOUND', $u ? $u->kategori_pengguna : '', $u ? ((string) $u->status === '1' ? 'Aktif' : 'Tidak Aktif') : ''];
        }
        $this->table(['login_id', 'From list', 'User', 'Kategori', 'Status'], $rows);

        return 0;
    }

    /** login_id => label from ids.txt, or null when the file is missing or empty. */
    private function readList()
    {
        $file = self::listFile();
        if (!is_file($file)) {
            $this->error("List not found: {$file}");
            return null;
        }

        $wanted = [];
        foreach (preg_split('/\r\n|\r|\n/', (string) file_get_contents($file)) as $line) {
            $parts = explode('#', $line, 2);
            $id = trim($parts[0]);
            if ($id !== '') {
                $wanted[$id] = isset($parts[1]) ? trim($parts[1]) : '';
            }
        }

        if (!$wanted) {
            $this->error("The list is empty: {$file}");
            return null;
        }

        return $wanted;
    }

    private function readState()
    {
        $file = self::stateFile();
        $state = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;

        return is_array($state) ? $state + ['activated' => [], 'since' => '', 'updated' => ''] : null;
    }

    private function writeState(array $state)
    {
        file_put_contents(self::stateFile(), json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
