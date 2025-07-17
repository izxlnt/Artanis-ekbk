<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\EmailValidationService;

class CheckDuplicateEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:check-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for duplicate emails across all tables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking for duplicate emails across all tables...');
        
        $tables = [
            'users' => 'email',
            'pengguna_kilangs' => 'email',
            'shuttles' => 'email',
            'password_resets' => 'email'
        ];

        $allEmails = [];
        $duplicates = [];
        $sameRegistrationDuplicates = [];

        // Collect all emails from all tables
        foreach ($tables as $table => $column) {
            $emails = DB::table($table)
                ->select($column . ' as email', 'id')
                ->whereNotNull($column)
                ->where($column, '!=', '')
                ->get();

            foreach ($emails as $record) {
                $email = strtolower(trim($record->email));
                if (!isset($allEmails[$email])) {
                    $allEmails[$email] = [];
                }
                $allEmails[$email][] = [
                    'table' => $table,
                    'id' => $record->id,
                    'email' => $record->email
                ];
            }
        }

        // Check for same email used in both user and factory email in shuttles table
        $shuttleRecords = DB::table('shuttles')
            ->select('id', 'email')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        foreach ($shuttleRecords as $shuttle) {
            // Check if there's a pengguna_kilang with the same email linked to this shuttle
            $penggunaKilang = DB::table('pengguna_kilangs')
                ->select('id', 'email')
                ->where('shuttle_id', $shuttle->id)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->first();

            if ($penggunaKilang && strtolower(trim($penggunaKilang->email)) === strtolower(trim($shuttle->email))) {
                $sameRegistrationDuplicates[] = [
                    'shuttle_id' => $shuttle->id,
                    'shuttle_email' => $shuttle->email,
                    'pengguna_kilang_id' => $penggunaKilang->id,
                    'pengguna_kilang_email' => $penggunaKilang->email
                ];
            }
        }

        // Find duplicates across tables
        foreach ($allEmails as $email => $records) {
            if (count($records) > 1) {
                $duplicates[$email] = $records;
            }
        }

        $hasIssues = false;

        // Report same registration duplicates
        if (!empty($sameRegistrationDuplicates)) {
            $hasIssues = true;
            $this->error('❌ Found ' . count($sameRegistrationDuplicates) . ' registration(s) using same email for both user and factory:');
            $this->line('');

            foreach ($sameRegistrationDuplicates as $duplicate) {
                $this->warn("Same email used in single registration:");
                $this->line("  - Shuttle ID: {$duplicate['shuttle_id']}, Factory Email: {$duplicate['shuttle_email']}");
                $this->line("  - Pengguna Kilang ID: {$duplicate['pengguna_kilang_id']}, User Email: {$duplicate['pengguna_kilang_email']}");
                $this->line('');
            }
        }

        // Report cross-table duplicates
        if (!empty($duplicates)) {
            $hasIssues = true;
            $this->error('❌ Found ' . count($duplicates) . ' duplicate email(s) across tables:');
            $this->line('');

            foreach ($duplicates as $email => $records) {
                $this->warn("Email: {$email}");
                foreach ($records as $record) {
                    $this->line("  - Table: {$record['table']}, ID: {$record['id']}");
                }
                $this->line('');
            }
        }

        if (!$hasIssues) {
            $this->info('✅ No duplicate emails found!');
            return 0;
        }

        $this->info('Please resolve these duplicates before implementing the new validation system.');
        
        return 1;
    }
}
