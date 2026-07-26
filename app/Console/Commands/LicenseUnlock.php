<?php

namespace App\Console\Commands;

use App\Services\LicenseService;
use Illuminate\Console\Command;

class LicenseUnlock extends Command
{
    protected $signature = 'license:unlock {key : The unlock key printed by license:lock or license:key}';

    protected $description = 'Unlock the system from the command line (equivalent to submitting the key on the locked-out page).';

    public function handle(LicenseService $service)
    {
        if (!$service->isLocked()) {
            $this->info('The system is not currently locked.');
            return self::SUCCESS;
        }

        if ($service->unlock($this->argument('key'))) {
            $this->info('System unlocked.');
            return self::SUCCESS;
        }

        $this->error('That key is not valid for the current lock.');
        return self::FAILURE;
    }
}
