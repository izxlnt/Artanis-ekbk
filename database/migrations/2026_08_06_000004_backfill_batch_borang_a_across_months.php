<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillBatchBorangAAcrossMonths extends Migration
{
    /**
     * `batches` is keyed per (shuttle_id, tahun, bulan) - one row per month - but
     * Form A is an annual form with no month dimension. The code that flips
     * batch.borang_a (submitted=1, confirmed=2, sent-back=0) only ever updated
     * one arbitrary month's row instead of every month's row for that shuttle
     * and year, so PHD's "Hantar Pakej" completeness check wrongly reported
     * Borang A as unconfirmed for every month except the one lucky row.
     *
     * This backfills borang_a onto every batch row for a shuttle+year to match
     * that year's actual FormA status, scoped to tahun >= 2026 only.
     */
    private const FROM_YEAR = 2026;

    public function up()
    {
        $formAs = DB::table('form_a_s')
            ->where('tahun', '>=', self::FROM_YEAR)
            ->get(['shuttle_id', 'tahun', 'status']);

        $statusToBorangA = [
            'Dihantar ke IPJPSM' => '2',
            'Lulus' => '2',
            'Sedang Diproses' => '1',
            'Tidak Lengkap' => '0',
        ];

        $totalUpdated = 0;

        foreach ($formAs as $formA) {
            $target = $statusToBorangA[$formA->status] ?? null;
            if ($target === null) {
                continue; // 'Tidak Diisi' or similar - nothing confirmed yet, leave as-is
            }

            $totalUpdated += DB::table('batches')
                ->where('shuttle_id', $formA->shuttle_id)
                ->where('tahun', $formA->tahun)
                ->where('borang_a', '!=', $target)
                ->update(['borang_a' => $target, 'updated_at' => now()]);
        }

        echo PHP_EOL;
        echo 'Backfill batch borang_a selesai:' . PHP_EOL;
        echo '  Rekod batch dikemaskini: ' . $totalUpdated . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        // Data correction - the per-month inconsistency being replaced was wrong; not restored.
    }
}
