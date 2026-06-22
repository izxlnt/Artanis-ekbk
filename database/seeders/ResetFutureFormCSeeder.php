<?php

namespace Database\Seeders;

use App\Models\FormC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Removes Form C data submitted for months beyond June 2026.
 *
 * Root cause: users were able to fill in monthly data for months that have
 * not yet arrived (e.g., July–December 2026 while still in June 2026).
 *
 * Rules applied (per shuttle, any shuttle type):
 *   - tahun=2026, bulan > 6  → DELETE kemasukan_bahans, then DELETE form_c_s
 *   - tahun > 2026            → DELETE kemasukan_bahans, then DELETE form_c_s
 *
 * Data for June 2026 and all prior months is left untouched.
 */
class ResetFutureFormCSeeder extends Seeder
{
    public function run()
    {
        $futureFormCs = FormC::where(function ($q) {
                $q->where('tahun', '2026')
                  ->whereRaw('CAST(bulan AS UNSIGNED) > 6');
            })
            ->orWhere('tahun', '>', '2026')
            ->get();

        if ($futureFormCs->isEmpty()) {
            $this->command->info('No future Form C records found (after June 2026). Nothing to do.');
            return;
        }

        $this->command->info("Found {$futureFormCs->count()} Form C record(s) with month > June 2026.");

        $deletedKB  = 0;
        $deletedFC  = 0;

        $futureIds = $futureFormCs->pluck('id');

        DB::transaction(function () use ($futureFormCs, $futureIds, &$deletedKB, &$deletedFC) {
            // Delete all child rows first to satisfy foreign key constraints.
            DB::table('ulasan_ipjpsms')->whereIn('formcs_id', $futureIds)->delete();
            DB::table('ulasan_phds')->whereIn('formcs_id', $futureIds)->delete();
            $deletedKB = DB::table('kemasukan_bahans')->whereIn('formcs_id', $futureIds)->delete();

            foreach ($futureFormCs as $formC) {
                $this->command->line(
                    "  [DELETE] form_c id={$formC->id}" .
                    " shuttle_id={$formC->shuttle_id}" .
                    " type={$formC->shuttle_type}" .
                    " bulan={$formC->bulan} tahun={$formC->tahun}" .
                    " status={$formC->status}"
                );
                $formC->delete();
                $deletedFC++;
            }
        });

        $this->command->newLine();
        $this->command->info('Done.');
        $this->command->info("  Form C records deleted       : {$deletedFC}");
        $this->command->info("  Kemasukan Bahan rows deleted : {$deletedKB}");
        $this->command->info('  Data for June 2026 and earlier is untouched.');
    }
}
