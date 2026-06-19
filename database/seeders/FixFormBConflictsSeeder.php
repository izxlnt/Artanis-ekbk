<?php

namespace Database\Seeders;

use App\Models\FormB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fixes remaining FormB records where tahun=2026, suku_tahun=4 has real submitted data
 * after FixFormBYear2026Q4Seeder already removed the empty "Tidak Diisi" ones.
 *
 * Must be run AFTER FixFormBYear2026Q4Seeder.
 *
 * Two cases per conflict record:
 *
 * Case A — Q4 2025 is "Tidak Diisi" for the same shuttle:
 *   The data was meant for Q4 2025 (Oct-Dec 2025) but landed in Q4 2026.
 *   Action: delete Q4 2025 placeholder → move this record to tahun=2025, dates 2025-12-01..2025-12-31
 *
 * Case B — Q4 2025 is already filled for the same shuttle:
 *   This is a duplicate submission; the correct Q4 2025 record already exists.
 *   Action: cascade-delete guna_tenagas + ulasan_phds + this formbs record.
 *   A fresh Q2 2026 placeholder is recreated so the factory still has a slot to fill.
 */
class FixFormBConflictsSeeder extends Seeder
{
    public function run()
    {
        $records = FormB::where('tahun', 2026)
            ->where('suku_tahun', 4)
            ->where('status', '!=', 'Tidak Diisi')
            ->get();

        if ($records->isEmpty()) {
            $this->command->info('No conflict FormB Q4 2026 records found. Nothing to fix.');
            return;
        }

        $this->command->info("Found {$records->count()} conflict record(s) (tahun=2026, suku_tahun=4, status != Tidak Diisi).");
        $this->command->newLine();

        $movedToQ4_2025 = 0;
        $deleted        = 0;
        $skipped        = 0;

        foreach ($records as $record) {
            $q4_2025 = FormB::where('shuttle_id', $record->shuttle_id)
                ->where('tahun', 2025)
                ->where('suku_tahun', 4)
                ->first();

            if ($q4_2025 && $q4_2025->status === 'Tidak Diisi') {
                // Case A: Q4 2025 placeholder exists — this record belongs there
                $this->command->line(
                    "  [CASE A → Q4 2025] id={$record->id} shuttle_id={$record->shuttle_id}" .
                    " status={$record->status} | deleting placeholder id={$q4_2025->id}, moving to tahun=2025 suku=4"
                );

                DB::transaction(function () use ($record, $q4_2025) {
                    $q4_2025->forceDelete();

                    DB::table('formbs')->where('id', $record->id)->update([
                        'tahun'               => 2025,
                        'tarikh_buka_borang'  => '2025-12-01',
                        'tarikh_tutup_borang' => '2025-12-31',
                        'updated_at'          => now(),
                    ]);
                });

                $movedToQ4_2025++;

            } elseif (!$q4_2025 || $q4_2025->status !== 'Tidak Diisi') {
                // Case B: Q4 2025 is already properly filled — this is a duplicate, delete it
                $q2_2026 = FormB::where('shuttle_id', $record->shuttle_id)
                    ->where('tahun', 2026)
                    ->where('suku_tahun', 2)
                    ->first();

                if ($q2_2026 && $q2_2026->status !== 'Tidak Diisi') {
                    $this->command->warn(
                        "  [SKIP] id={$record->id} shuttle_id={$record->shuttle_id}" .
                        " — Q4 2025 is filled AND Q2 2026 has real data (id={$q2_2026->id}). Manual review needed."
                    );
                    $skipped++;
                    continue;
                }

                $gt = DB::table('guna_tenagas')->where('formbs_id', $record->id)->count();
                $up = DB::table('ulasan_phds')->where('formbs_id', $record->id)->count();

                $this->command->line(
                    "  [CASE B → DELETE] id={$record->id} shuttle_id={$record->shuttle_id}" .
                    " status={$record->status} | duplicate of Q4 2025 (id=" . ($q4_2025 ? $q4_2025->id : 'none') . ")" .
                    " | deleting {$gt} guna_tenagas, {$up} ulasan_phds, formbs record"
                );

                DB::transaction(function () use ($record, $q2_2026) {
                    DB::table('guna_tenagas')->where('formbs_id', $record->id)->delete();
                    DB::table('ulasan_phds')->where('formbs_id', $record->id)->delete();
                    $record->forceDelete();

                    // Recreate Q2 2026 placeholder if it was wiped
                    if (!$q2_2026) {
                        DB::table('formbs')->insert([
                            'shuttle_id'          => $record->shuttle_id,
                            'tahun'               => 2026,
                            'suku_tahun'          => 2,
                            'status'              => 'Tidak Diisi',
                            'tarikh_buka_borang'  => '2026-06-01',
                            'tarikh_tutup_borang' => '2026-07-01',
                            'created_at'          => now(),
                            'updated_at'          => now(),
                        ]);
                    }
                });

                $deleted++;
            }
        }

        $this->command->newLine();
        $this->command->info('Done.');
        $this->command->info("  Moved to Q4 2025                            : {$movedToQ4_2025}");
        $this->command->info("  Deleted (duplicate of existing Q4 2025)     : {$deleted}");
        $this->command->info("  Skipped (needs manual review)               : {$skipped}");
    }
}
