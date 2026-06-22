<?php

namespace Database\Seeders;

use App\Models\Shuttle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seals all Form C records for months that have not yet arrived.
 *
 * Safe to run on ANY environment (dev or production), with or without having
 * run previous fix seeders.
 *
 * For each shuttle that has any Form C record for the current year:
 *   - Months after the current month (future months) are SEALED:
 *       → kemasukan_bahans data is deleted (clears any premature input)
 *       → ulasan_phds / ulasan_ipjpsms are deleted
 *       → form_c_s status is set to "Ditutup"
 *   - If the record does not exist yet → created as "Ditutup"
 *   - Past months and the current month are NEVER touched.
 *
 * When a future month eventually arrives, FormCController auto-transitions
 * "Ditutup" → "Tidak Diisi" the first time a user opens that month's form.
 */
class SealFutureFormCSeeder extends Seeder
{
    public function run()
    {
        $currentYear  = (int)date('Y');
        $currentMonth = (int)date('n');

        $this->command->info("Sealing Form C for months > {$currentMonth} in year {$currentYear}.");
        $this->command->info('Past and current month records are untouched.');
        $this->command->newLine();

        // Month open/close date map for current year
        $monthDates = [];
        for ($m = 1; $m <= 12; $m++) {
            $nextM = $m == 12 ? 1  : $m + 1;
            $nextY = $m == 12 ? $currentYear + 1 : $currentYear;
            $closeDate = $m == 12
                ? sprintf('%04d-12-31', $currentYear)
                : sprintf('%04d-%02d-01', $nextY, $nextM);
            $monthDates[$m] = [
                'open'  => sprintf('%04d-%02d-01', $currentYear, $m),
                'close' => $closeDate,
            ];
        }

        // Work on every shuttle that has at least one form_c_s row for current year
        $shuttleIds = DB::table('form_c_s')
            ->where('tahun', $currentYear)
            ->distinct()
            ->pluck('shuttle_id');

        $this->command->info("Shuttles to process: {$shuttleIds->count()}");

        $sealed  = 0;   // existing records reset to Ditutup
        $created = 0;   // missing records created as Ditutup
        $kbDel   = 0;   // kemasukan_bahans rows deleted

        DB::transaction(function () use (
            $shuttleIds, $currentYear, $currentMonth, $monthDates,
            &$sealed, &$created, &$kbDel
        ) {
            foreach ($shuttleIds as $shuttleId) {
                for ($bulan = $currentMonth + 1; $bulan <= 12; $bulan++) {
                    $row = DB::table('form_c_s')
                        ->where('shuttle_id', $shuttleId)
                        ->where('tahun', $currentYear)
                        ->where('bulan', $bulan)
                        ->first();

                    if ($row) {
                        // Clear any data that was entered for this future month
                        $kbDel += DB::table('kemasukan_bahans')
                            ->where('formcs_id', $row->id)
                            ->delete();

                        DB::table('ulasan_phds')
                            ->where('formcs_id', $row->id)
                            ->delete();

                        DB::table('ulasan_ipjpsms')
                            ->where('formcs_id', $row->id)
                            ->delete();

                        DB::table('form_c_s')
                            ->where('id', $row->id)
                            ->update([
                                'status'            => 'Ditutup',
                                'tiada_pengeluaran' => '0',
                                'updated_at'        => now(),
                            ]);

                        $sealed++;
                    } else {
                        // Record was never created — create it as Ditutup
                        $shuttle = Shuttle::find($shuttleId);
                        if (!$shuttle) continue;

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
        });

        $this->command->newLine();
        $this->command->info('Done.');
        $this->command->info("  Existing records sealed (→ Ditutup)  : {$sealed}");
        $this->command->info("  New placeholder records created       : {$created}");
        $this->command->info("  kemasukan_bahans rows cleared         : {$kbDel}");
    }
}
