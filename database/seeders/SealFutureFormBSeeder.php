<?php

namespace Database\Seeders;

use App\Models\Shuttle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seals all Form B records for quarters that have not yet arrived.
 *
 * Quarter Q is considered "due" when the current month >= Q * 3.
 *   Q1 (due Mar): currentMonth >= 3
 *   Q2 (due Jun): currentMonth >= 6
 *   Q3 (due Sep): currentMonth >= 9
 *   Q4 (due Dec): currentMonth >= 12
 *
 * Safe to run on ANY environment (dev or production).
 *
 * For each shuttle that has any Form B record for the current year:
 *   - Future quarters are SEALED:
 *       → guna_tenagas / ulasan_phds / ulasan_ipjpsms child rows deleted
 *       → formbs status set to "Ditutup"
 *   - If the record does not exist yet → created as "Ditutup"
 *   - Past and current quarters are NEVER touched.
 */
class SealFutureFormBSeeder extends Seeder
{
    public function run()
    {
        $currentYear  = (int)date('Y');
        $currentMonth = (int)date('n');

        // Quarter open/close dates
        $quarterDates = [
            1 => ['open' => sprintf('%04d-03-01', $currentYear), 'close' => sprintf('%04d-04-01', $currentYear)],
            2 => ['open' => sprintf('%04d-06-01', $currentYear), 'close' => sprintf('%04d-07-01', $currentYear)],
            3 => ['open' => sprintf('%04d-09-01', $currentYear), 'close' => sprintf('%04d-10-01', $currentYear)],
            4 => ['open' => sprintf('%04d-12-01', $currentYear), 'close' => sprintf('%04d-12-31', $currentYear)],
        ];

        // Identify which quarters are future (not yet due)
        $futureQuarters = [];
        for ($q = 1; $q <= 4; $q++) {
            if ($currentMonth < $q * 3) {
                $futureQuarters[] = $q;
            }
        }

        if (empty($futureQuarters)) {
            $this->command->info('All 4 quarters are due for ' . $currentYear . '. Nothing to seal.');
            return;
        }

        $this->command->info("Sealing Form B for quarters " . implode(', ', $futureQuarters) . " in year {$currentYear} (current month: {$currentMonth}).");
        $this->command->newLine();

        // Work on every shuttle that has at least one formbs row for current year
        $shuttleIds = DB::table('formbs')
            ->where('tahun', $currentYear)
            ->distinct()
            ->pluck('shuttle_id');

        $this->command->info("Shuttles to process: {$shuttleIds->count()}");

        $sealed  = 0;
        $created = 0;
        $gtDel   = 0;

        DB::transaction(function () use (
            $shuttleIds, $currentYear, $futureQuarters, $quarterDates,
            &$sealed, &$created, &$gtDel
        ) {
            foreach ($shuttleIds as $shuttleId) {
                foreach ($futureQuarters as $q) {
                    $row = DB::table('formbs')
                        ->where('shuttle_id', $shuttleId)
                        ->where('tahun', $currentYear)
                        ->where('suku_tahun', $q)
                        ->first();

                    if ($row) {
                        // Clear any data entered prematurely
                        $gtDel += DB::table('guna_tenagas')
                            ->where('formbs_id', $row->id)
                            ->delete();

                        DB::table('ulasan_phds')
                            ->where('formbs_id', $row->id)
                            ->delete();

                        DB::table('ulasan_ipjpsms')
                            ->where('formbs_id', $row->id)
                            ->delete();

                        DB::table('formbs')
                            ->where('id', $row->id)
                            ->update([
                                'status'     => 'Ditutup',
                                'updated_at' => now(),
                            ]);

                        $sealed++;
                    } else {
                        // Record was never created — create it as Ditutup
                        $shuttle = Shuttle::find($shuttleId);
                        if (!$shuttle) continue;

                        DB::table('formbs')->insert([
                            'shuttle_id'          => $shuttleId,
                            'shuttle_type'        => $shuttle->shuttle_type,
                            'status'              => 'Ditutup',
                            'tahun'               => (string)$currentYear,
                            'suku_tahun'          => $q,
                            'tarikh_buka_borang'  => $quarterDates[$q]['open'],
                            'tarikh_tutup_borang' => $quarterDates[$q]['close'],
                            'nama_kilang'         => $shuttle->nama_kilang,
                            'no_ssm'              => $shuttle->no_ssm,
                            'no_lesen'            => $shuttle->no_lesen,
                            'created_at'          => $quarterDates[$q]['open'],
                            'updated_at'          => now(),
                        ]);

                        $created++;
                    }
                }
            }
        });

        $this->command->newLine();
        $this->command->info('Done.');
        $this->command->info("  Existing records sealed (→ Ditutup)  : {$sealed}");
        $this->command->info("  New placeholder records created       : {$created}");
        $this->command->info("  guna_tenagas rows cleared             : {$gtDel}");
    }
}
