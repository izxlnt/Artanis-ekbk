<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\FormC;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Notifications\PHD\BorangTidakLengkapNotification;
use Illuminate\Console\Command;

class ReopenShuttle5FormCForOutputCorrection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formc:reopen-shuttle5 {--year=} {--apply : Actually write the changes and send notifications. Without this flag, only a preview is shown.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reopen every Shuttle 5 Form C submission from January to the latest month of the given year (default: current year) that has already been filled, so mills can re-enter the Pengeluaran Kayu Kumai output column that was missing until the recent fix. Mirrors the same status change, batch flag, PHD comment, and notification a real PHD rejection would trigger.';

    private const SYSTEM_PHD_USER_ID = 4;

    private const REOPEN_COMMENT = 'Dibuka semula untuk kemaskini data Pengeluaran Kayu Kumai (ralat sistem telah diperbaiki).';

    public function handle()
    {
        $apply = $this->option('apply');
        $year = $this->option('year') ?? date('Y');

        $systemUser = User::find(self::SYSTEM_PHD_USER_ID);
        if ($apply && !$systemUser) {
            $this->error('System PHD user id=' . self::SYSTEM_PHD_USER_ID . ' not found. Aborting.');
            return self::FAILURE;
        }

        $shuttle5Ids = Shuttle::where('shuttle_type', 5)->pluck('id');

        // 'Ditutup' is the seeded placeholder status for not-yet-reached
        // periods (see FormFlowService), not evidence of real work — it must
        // be excluded alongside 'Tidak Diisi' or future months would be
        // wrongly reopened and their mills wrongly notified.
        $formCs = FormC::whereIn('shuttle_id', $shuttle5Ids)
            ->where('tahun', $year)
            ->whereNotIn('status', ['Tidak Diisi', 'Ditutup'])
            ->orderBy('shuttle_id')
            ->orderBy('bulan')
            ->get();

        if ($formCs->isEmpty()) {
            $this->info("No Shuttle 5 Form C submissions found for {$year} that are already filled.");
            return self::SUCCESS;
        }

        $this->info(($apply ? '[APPLYING] ' : '[DRY RUN] ') . $formCs->count() . " Shuttle 5 Form C submissions for {$year} will be reopened:");
        $this->newLine();

        foreach ($formCs as $formc) {
            $shuttle = $formc->shuttle;

            $this->line(sprintf(
                '  shuttle_id=%d (%s) bulan=%d/%d status: %s -> Tidak Lengkap',
                $formc->shuttle_id,
                $shuttle->nama_kilang ?? '?',
                $formc->bulan,
                $formc->tahun,
                $formc->status
            ));

            if (!$apply) {
                continue;
            }

            $formc->status = 'Tidak Lengkap';
            $formc->save();

            UlasanPhd::create([
                'ulasan' => self::REOPEN_COMMENT,
                'user_id' => $systemUser->id,
                'formcs_id' => $formc->id,
            ]);

            $batch = Batch::where('tahun', $formc->tahun)->where('bulan', $formc->bulan)->where('shuttle_id', $formc->shuttle_id)->first();
            if ($batch) {
                $batch->borang_c = '0';
                $batch->save();
            }

            $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $formc->shuttle_id)->first();
            $pengguna_kilangs = $pengguna_kilang_data
                ? User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get()
                : collect();

            foreach ($pengguna_kilangs as $pengguna_kilang) {
                $pengguna_kilang->notify(new BorangTidakLengkapNotification(
                    $systemUser,
                    $formc,
                    'Tidak Lengkap',
                    self::REOPEN_COMMENT,
                    $pengguna_kilang
                ));
            }
        }

        $this->newLine();

        if (!$apply) {
            $this->warn('This was a dry run — no changes were made and no notifications were sent. Re-run with --apply to actually reopen these submissions and notify the mills.');
        } else {
            $this->info('Done. ' . $formCs->count() . ' Form C submissions reopened and mills notified.');
        }

        return self::SUCCESS;
    }
}
