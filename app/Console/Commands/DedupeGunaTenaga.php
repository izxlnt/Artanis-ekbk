<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DedupeGunaTenaga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formb:dedupe-kategori
        {--apply : Actually delete the redundant duplicate rows. Without this flag, only a preview/summary is shown.}
        {--formb-id= : Limit to a single formbs_id.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds guna_tenagas rows duplicated for the same (formbs_id, kategori_guna_tenaga_id) - almost certainly caused by a double-submit race in the Form B store() methods, which used to delete() all rows for the form then re-create() one row per category with no transaction (see the companion fix in FormB.php, now updateOrCreate). Only removes a duplicate group when every row in it is byte-identical across all value columns (keeping the newest/highest id, matching the display-side dedupe in ViewFormBController/DataCleaning3B) - a group whose rows differ in value is left completely untouched and reported separately for manual review, since automatically picking a "correct" value would be a guess.';

    // Columns compared to decide whether duplicate rows are truly identical copies.
    private const VALUE_COLUMNS = [
        'pekerja_wargabumi_lelaki', 'pekerja_wargabumi_perempuan',
        'pekerja_bukan_wargabumi_lelaki', 'pekerja_bukan_wargabumi_perempuan',
        'pekerja_asing_lelaki', 'pekerja_asing_perempuan',
        'jumlah_lelaki', 'jumlah_perempuan', 'jumlah_pekerja',
        'gaji_lelaki', 'gaji_perempuan', 'gaji_lelaki_perempuan',
        'total_gaji_lelaki', 'total_gaji_perempuan', 'total_gaji',
        'total_bumi_lelaki', 'total_bumi_perempuan',
        'total_bukanbumi_lelaki', 'total_bukanbumi_perempuan',
        'total_asing_lelaki', 'total_asing_perempuan',
        'total_pekerja_lelaki', 'total_pekerja_perempuan', 'total_pekerja',
        'jumlah_gaji_lelaki', 'jumlah_gaji_perempuan', 'jumlah_lelaki_perempuan',
        'jumlah_total_lelaki', 'jumlah_total_perempuan', 'jumlah_total_gaji',
        'bulan', 'tahun',
    ];

    public function handle()
    {
        $apply = $this->option('apply');

        $query = DB::table('guna_tenagas')->select('formbs_id', 'kategori_guna_tenaga_id');
        if ($formbId = $this->option('formb-id')) {
            $query->where('formbs_id', $formbId);
        }

        $dupGroups = $query->groupBy('formbs_id', 'kategori_guna_tenaga_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $this->info(($apply ? '[APPLYING] ' : '[DRY RUN] ') . 'Scanning for duplicate (formbs_id, kategori_guna_tenaga_id) rows...');

        $identicalGroups = 0;
        $rowsToDelete = 0;
        $needsReview = [];

        foreach ($dupGroups as $g) {
            $rows = DB::table('guna_tenagas')
                ->where('formbs_id', $g->formbs_id)
                ->where('kategori_guna_tenaga_id', $g->kategori_guna_tenaga_id)
                ->orderBy('id', 'desc')
                ->get();

            $first = $rows->first();
            $allIdentical = $rows->every(function ($row) use ($first) {
                foreach (self::VALUE_COLUMNS as $col) {
                    if ((string) $row->$col !== (string) $first->$col) {
                        return false;
                    }
                }
                return true;
            });

            if (!$allIdentical) {
                $needsReview[] = [
                    'formbs_id' => $g->formbs_id,
                    'kategori_guna_tenaga_id' => $g->kategori_guna_tenaga_id,
                    'ids' => $rows->pluck('id')->implode(', '),
                ];
                continue;
            }

            $identicalGroups++;
            // Keep the newest (highest id) - matches the ->orderBy('id','desc')->unique(...)
            // dedupe already applied on the display side in ViewFormBController/DataCleaning3B.
            $idsToDelete = $rows->pluck('id')->slice(1);
            $rowsToDelete += $idsToDelete->count();

            if ($apply) {
                DB::table('guna_tenagas')->whereIn('id', $idsToDelete)->delete();
            }
        }

        $this->newLine();
        $this->info("Duplicate (formbs_id, kategori_guna_tenaga_id) groups found: {$dupGroups->count()}");
        $this->info("Groups confirmed byte-identical (safe to dedupe): {$identicalGroups}");
        $this->info(($apply ? 'Redundant rows deleted: ' : 'Redundant rows that would be deleted: ') . $rowsToDelete);

        if (!empty($needsReview)) {
            $this->warn("Groups where duplicate rows DIFFER in value - left untouched, needs manual review: " . count($needsReview));
            foreach ($needsReview as $r) {
                $this->line("  formbs_id={$r['formbs_id']} kategori_guna_tenaga_id={$r['kategori_guna_tenaga_id']} row ids=({$r['ids']})");
            }
        }

        if (!$apply && $rowsToDelete > 0) {
            $this->warn('This was a dry run - no changes were made. Re-run with --apply to delete the confirmed-redundant duplicate rows.');
        }

        return self::SUCCESS;
    }
}
