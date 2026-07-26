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
        $key = $service->currentKey();

        if ($key === null) {
            $this->info('The system is not currently locked — there is no key to print.');
            return self::SUCCESS;
        }

        $this->line("<fg=yellow;options=bold>{$key}</>");
        return self::SUCCESS;
    }
}
