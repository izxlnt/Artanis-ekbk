<?php

namespace Database\Seeders;

use App\Models\FormB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fixes premature FormB Q4 (suku_tahun=4) records for year 2026.
 *
 * Root cause: when a factory is approved, all 4 quarters are auto-created
 * for the current year at once, including Q4 (December) even when it is
 * only mid-year. Additionally, some factories may have tried to submit
 * Q4 December 2025 data but it was saved under tahun=2026 instead.
 *
 * Rules applied:
 *   - tahun=2026, suku_tahun=4, status='Tidak Diisi'
 *       → DELETE  (premature placeholder, Q4 2026 is not open yet)
 *   - tahun=2026, suku_tahun=4, status != 'Tidak Diisi'
 *       → if no Q4 2025 exists for same shuttle: MOVE to tahun=2025
 *       → if Q4 2025 already exists for same shuttle: REPORT conflict (skip)
 */
class FixFormBYear2026Q4Seeder extends Seeder
{
    public function run()
    {
        $records = FormB::where('tahun', 2026)->where('suku_tahun', 4)->get();

        if ($records->isEmpty()) {
            $this->command->info('No FormB Q4 2026 records found. Nothing to fix.');
            return;
        }

        $this->command->info("Found {$records->count()} FormB record(s) with tahun=2026, suku_tahun=4.");

        $deleted   = 0;
        $moved     = 0;
        $conflicts = 0;

        foreach ($records as $record) {
            if ($record->status === 'Tidak Diisi') {
                $this->command->line("  [DELETE] id={$record->id} shuttle_id={$record->shuttle_id} status=Tidak Diisi");
                $record->delete();
                $deleted++;
            } else {
                $existing2025 = FormB::where('shuttle_id', $record->shuttle_id)
                    ->where('tahun', 2025)
                    ->where('suku_tahun', 4)
                    ->first();

                if ($existing2025) {
                    $this->command->warn(
                        "  [SKIP]   id={$record->id} shuttle_id={$record->shuttle_id} status={$record->status}" .
                        " — Q4 2025 already exists (id={$existing2025->id}). Manual review needed."
                    );
                    $conflicts++;
                } else {
                    $this->command->line(
                        "  [MOVE]   id={$record->id} shuttle_id={$record->shuttle_id}" .
                        " status={$record->status} → tahun 2026→2025, dates updated"
                    );
                    DB::table('formbs')->where('id', $record->id)->update([
                        'tahun'               => 2025,
                        'tarikh_buka_borang'  => '2025-12-01',
                        'tarikh_tutup_borang' => '2025-12-31',
                        'updated_at'          => now(),
                    ]);
                    $moved++;
                }
            }
        }

        $this->command->newLine();
        $this->command->info("Done.");
        $this->command->info("  Deleted (premature placeholders) : {$deleted}");
        $this->command->info("  Moved to 2025                    : {$moved}");
        $this->command->info("  Skipped (conflicts, manual review needed) : {$conflicts}");
    }
}
