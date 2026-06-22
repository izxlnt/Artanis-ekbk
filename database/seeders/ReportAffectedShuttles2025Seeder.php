<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Reports shuttles whose Nov/Dec 2025 Form C is still "Tidak Diisi".
 *
 * These are the shuttles that may have had their 2025 data accidentally stored
 * as 2026 (due to the controller defaulting year to current year). That 2026
 * data was removed by ResetFutureFormCSeeder. Shuttles listed here may need to
 * re-enter their Nov/Dec 2025 submissions.
 *
 * Read-only — makes no changes.
 */
class ReportAffectedShuttles2025Seeder extends Seeder
{
    public function run()
    {
        foreach (['11' => 'November', '12' => 'Disember'] as $bulan => $label) {
            $rows = DB::table('form_c_s as fc')
                ->join('shuttles as s', 's.id', '=', 'fc.shuttle_id')
                ->where('fc.tahun', '2025')
                ->where('fc.bulan', $bulan)
                ->where('fc.status', 'Tidak Diisi')
                ->select('fc.id as fc_id', 'fc.shuttle_id', 'fc.shuttle_type', 's.nama_kilang', 's.no_ssm')
                ->orderBy('fc.shuttle_type')
                ->orderBy('s.nama_kilang')
                ->get();

            $this->command->newLine();
            $this->command->warn("=== {$label} 2025 — Tidak Diisi ({$rows->count()} shuttles) ===");

            foreach ($rows as $r) {
                $this->command->line(
                    "  shuttle_id={$r->shuttle_id}" .
                    " type={$r->shuttle_type}" .
                    " fc_id={$r->fc_id}" .
                    " kilang=\"{$r->nama_kilang}\"" .
                    " SSM={$r->no_ssm}"
                );
            }
        }

        $this->command->newLine();
        $this->command->info('These shuttle operators should be contacted to re-submit their Nov/Dec 2025 Form C data.');
        $this->command->info('Their data may have been stored under tahun=2026 and was removed by ResetFutureFormCSeeder.');
    }
}
