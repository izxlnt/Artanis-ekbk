<?php

namespace Database\Seeders;

use App\Models\FormC;
use App\Models\Shuttle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Ensures all Form C records for months after the current month (in current
 * and future years) have status "Ditutup".
 *
 * Safe to run on any environment:
 *   - If future records already exist with "Tidak Diisi" → updates to "Ditutup"
 *   - If future records do not exist at all → creates them as "Ditutup"
 *   - If future records have actual filled data (Sedang Diisi, etc.) → skips and warns
 *
 * Current month records and past records are never touched.
 */
class RestoreFutureFormCDitutupSeeder extends Seeder
{
    public function run()
    {
        $currentYear  = (int)date('Y');
        $currentMonth = (int)date('n');

        $this->command->info("Current date: {$currentYear}-{$currentMonth}. Sealing months after {$currentMonth}/{$currentYear}.");

        // Build month→date mapping for current year's remaining months
        $monthDates = [];
        for ($m = 1; $m <= 12; $m++) {
            $nextM = $m == 12 ? 1 : $m + 1;
            $nextY = $m == 12 ? $currentYear + 1 : $currentYear;
            $monthDates[$m] = [
                'open'  => sprintf('%04d-%02d-01', $currentYear, $m),
                'close' => sprintf('%04d-%02d-01', $nextY, $nextM),
            ];
        }
        $monthDates[12]['close'] = sprintf('%04d-12-31', $currentYear);

        // All shuttles that have any Form C record for current year
        $shuttleIds = DB::table('form_c_s')
            ->where('tahun', $currentYear)
            ->distinct()
            ->pluck('shuttle_id');

        $this->command->info("Processing {$shuttleIds->count()} shuttles with {$currentYear} Form C records.");

        $updated  = 0;
        $created  = 0;
        $skipped  = 0;
        $warnings = 0;

        foreach ($shuttleIds as $shuttleId) {
            $shuttle = Shuttle::find($shuttleId);
            if (!$shuttle) continue;

            for ($bulan = $currentMonth + 1; $bulan <= 12; $bulan++) {
                $existing = DB::table('form_c_s')
                    ->where('shuttle_id', $shuttleId)
                    ->where('tahun', $currentYear)
                    ->where('bulan', $bulan)
                    ->first();

                if ($existing) {
                    if ($existing->status === 'Tidak Diisi' || $existing->status === 'Ditutup') {
                        DB::table('form_c_s')
                            ->where('id', $existing->id)
                            ->update(['status' => 'Ditutup', 'updated_at' => now()]);
                        $updated++;
                    } else {
                        // Has actual data — skip and warn
                        $this->command->warn(
                            "  [SKIP] shuttle_id={$shuttleId} bulan={$bulan}/{$currentYear}" .
                            " status={$existing->status} — has data, needs manual review"
                        );
                        $warnings++;
                    }
                } else {
                    DB::table('form_c_s')->insert([
                        'shuttle_id'          => $shuttleId,
                        'shuttle_type'        => $shuttle->shuttle_type,
                        'status'              => 'Ditutup',
                        'tahun'               => (string)$currentYear,
                        'bulan'               => (string)$bulan,
                        'tarikh_buka_borang'  => $monthDates[$bulan]['open'],
                        'tarikh_tutup_borang' => $monthDates[$bulan]['close'],
                        'nama_kilang'         => $shuttle->nama_kilang,
                        'no_ssm'              => $shuttle->no_ssm,
                        'no_lesen'            => $shuttle->no_lesen,
                        'created_at'          => $monthDates[$bulan]['open'],
                        'updated_at'          => now(),
                    ]);
                    $created++;
                }
            }
        }

        $this->command->newLine();
        $this->command->info('Done.');
        $this->command->info("  Updated to Ditutup  : {$updated}");
        $this->command->info("  Created as Ditutup  : {$created}");
        $this->command->info("  Skipped (has data)  : {$skipped}");
        if ($warnings > 0) {
            $this->command->warn("  Warnings (manual review needed): {$warnings}");
        }
    }
}
