<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillStaleSsmLesenOnForms extends Migration
{
    /**
     * form_c_s/form_d_s/form4_d_s/form4_e_s/form5_d_s/form5_e_s/formbs each keep
     * their own snapshot of no_ssm/no_lesen/nama_kilang, copied from the shuttle
     * at record-creation time. Since these are pre-created for many months/
     * quarters ahead of time, any later correction to the shuttle's own company
     * info never reached forms that were already pre-created but not yet
     * submitted. This is a one-time sync of those not-yet-submitted records to
     * their shuttle's current values - the same logic ShuttleObserver now
     * applies going forward on every shuttle profile update.
     *
     * Scoped to tahun >= 2026 only, per instruction - older years are left as-is.
     */
    private const FROM_YEAR = 2026;

    private const SUBMITTED = ['Sedang Diproses', 'Dihantar ke IPJPSM', 'Lulus', 'Tiada Pengeluaran'];

    private const TABLES_BY_TYPE = [
        3 => ['formbs', 'form_c_s', 'form_d_s'],
        4 => ['formbs', 'form_c_s', 'form4_d_s', 'form4_e_s'],
        5 => ['formbs', 'form_c_s', 'form5_d_s', 'form5_e_s'],
    ];

    public function up()
    {
        $shuttles = DB::table('shuttles')
            ->whereNotNull('no_ssm')
            ->get(['id', 'shuttle_type', 'no_ssm', 'no_lesen', 'nama_kilang']);

        $totalUpdated = 0;

        foreach ($shuttles as $shuttle) {
            $tables = self::TABLES_BY_TYPE[(int) $shuttle->shuttle_type] ?? self::TABLES_BY_TYPE[3];

            $sync = [
                'no_ssm' => $shuttle->no_ssm,
                'no_lesen' => $shuttle->no_lesen,
                'nama_kilang' => $shuttle->nama_kilang,
                'updated_at' => now(),
            ];

            foreach ($tables as $table) {
                $totalUpdated += DB::table($table)
                    ->where('shuttle_id', $shuttle->id)
                    ->where('tahun', '>=', self::FROM_YEAR)
                    ->whereNotIn('status', self::SUBMITTED)
                    ->where(function ($q) use ($shuttle) {
                        $q->where('no_ssm', '!=', $shuttle->no_ssm)
                            ->orWhereNull('no_ssm')
                            ->orWhere('no_lesen', '!=', $shuttle->no_lesen)
                            ->orWhereNull('no_lesen')
                            ->orWhere('nama_kilang', '!=', $shuttle->nama_kilang)
                            ->orWhereNull('nama_kilang');
                    })
                    ->update($sync);
            }
        }

        echo PHP_EOL;
        echo 'Backfill stale SSM/Lesen/nama kilang selesai:' . PHP_EOL;
        echo '  Rekod (belum dihantar) dikemaskini: ' . $totalUpdated . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        // Data correction - the stale values being replaced were wrong; not restored.
    }
}
