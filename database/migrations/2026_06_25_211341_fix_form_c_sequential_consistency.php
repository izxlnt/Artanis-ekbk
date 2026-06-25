<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixFormCSequentialConsistency extends Migration
{
    private static $SUBMITTED = ['Sedang Diproses', 'Dihantar ke IPJPSM', 'Lulus', 'Tiada Pengeluaran'];

    public function up()
    {
        // Preload shuttle types so we know which FormD/E table to target
        $shuttleTypes = DB::table('shuttles')->pluck('shuttle_type', 'id');

        // ── Pass 1: Reset FormC that are submitted but have NO real data ──────
        // "Real data" = has kemasukan_bahans rows OR tiada_pengeluaran = 1
        $submittedC = DB::table('form_c_s')
            ->whereIn('status', self::$SUBMITTED)
            ->get(['id', 'shuttle_id', 'tahun', 'bulan', 'tiada_pengeluaran']);

        $kemCounts = DB::table('kemasukan_bahans')
            ->whereIn('formcs_id', $submittedC->pluck('id')->toArray())
            ->select('formcs_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('formcs_id')
            ->pluck('cnt', 'formcs_id');

        $pass1 = 0;
        foreach ($submittedC as $fc) {
            $hasData = ($kemCounts[$fc->id] ?? 0) > 0 || (bool) $fc->tiada_pengeluaran;
            if (!$hasData) {
                $type = (int) ($shuttleTypes[$fc->shuttle_id] ?? 3);
                $this->resetMonth($fc->shuttle_id, $fc->tahun, $fc->bulan, $type);
                $pass1++;
            }
        }

        // ── Pass 2: Sequential cascade ────────────────────────────────────────
        // After Pass 1, walk every shuttle+year month by month.
        // If month M is not truly submitted, any subsequent month that IS submitted
        // must also be reset (along with its FormD/E).
        $allC = DB::table('form_c_s')
            ->orderBy('shuttle_id')->orderBy('tahun')->orderBy('bulan')
            ->get(['id', 'shuttle_id', 'tahun', 'bulan', 'status', 'tiada_pengeluaran'])
            ->groupBy(function ($r) {
                return $r->shuttle_id . '-' . $r->tahun;
            });

        // Reload kemasukan counts after Pass 1 changes
        $kemCountsAll = DB::table('kemasukan_bahans')
            ->select('formcs_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('formcs_id')
            ->pluck('cnt', 'formcs_id');

        $pass2       = 0;
        $pass2Skipped = 0;

        foreach ($allC as $records) {
            $first     = $records->first();
            $shuttleId = $first->shuttle_id;
            $tahun     = $first->tahun;
            $type      = (int) ($shuttleTypes[$shuttleId] ?? 3);

            // Build mutable map: bulan => true/false (truly submitted)
            $trulySubmitted = [];
            $hasDataMap     = []; // bulan => bool
            foreach ($records as $r) {
                $isSubmitted               = in_array($r->status, self::$SUBMITTED);
                $hasData                   = ($kemCountsAll[$r->id] ?? 0) > 0 || (bool) $r->tiada_pengeluaran;
                $trulySubmitted[$r->bulan] = $isSubmitted && $hasData;
                $hasDataMap[$r->bulan]     = $hasData;
            }

            for ($m = 2; $m <= 12; $m++) {
                if (empty($trulySubmitted[$m])) continue; // already not submitted

                $prevOk = $trulySubmitted[$m - 1] ?? false;
                if ($prevOk) continue; // chain is fine

                // Previous month is not truly submitted — check if THIS month has real data.
                // If it has real kemasukan, do NOT auto-reset: the user filled it and the
                // window may already be closed. Flag it instead and let admin review manually.
                if (!empty($hasDataMap[$m])) {
                    $pass2Skipped++;
                    // Do not mark as false — stop cascade here (subsequent months may be valid)
                    continue;
                }

                // No real data in this month either — safe to reset
                $this->resetMonth($shuttleId, $tahun, $m, $type);
                $trulySubmitted[$m] = false; // cascade continues to next month
                $pass2++;
            }
        }

        echo PHP_EOL;
        echo 'FormC sequential fix selesai:' . PHP_EOL;
        echo '  Pass 1 — tiada data kemasukan  : ' . $pass1 . ' rekod reset' . PHP_EOL;
        echo '  Pass 2 — cascade sequential    : ' . $pass2 . ' rekod reset' . PHP_EOL;
        echo '  Pass 2 — ada data, skip (admin): ' . $pass2Skipped . ' rekod' . PHP_EOL;
        echo '  Jumlah reset                   : ' . ($pass1 + $pass2) . ' rekod' . PHP_EOL;
        if ($pass2Skipped > 0) {
            echo PHP_EOL;
            echo '  PERHATIAN: ' . $pass2Skipped . ' rekod FormC ada kemasukan data tetapi bulan' . PHP_EOL;
            echo '  sebelumnya tidak diisi. Semak manual — carry-forward mungkin tidak tepat.' . PHP_EOL;
        }
        echo PHP_EOL;
    }

    /**
     * Reset FormC status + corresponding FormD and FormE for the given month.
     * All statuses are reset to 'Tidak Diisi' regardless of current status.
     */
    private function resetMonth(int $shuttleId, int $tahun, int $bulan, int $shuttleType): void
    {
        // Extend tarikh_tutup_borang to keep the window open for re-entry after reset.
        DB::table('form_c_s')
            ->where('shuttle_id', $shuttleId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', self::$SUBMITTED)
            ->update([
                'status'             => 'Tidak Diisi',
                'tarikh_buka_borang' => DB::raw('IFNULL(tarikh_buka_borang, CURDATE())'),
                'tarikh_tutup_borang'=> '2099-12-31',
                'updated_at'         => now(),
            ]);

        $dTable = ($shuttleType === 4) ? 'form4_d_s'
                : (($shuttleType === 5) ? 'form5_d_s' : 'form_d_s');

        DB::table($dTable)
            ->where('shuttle_id', $shuttleId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->update([
                'status'             => 'Tidak Diisi',
                'tarikh_buka_borang' => DB::raw('IFNULL(tarikh_buka_borang, CURDATE())'),
                'tarikh_tutup_borang'=> '2099-12-31',
                'updated_at'         => now(),
            ]);

        if ($shuttleType === 4) {
            DB::table('form4_e_s')
                ->where('shuttle_id', $shuttleId)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->update([
                    'status'             => 'Tidak Diisi',
                    'tarikh_buka_borang' => DB::raw('IFNULL(tarikh_buka_borang, CURDATE())'),
                    'tarikh_tutup_borang'=> '2099-12-31',
                    'updated_at'         => now(),
                ]);
        } elseif ($shuttleType === 5) {
            DB::table('form5_e_s')
                ->where('shuttle_id', $shuttleId)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->update([
                    'status'             => 'Tidak Diisi',
                    'tarikh_buka_borang' => DB::raw('IFNULL(tarikh_buka_borang, CURDATE())'),
                    'tarikh_tutup_borang'=> '2099-12-31',
                    'updated_at'         => now(),
                ]);
        }
    }

    public function down()
    {
        // Data correction — cannot automatically reverse without a full backup
    }
}
