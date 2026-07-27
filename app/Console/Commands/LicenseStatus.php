<?php

namespace App\Console\Commands;

use App\Services\LicenseService;
use Illuminate\Console\Command;

class LicenseStatus extends Command
{
    protected $signature = 'license:status';

    protected $description = 'Show whether the system is currently locked, and by which mechanism.';

    public function handle(LicenseService $service)
    {
        if ($service->isCodeLocked()) {
            $this->line('<bg=red;fg=white> LOCKED (via code) </>');
            $this->line('app/license-lock.php has locked=true. Edit it back to false and deploy to unlock.');
            $message = $service->codeLockMessage();
            if ($message) {
                $this->line('Message shown to users: ' . $message);
            }
            return self::SUCCESS;
        }

        $license = $service->current();

        if (!$license->is_locked) {
            $this->info('Unlocked — the system is accessible normally.');
            if ($license->unlocked_at) {
                $this->line('Last unlocked: ' . $license->unlocked_at->format('Y-m-d H:i:s'));
            }
            return self::SUCCESS;
        }

        $this->line('<bg=red;fg=white> LOCKED (via panel/CLI) </>');
        $this->line('Locked since: ' . ($license->locked_at ? $license->locked_at->format('Y-m-d H:i:s') : 'unknown'));
        if ($license->locked_reason) {
            $this->line('Reason (internal): ' . $license->locked_reason);
        }
        $this->line('Run <fg=cyan>php artisan license:key</> to see the valid unlock key, or use the control panel.');

        return self::SUCCESS;
    }
}
