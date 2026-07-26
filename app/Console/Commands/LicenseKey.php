<?php

namespace App\Console\Commands;

use App\Services\LicenseService;
use Illuminate\Console\Command;

class LicenseKey extends Command
{
    protected $signature = 'license:key';

    protected $description = 'Reprint the currently valid unlock key without re-locking (use if the key was lost).';

    public function handle(LicenseService $service)
    {
        if (!$service->isLocked()) {
            $this->info('The system is not currently locked — there is no key to print.');
            return self::SUCCESS;
        }

        if (!$service->hasSecret()) {
            $this->info('LICENSE_SECRET is not set, so no public key exists. Unlock via the control panel or `license:unlock --force` instead.');
            return self::SUCCESS;
        }

        $this->line("<fg=yellow;options=bold>{$service->currentKey()}</>");
        return self::SUCCESS;
    }
}
