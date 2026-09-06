<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DedupeKemasukanBahanSpecies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formc:dedupe-species
        {--apply : Actually delete the redundant duplicate rows. Without this flag, only a preview/summary is shown.}
        {--formc-id= : Limit to a single form_c_s id.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds kemasukan_bahans rows duplicated for the same (formcs_id, spesis_id) - almost certainly caused by a double-submit race in the Form C wizard store() methods (see the companion fix in FormCController). Only removes a duplicate group when every row in it is byte-identical across all value columns (keeping the oldest/lowest id) - a group whose rows differ in value is left completely untouched and reported separately for manual review, since automatically picking a "correct" value would be a guess.';

    // Columns compared to decide whether duplicate rows are truly identical copies.
    private const VALUE_COLUMNS = [
        'baki_stok', 'kayu_masuk', 'jumlah_stok_kayu_balak', 'proses_masuk', 'proses_keluar', 'baki_stok_kehadapan',
        'jumlah_baki_stok', 'jumlah_kayu_masuk', 'total_stok_kayu_balak', 'total_kayu_masuk_jentera',
        'total_kayu_keluar_jentera', 'total_kayu_dibawa_bulan_hadapan',
        'jumlah_besar_baki_stok_bulan_lepas', 'jumlah_besar_kemasukan_kayu_ke_kilang', 'jumlah_besar_stok_kayu_balak',
        'jumlah_besar_kayu_ke_dalam_jentera', 'jumlah_besar_pengeluaran_kayu_daripada_jentera',
        'jumlah_besar_baki_stok_bulan_depan',
    ];

    public function handle()
    {
        $apply = $this->option('apply');

        $query = DB::table('kemasukan_bahans')->select('formcs_id', 'spesis_id');
        if ($formcId = $this->option('formc-id')) {
            $query->where('formcs_id', $formcId);
        }

        $dupGroups = $query->groupBy('formcs_id', 'spesis_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $this->info(($apply ? '[APPLYING] ' : '[DRY RUN] ') . 'Scanning for duplicate (formcs_id, spesis_id) rows...');

        $identicalGroups = 0;
        $rowsToDelete = 0;
        $needsReview = [];

        foreach ($dupGroups as $g) {
            $rows = DB::table('kemasukan_bahans')
                ->where('formcs_id', $g->formcs_id)
                ->where('spesis_id', $g->spesis_id)
                ->orderBy('id')
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
                    'formcs_id' => $g->formcs_id,
                    'spesis_id' => $g->spesis_id,
                    'ids' => $rows->pluck('id')->implode(', '),
                ];
                continue;
            }

            $identicalGroups++;
            $idsToDelete = $rows->pluck('id')->slice(1); // keep the oldest (lowest id), drop the rest
            $rowsToDelete += $idsToDelete->count();

            if ($apply) {
                DB::table('kemasukan_bahans')->whereIn('id', $idsToDelete)->delete();
            }
        }

        $this->newLine();
        $this->info("Duplicate (formcs_id, spesis_id) groups found: {$dupGroups->count()}");
        $this->info("Groups confirmed byte-identical (safe to dedupe): {$identicalGroups}");
        $this->info(($apply ? 'Redundant rows deleted: ' : 'Redundant rows that would be deleted: ') . $rowsToDelete);

        if (!empty($needsReview)) {
            $this->warn("Groups where duplicate rows DIFFER in value - left untouched, needs manual review: " . count($needsReview));
            foreach ($needsReview as $r) {
                $this->line("  formcs_id={$r['formcs_id']} spesis_id={$r['spesis_id']} row ids=({$r['ids']})");
            }
        }

        if (!$apply && $rowsToDelete > 0) {
            $this->warn('This was a dry run - no changes were made. Re-run with --apply to delete the confirmed-redundant duplicate rows.');
        }

        return self::SUCCESS;
    }
}
