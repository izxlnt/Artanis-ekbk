<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FormC;
use App\Models\KemasukanBahan;
use App\Models\Shuttle;

class RepairTiadaPengeluaranTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formc:repair-tiada-pengeluaran {--apply : Actually write the fix. Without this flag, only a preview is shown.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Form C "Tiada Pengeluaran" rows (all shuttle types) where total_stok_kayu_balak and total_kayu_dibawa_bulan_hadapan were hardcoded to 0 instead of carrying the previous month\'s balance forward.';

    public function handle()
    {
        $apply = $this->option('apply');

        $shuttleIds = Shuttle::whereIn('shuttle_type', ['3', '4', '5'])->pluck('id');

        $totalRowsFixed = 0;
        $totalFormsFixed = 0;

        foreach ($shuttleIds as $shuttleId) {
            $tahuns = FormC::where('shuttle_id', $shuttleId)->distinct()->pluck('tahun');

            foreach ($tahuns as $tahun) {
                for ($bulan = 2; $bulan <= 12; $bulan++) {
                    $formc = FormC::where('shuttle_id', $shuttleId)->where('bulan', $bulan)->where('tahun', $tahun)->first();
                    if (!$formc || $formc->tiada_pengeluaran != 1) {
                        continue;
                    }

                    $lastFormc = FormC::where('shuttle_id', $shuttleId)->where('bulan', $bulan - 1)->where('tahun', $tahun)->first();
                    if (!$lastFormc) {
                        continue;
                    }

                    $rows = KemasukanBahan::where('shuttle_id', $shuttleId)->where('formcs_id', $formc->id)->get();
                    if ($rows->isEmpty()) {
                        continue;
                    }

                    $formFixed = false;

                    foreach ($rows as $row) {
                        $lastRow = KemasukanBahan::where('shuttle_id', $shuttleId)
                            ->where('formcs_id', $lastFormc->id)
                            ->where('spesis_id', $row->spesis_id)
                            ->first();

                        $carry = $lastRow->total_kayu_dibawa_bulan_hadapan ?? 0;
                        $baki = $row->baki_stok_kehadapan ?? 0;

                        // Only touch rows matching the exact bug signature: the
                        // auto-generated "tiada pengeluaran" row hardcoded
                        // jumlah_stok_kayu_balak, total_stok_kayu_balak and
                        // total_kayu_dibawa_bulan_hadapan to literal 0 together
                        // while a real carried balance existed. Requiring all
                        // three to be 0 avoids touching rows where only some
                        // fields are 0 for unrelated, legitimate reasons.
                        $isBuggyRow = (float)$row->jumlah_stok_kayu_balak === 0.0
                            && (float)$row->total_stok_kayu_balak === 0.0
                            && (float)$row->total_kayu_dibawa_bulan_hadapan === 0.0
                            && ((float)$carry !== 0.0 || (float)$baki !== 0.0);

                        if (!$isBuggyRow) {
                            continue;
                        }

                        $formFixed = true;
                        $totalRowsFixed++;

                        $this->line(sprintf(
                            'shuttle=%d tahun=%d bulan=%d spesis=%d: jumlah_baki_stok %s->%s, total_stok_kayu_balak %s->%s, total_kayu_dibawa_bulan_hadapan %s->%s, jumlah_stok_kayu_balak %s->%s',
                            $shuttleId,
                            $tahun,
                            $bulan,
                            $row->spesis_id,
                            $row->jumlah_baki_stok,
                            $carry,
                            $row->total_stok_kayu_balak,
                            $carry,
                            $row->total_kayu_dibawa_bulan_hadapan,
                            $carry,
                            $row->jumlah_stok_kayu_balak,
                            $baki
                        ));

                        if ($apply) {
                            $row->jumlah_baki_stok = $carry;
                            $row->total_stok_kayu_balak = $carry;
                            $row->total_kayu_dibawa_bulan_hadapan = $carry;
                            $row->jumlah_stok_kayu_balak = $baki;
                            $row->save();
                        }
                    }

                    if ($formFixed) {
                        $totalFormsFixed++;
                    }
                }
            }
        }

        $this->info(($apply ? '[APPLIED] ' : '[DRY RUN] ') . "Forms affected: $totalFormsFixed, rows fixed: $totalRowsFixed");

        if (!$apply && $totalRowsFixed > 0) {
            $this->warn('Run again with --apply to write these changes.');
        }

        return 0;
    }
}
