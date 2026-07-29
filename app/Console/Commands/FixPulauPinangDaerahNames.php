<?php

namespace App\Console\Commands;

use App\Models\Daerah;
use Illuminate\Console\Command;

class FixPulauPinangDaerahNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daerah:fix-pulau-pinang {--apply : Actually write the changes. Without this flag, only a preview is shown.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Correct the misspelled "Seberang Prai" Pulau Pinang daerah names (daerah_hutan/daerah_sivil) to the official "Seberang Perai" spelling, and normalize the daerah_hutan grouping labels to "Seberang Perai Utara/Tengah" and "Seberang Perai Selatan". Updates rows in place so existing shuttle/daerah_id references are unaffected.';

    private const RENAMES = [
        // old daerah_sivil => [new daerah_hutan, new daerah_sivil]
        'Seberang Prai Utara' => ['Seberang Perai Utara/Tengah', 'Seberang Perai Utara'],
        'Seberang Prai Tengah' => ['Seberang Perai Utara/Tengah', 'Seberang Perai Tengah'],
        'Seberang Prai Selatan' => ['Seberang Perai Selatan', 'Seberang Perai Selatan'],
    ];

    public function handle()
    {
        $apply = $this->option('apply');

        $rows = Daerah::where('negeri', 'Pulau Pinang')
            ->whereIn('daerah_sivil', array_keys(self::RENAMES))
            ->get();

        if ($rows->isEmpty()) {
            $this->info('No Pulau Pinang "Seberang Prai" daerah rows found — nothing to fix (already corrected?).');
            return self::SUCCESS;
        }

        $this->info(($apply ? '[APPLYING] ' : '[DRY RUN] ') . $rows->count() . ' daerah row(s) will be corrected:');
        $this->newLine();

        foreach ($rows as $daerah) {
            [$newHutan, $newSivil] = self::RENAMES[$daerah->daerah_sivil];

            $this->line(sprintf(
                '  id=%d  daerah_hutan: "%s" -> "%s"  |  daerah_sivil: "%s" -> "%s"',
                $daerah->id,
                $daerah->daerah_hutan,
                $newHutan,
                $daerah->daerah_sivil,
                $newSivil
            ));

            if (!$apply) {
                continue;
            }

            $daerah->daerah_hutan = $newHutan;
            $daerah->daerah_sivil = $newSivil;
            $daerah->save();
        }

        $this->newLine();

        if (!$apply) {
            $this->warn('This was a dry run — no changes were made. Re-run with --apply to write the corrected names.');
        } else {
            $this->info('Done. ' . $rows->count() . ' daerah row(s) corrected.');
        }

        return self::SUCCESS;
    }
}
