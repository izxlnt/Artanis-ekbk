<?php

namespace App\Console\Commands;

use App\Services\LicenseService;
use Illuminate\Console\Command;

class LicenseLock extends Command
{
    protected $signature = 'license:lock
        {--reason= : Internal note, e.g. "payment overdue" — not shown to users}
        {--message= : Custom message shown on the locked-out page instead of the default}';

    protected $description = 'Lock the entire system. Nobody (including client admins) can use it until the printed key is entered.';

    public function handle(LicenseService $service)
    {
        if ($service->isLocked()) {
            if (!$this->confirm('The system is already locked. Re-lock with a fresh key (this invalidates the current key)?')) {
                return self::SUCCESS;
            }
        }

        $key = $service->lock($this->option('reason'), $this->option('message'));

        $this->newLine();
        $this->line('<bg=red;fg=white> SYSTEM LOCKED </>');
        $this->newLine();

        if ($key !== null) {
            $this->line('Unlock key (give this to whoever should regain access):');
            $this->line("  <fg=yellow;options=bold>{$key}</>");
            $this->newLine();
            $this->line('If you lose this key, run <fg=cyan>php artisan license:key</> to reprint it — it stays valid until the next license:lock.');
        } else {
            $this->line('LICENSE_SECRET is not set, so no public unlock key was generated.');
            $this->line('Unlock it yourself via the control panel link, or via <fg=cyan>php artisan license:unlock</> after setting LICENSE_SECRET.');
        }

        return self::SUCCESS;
    }
}
