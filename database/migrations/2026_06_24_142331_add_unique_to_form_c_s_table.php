<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUniqueToFormCSTable extends Migration
{
    public function up()
    {
        // ── Status priority: lower number = higher priority ────────────────
        $statusPriority = [
            'Lulus'              => 1,
            'Dihantar ke IPJPSM' => 2,
            'Tiada Pengeluaran'  => 3,
            'Sedang Diproses'    => 4,
            'Tidak Lengkap'      => 5,
            'Sedang Diisi'       => 6,
            'Tidak Diisi'        => 7,
        ];

        // ── Step 1: Load all FormC records ────────────────────────────────
        $allFormC = DB::table('form_c_s')
            ->select('id', 'shuttle_id', 'tahun', 'bulan', 'status', 'no_ssm', 'nama_kilang', 'tiada_pengeluaran')
            ->orderBy('id')
            ->get();

        // Preload kemasukan_bahans counts so we can tell which records have real data
        $allIds = $allFormC->pluck('id')->toArray();
        $kemCounts = empty($allIds) ? collect() : DB::table('kemasukan_bahans')
            ->whereIn('formcs_id', $allIds)
            ->select('formcs_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('formcs_id')
            ->pluck('cnt', 'formcs_id');

        $grouped = $allFormC->groupBy(function ($row) {
            return $row->shuttle_id . '-' . $row->tahun . '-' . $row->bulan;
        });

        $keepIds      = [];   // one id to keep per group
        $resetIds     = [];   // ids to reset to Tidak Diisi (no-data duplicates only)
        $needsReentry = [];   // human-readable list for logging

        foreach ($grouped as $key => $group) {
            // Pick best record:
            //   1st priority — has real kemasukan_bahans data OR tiada_pengeluaran=1
            //   2nd priority — highest status (Lulus > Dihantar > ... > Tidak Diisi)
            //   3rd priority — oldest id (tiebreaker)
            $best = $group->sortBy(function ($row) use ($statusPriority, $kemCounts) {
                $hasData  = ($kemCounts[$row->id] ?? 0) > 0 || (bool) $row->tiada_pengeluaran;
                $dataSort = $hasData ? 0 : 1; // data-bearing records sort first
                $priority = $statusPriority[$row->status] ?? 99;
                return sprintf('%d-%02d-%010d', $dataSort, $priority, $row->id);
            })->first();

            $keepIds[] = $best->id;

            // Only process groups that ARE duplicates
            if ($group->count() <= 1) {
                continue;
            }

            [$shuttleId, $tahun, $bulan] = explode('-', $key);

            $bestHasData = ($kemCounts[$best->id] ?? 0) > 0 || (bool) $best->tiada_pengeluaran;

            if ($bestHasData) {
                // Kept record already has real data — preserve it as-is, no re-entry needed
                $needsReentry[] = [
                    'shuttle_id'  => $shuttleId,
                    'tahun'       => $tahun,
                    'bulan'       => $bulan,
                    'keep_id'     => $best->id,
                    'no_ssm'      => $best->no_ssm,
                    'nama_kilang' => $best->nama_kilang,
                    'dupes'       => $group->count(),
                    'note'        => 'Data dipulihara — tiada re-entry',
                ];
            } else {
                // No kemasukan data in any duplicate — reset so user can re-enter
                $resetIds[] = $best->id;
                $needsReentry[] = [
                    'shuttle_id'  => $shuttleId,
                    'tahun'       => $tahun,
                    'bulan'       => $bulan,
                    'keep_id'     => $best->id,
                    'no_ssm'      => $best->no_ssm,
                    'nama_kilang' => $best->nama_kilang,
                    'dupes'       => $group->count(),
                    'note'        => 'Tiada data — perlu isi semula',
                ];
            }
        }

        // ── Step 2: Clean up duplicates (skip if no data at all) ─────────
        if (!empty($keepIds)) {
            $placeholders = implode(',', $keepIds);

            DB::statement("
                DELETE FROM kemasukan_bahans
                WHERE formcs_id IS NOT NULL
                  AND formcs_id NOT IN ({$placeholders})
            ");

            DB::statement("
                DELETE FROM ulasan_phds
                WHERE formcs_id IS NOT NULL
                  AND formcs_id NOT IN ({$placeholders})
            ");

            DB::statement("
                DELETE FROM ulasan_ipjpsms
                WHERE formcs_id IS NOT NULL
                  AND formcs_id NOT IN ({$placeholders})
            ");

            // ── Step 3: Delete duplicate FormC records ────────────────────
            DB::statement("
                DELETE FROM form_c_s
                WHERE id NOT IN ({$placeholders})
            ");

            // ── Step 4: Reset no-data groups to Tidak Diisi ───────────────
            // Also extend tarikh_tutup_borang so the window stays open for re-entry.
            if (!empty($resetIds)) {
                $resetPlaceholders = implode(',', $resetIds);
                DB::statement("
                    UPDATE form_c_s
                    SET status = 'Tidak Diisi',
                        tarikh_buka_borang  = IFNULL(tarikh_buka_borang, CURDATE()),
                        tarikh_tutup_borang = '2099-12-31',
                        updated_at = NOW()
                    WHERE id IN ({$resetPlaceholders})
                ");
            }
        }

        // ── Step 5: Add unique constraint (always, even on empty DB) ──────
        Schema::table('form_c_s', function (Blueprint $table) {
            $table->unique(['shuttle_id', 'tahun', 'bulan'], 'form_c_s_shuttle_tahun_bulan_unique');
        });

        // ── Step 6: Print report ──────────────────────────────────────────
        if (empty($needsReentry)) {
            echo PHP_EOL . "Tiada duplikat ditemui. Constraint unik telah ditambah." . PHP_EOL;
            return;
        }

        $bulanNames = ['', 'Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun',
                       'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'];

        $line = str_repeat('═', 108);
        echo PHP_EOL;
        echo "╔{$line}╗" . PHP_EOL;
        echo "║" . str_pad('  SENARAI KILANG DENGAN DUPLIKAT BORANG C SELEPAS MIGRATION', 108) . "║" . PHP_EOL;
        echo "╠{$line}╣" . PHP_EOL;
        echo sprintf("║ %-8s %-5s %-4s %-5s %-18s %-35s %-27s ║",
            'Shuttle', 'Tahun', 'Bln', 'Dupes', 'No SSM', 'Nama Kilang', 'Nota') . PHP_EOL;
        echo "╠{$line}╣" . PHP_EOL;

        $preservedCount = 0;
        $reentryCount   = 0;

        foreach ($needsReentry as $item) {
            $bulanName   = $bulanNames[$item['bulan']] ?? $item['bulan'];
            $isPreserved = strpos($item['note'], 'dipulihara') !== false;
            if ($isPreserved) $preservedCount++; else $reentryCount++;

            echo sprintf("║ %-8s %-5s %-4s %-5s %-18s %-35s %-27s ║",
                $item['shuttle_id'],
                $item['tahun'],
                $bulanName,
                $item['dupes'],
                substr($item['no_ssm'] ?? '-', 0, 18),
                substr($item['nama_kilang'] ?? '-', 0, 35),
                substr($item['note'], 0, 27)
            ) . PHP_EOL;
        }

        echo "╠{$line}╣" . PHP_EOL;
        echo sprintf("║  Data dipulihara (tiada re-entry): %-3s kilang   |   Tiada data (perlu isi semula): %-3s kilang%s║",
            $preservedCount, $reentryCount, str_repeat(' ', 8)) . PHP_EOL;
        echo "╚{$line}╝" . PHP_EOL;
        echo PHP_EOL;
    }

    public function down()
    {
        Schema::table('form_c_s', function (Blueprint $table) {
            $table->dropUnique('form_c_s_shuttle_tahun_bulan_unique');
        });
    }
}
