<?php

namespace App\Console\Commands;

use App\Models\FormC;
use App\Models\KemasukanBahan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixFormCJumlahBesar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formc:fix-jumlah-besar
        {--apply : Actually write the corrected grand totals. Without this flag, only a preview/summary is shown.}
        {--shuttle-id= : Limit to a single shuttle (mill) id, for testing before a full run.}
        {--formc-id= : Limit to a single form_c_s id.}
        {--year= : Limit to a single tahun.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recompute "Jumlah Besar" (grand total across all 5 wood groups) on the Lain-Lain kemasukan_bahans rows, from each group\'s own current totals - the same computation FormCController::refreshJumlahBesar() does live after every save. Backfills FormC records left stale before refreshJumlahBesar() existed (42fe74f) and any the one-off 2026_08_06_000001_fix_stale_jumlah_besar_form_c migration missed (it compared MAX() per group instead of the first-row value refreshJumlahBesar() and the live app actually read/display). Only touches records where all 5 wood groups are present (matches refreshJumlahBesar()\'s own guard); does not touch status or send notifications.';

    // kemasukan_bahans group-level column => jumlah_besar_* column it feeds into
    private const GROUP_TO_BESAR = [
        'jumlah_baki_stok' => 'jumlah_besar_baki_stok_bulan_lepas',
        'jumlah_kayu_masuk' => 'jumlah_besar_kemasukan_kayu_ke_kilang',
        'total_stok_kayu_balak' => 'jumlah_besar_stok_kayu_balak',
        'total_kayu_masuk_jentera' => 'jumlah_besar_kayu_ke_dalam_jentera',
        'total_kayu_keluar_jentera' => 'jumlah_besar_pengeluaran_kayu_daripada_jentera',
        'total_kayu_dibawa_bulan_hadapan' => 'jumlah_besar_baki_stok_bulan_depan',
    ];

    private const TOLERANCE = 0.05;

    public function handle()
    {
        $apply = $this->option('apply');

        $query = FormC::query()->orderBy('id');

        if ($shuttleId = $this->option('shuttle-id')) {
            $query->where('shuttle_id', $shuttleId);
        }
        if ($formcId = $this->option('formc-id')) {
            $query->where('id', $formcId);
        }
        if ($year = $this->option('year')) {
            $query->where('tahun', $year);
        }

        $this->info(($apply ? '[APPLYING] ' : '[DRY RUN] ') . 'Scanning Form C records...');

        $formsScanned = 0;
        $formsIncomplete = 0;
        $formsFixed = 0;
        $formsAlreadyCorrect = 0;
        $examplesShown = 0;

        $query->chunkById(200, function ($formcs) use ($apply, &$formsScanned, &$formsIncomplete, &$formsFixed, &$formsAlreadyCorrect, &$examplesShown) {
            foreach ($formcs as $formc) {
                $rows = DB::table('kemasukan_bahans as kb')
                    ->join('spesis as s', 's.id', '=', 'kb.spesis_id')
                    ->where('kb.formcs_id', $formc->id)
                    ->select(
                        'kb.id',
                        's.kumpulan_kayu_id',
                        'kb.jumlah_baki_stok',
                        'kb.jumlah_kayu_masuk',
                        'kb.total_stok_kayu_balak',
                        'kb.total_kayu_masuk_jentera',
                        'kb.total_kayu_keluar_jentera',
                        'kb.total_kayu_dibawa_bulan_hadapan',
                        'kb.jumlah_besar_baki_stok_bulan_lepas',
                        'kb.jumlah_besar_kemasukan_kayu_ke_kilang',
                        'kb.jumlah_besar_stok_kayu_balak',
                        'kb.jumlah_besar_kayu_ke_dalam_jentera',
                        'kb.jumlah_besar_pengeluaran_kayu_daripada_jentera',
                        'kb.jumlah_besar_baki_stok_bulan_depan'
                    )
                    ->get()
                    ->groupBy('kumpulan_kayu_id');

                // Same guard as FormCController::refreshJumlahBesar() - only recompute
                // once the Lain-Lain (group 5) step has actually been reached.
                if (!$rows->has(5)) {
                    continue;
                }

                $formsScanned++;

                // Match refreshJumlahBesar()'s own semantics exactly: it reads
                // ->first() per group, not MAX() across the group's (should-be-
                // identical) duplicated rows - the two can disagree if a group's
                // rows are themselves inconsistent.
                $correct = [];
                foreach (self::GROUP_TO_BESAR as $groupColumn => $besarColumn) {
                    $sum = 0.0;
                    foreach (range(1, 5) as $kkid) {
                        $group = $rows->get($kkid);
                        if (!$group) {
                            continue;
                        }
                        $sum += (float) $group->first()->$groupColumn;
                    }
                    $correct[$besarColumn] = round($sum, 2);
                }

                if ($rows->keys()->intersect(range(1, 5))->count() !== 5) {
                    $formsIncomplete++;
                    continue;
                }

                $lainLainRows = $rows->get(5);
                $stored = $lainLainRows->first();

                $isStale = false;
                foreach ($correct as $column => $value) {
                    if (abs($value - (float) $stored->$column) > self::TOLERANCE) {
                        $isStale = true;
                        break;
                    }
                }

                if (!$isStale) {
                    $formsAlreadyCorrect++;
                    continue;
                }

                $formsFixed++;

                if ($examplesShown < 15) {
                    $examplesShown++;
                    $diffs = [];
                    foreach ($correct as $column => $value) {
                        $before = (float) $stored->$column;
                        if (abs($value - $before) > self::TOLERANCE) {
                            $diffs[] = "{$column}: {$before} -> {$value}";
                        }
                    }
                    $this->line(sprintf(
                        '  formcs_id=%d  %s',
                        $formc->id,
                        implode(', ', $diffs)
                    ));
                }

                if ($apply) {
                    DB::table('kemasukan_bahans')
                        ->whereIn('id', $lainLainRows->pluck('id'))
                        ->update($correct);
                }
            }
        });

        $this->newLine();
        $this->info("Form C records scanned (Lain-Lain present): {$formsScanned}");
        $this->info("Skipped (incomplete - not all 5 groups present): {$formsIncomplete}");
        $this->info("Already correct: {$formsAlreadyCorrect}");
        $this->info(($apply ? 'Corrected: ' : 'Would be corrected: ') . $formsFixed);

        if (!$apply && $formsFixed > 0) {
            $this->warn('This was a dry run - no changes were made. Re-run with --apply to write the corrected grand totals.');
        }

        return self::SUCCESS;
    }
}
