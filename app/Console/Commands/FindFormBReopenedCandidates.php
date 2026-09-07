<?php

namespace App\Console\Commands;

use App\Models\FormB;
use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use App\Models\UlasanPhd;
use Illuminate\Console\Command;

class FindFormBReopenedCandidates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formb:find-reopened-candidates
        {--shuttle-type= : Limit to a single shuttle type (3, 4, or 5).}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnostic only - makes no changes. Lists Form B submissions that were PHD-acted-on more than once (a proxy for "rejected and resubmitted at least once"), across shuttle types 3, 4 and 5. These are the only records that could ever have been affected by the category-position bug in ShuttleFour/FormB.php, ShuttleFive/FormB.php and (historically, already fixed) ShuttleThree/EditForm3B.php - where a rejected form\'s saved per-category values were reloaded by row position instead of by kategori_guna_tenaga_id, so a category could show under a different category\'s label. This command cannot tell you whether a given candidate was actually corrupted (a correctly-labelled resubmission looks identical to a swapped one after the fact) - it only narrows down which records are worth a manual check against the factory\'s own records.';

    public function handle()
    {
        $shuttleTypeFilter = $this->option('shuttle-type');
        $shuttleTypes = $shuttleTypeFilter ? [(string) $shuttleTypeFilter] : ['3', '4', '5'];

        $kategoriById = KategoriGunaTenaga::orderBy('id')->get()->keyBy('id');

        $totalCandidates = 0;

        foreach ($shuttleTypes as $shuttleType) {
            $this->info("=== Shuttle {$shuttleType} ===");

            $formIds = UlasanPhd::whereNotNull('formbs_id')
                ->select('formbs_id')
                ->groupBy('formbs_id')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('formbs_id');

            $candidates = FormB::whereIn('id', $formIds)
                ->where('shuttle_type', $shuttleType)
                ->with('shuttle')
                ->orderBy('tahun')
                ->orderBy('suku_tahun')
                ->get();

            if ($candidates->isEmpty()) {
                $this->line('  (none found)');
                continue;
            }

            foreach ($candidates as $formb) {
                $totalCandidates++;
                $shuttle = $formb->shuttle;
                $comments = UlasanPhd::where('formbs_id', $formb->id)->orderBy('created_at')->get();

                $this->line(sprintf(
                    '  FormB #%d | Kilang: %s (No. SSM: %s) | Tahun: %s Suku: %s | Status semasa: %s | Bilangan tindakan PHD: %d',
                    $formb->id,
                    $shuttle->nama_kilang ?? '(tiada rekod kilang)',
                    $shuttle->no_ssm ?? '-',
                    $formb->tahun,
                    $formb->suku_tahun,
                    $formb->status,
                    $comments->count()
                ));

                foreach ($comments as $c) {
                    $this->line('      - ' . $c->created_at->format('Y-m-d H:i') . ': ' . ($c->ulasan ?: '(tiada ulasan)'));
                }

                // Show the currently-saved per-category headcount so a
                // reviewer can sanity-check it against the factory's own
                // records without opening the UI.
                $rows = GunaTenaga::where('formbs_id', $formb->id)->get()->keyBy('kategori_guna_tenaga_id');
                foreach ($kategoriById as $id => $kategori) {
                    $row = $rows->get($id);
                    if (!$row) {
                        continue;
                    }
                    $this->line(sprintf(
                        '      %s: lelaki=%s perempuan=%s',
                        $kategori->keterangan,
                        $row->jumlah_lelaki ?? 0,
                        $row->jumlah_perempuan ?? 0
                    ));
                }
            }
        }

        $this->newLine();
        $this->info("Total candidates across checked shuttle type(s): {$totalCandidates}");
        $this->warn('This is a candidate list, not a list of confirmed errors - a correctly-saved resubmission is indistinguishable from a swapped one after the fact. Verify against each factory\'s own records (or ask them to reconfirm) before changing anything.');

        return self::SUCCESS;
    }
}
