<?php

namespace App\Console\Commands;

use App\Models\FormC;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixFormCGroupTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formc:fix-group-totals
        {--apply : Actually write the corrected totals. Without this flag, only a preview/summary is shown.}
        {--shuttle-id= : Limit to a single shuttle (mill) id, for testing before a full run.}
        {--formc-id= : Limit to a single form_c_s id.}
        {--year= : Limit to a single tahun.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recompute each wood-group\'s "Jumlah" totals (jumlah_baki_stok, jumlah_kayu_masuk, total_stok_kayu_balak, total_kayu_masuk_jentera, total_kayu_keluar_jentera, total_kayu_dibawa_bulan_hadapan) on kemasukan_bahans from the underlying per-species rows, and writes the corrected value onto every row in that (formcs_id, kumpulan_kayu_id) group. Backfills historical data that was saved before the Form C Jumlah-row blade fix (array index bug); does not touch status or send notifications.';

    // kemasukan_bahans column => which per-species column it should be the sum of
    private const SUM_FIELDS = [
        'jumlah_baki_stok' => 'baki_stok',
        'jumlah_kayu_masuk' => 'kayu_masuk',
        'total_stok_kayu_balak' => 'jumlah_stok_kayu_balak',
        'total_kayu_masuk_jentera' => 'proses_masuk',
        'total_kayu_keluar_jentera' => 'proses_keluar',
        'total_kayu_dibawa_bulan_hadapan' => 'baki_stok_kehadapan',
    ];

    private const TOLERANCE = 0.005;

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
        $groupsFixed = 0;
        $groupsAlreadyCorrect = 0;
        $examplesShown = 0;

        $query->chunkById(200, function ($formcs) use ($apply, &$formsScanned, &$groupsFixed, &$groupsAlreadyCorrect, &$examplesShown) {
            foreach ($formcs as $formc) {
                $formsScanned++;

                $rows = DB::table('kemasukan_bahans as kb')
                    ->join('spesis as s', 's.id', '=', 'kb.spesis_id')
                    ->where('kb.formcs_id', $formc->id)
                    ->select(
                        'kb.id',
                        's.kumpulan_kayu_id',
                        'kb.baki_stok',
                        'kb.kayu_masuk',
                        'kb.jumlah_stok_kayu_balak',
                        'kb.proses_masuk',
                        'kb.proses_keluar',
                        'kb.baki_stok_kehadapan',
                        'kb.jumlah_baki_stok',
                        'kb.jumlah_kayu_masuk',
                        'kb.total_stok_kayu_balak',
                        'kb.total_kayu_masuk_jentera',
                        'kb.total_kayu_keluar_jentera',
                        'kb.total_kayu_dibawa_bulan_hadapan'
                    )
                    ->get()
                    ->groupBy('kumpulan_kayu_id');

                foreach ($rows as $kumpulanKayuId => $groupRows) {
                    $correct = [];
                    foreach (self::SUM_FIELDS as $totalColumn => $sourceColumn) {
                        $correct[$totalColumn] = round((float) $groupRows->sum($sourceColumn), 2);
                    }

                    // A group is only "already correct" if every row in it already carries
                    // the correct value - not just if some row happens to. Otherwise a single
                    // coincidentally-correct row (see commit 67697fc) would mask the other
                    // rows in the group still holding stale/zero totals.
                    $mismatchedColumns = [];
                    foreach ($correct as $column => $value) {
                        $mismatch = $groupRows->first(fn($row) => abs((float) $row->$column - $value) > self::TOLERANCE);
                        if ($mismatch) {
                            $mismatchedColumns[$column] = (float) $mismatch->$column;
                        }
                    }

                    if (empty($mismatchedColumns)) {
                        $groupsAlreadyCorrect++;
                        continue;
                    }

                    $groupsFixed++;

                    if ($examplesShown < 15) {
                        $examplesShown++;
                        $diffs = [];
                        foreach ($mismatchedColumns as $column => $stored) {
                            $diffs[] = "{$column}: {$stored} -> {$correct[$column]}";
                        }
                        $this->line(sprintf(
                            '  formcs_id=%d kumpulan_kayu_id=%d rows=%d  %s',
                            $formc->id,
                            $kumpulanKayuId,
                            $groupRows->count(),
                            implode(', ', $diffs)
                        ));
                    }

                    if ($apply) {
                        DB::table('kemasukan_bahans')
                            ->whereIn('id', $groupRows->pluck('id'))
                            ->update($correct);
                    }
                }
            }
        });

        $this->newLine();
        $this->info("Form C records scanned: {$formsScanned}");
        $this->info("Wood-groups already correct: {$groupsAlreadyCorrect}");
        $this->info(($apply ? 'Wood-groups corrected: ' : 'Wood-groups that would be corrected: ') . $groupsFixed);

        if (!$apply && $groupsFixed > 0) {
            $this->warn('This was a dry run - no changes were made. Re-run with --apply to write the corrected totals.');
        }

        return self::SUCCESS;
    }
}
