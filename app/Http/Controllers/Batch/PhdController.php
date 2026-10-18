<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormB;
use Illuminate\Http\Request;

class PhdController extends Controller
{
    public function shuttle_3_phd($year){

        $batch = Batch::where('status', 'Sedang Diproses')
        ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
        })
        ->get();

        $batch = $this->withLiveFormAB($batch);

        $year_list = Batch::where('status', 'Sedang Diproses')
        ->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
        })
        ->where('tahun', '>=', config('app.data_start_year'))->distinct()->orderBy('tahun')->get('tahun');

        // dd( $year_list);

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.batch.s3', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.batch.s3', date('Y')), 'name' => "Pengesahan Pakej"],
            ['link' => route('phd.batch.s3', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('batch.shuttle_3_phd', compact('returnArr','batch', 'year_list', 'year'));
    }

    public function shuttle_3_phd_hantar($id){

        $batch = Batch::findorfail($id);

        if ($incomplete = $this->borangBelumLengkap($batch, ['borang_a', 'borang_b', 'borang_c', 'borang_d'])) {
            return redirect()->back()->with('error', 'Pakej ini belum boleh dihantar — '.$incomplete.' masih belum disahkan.');
        }

        $batch->status = "Dihantar ke IPJPSM";

        $batch->save();

        //hantar email ke IPJPSM (lampiran baharu)

        return redirect()->back()->with('success', 'Borang berjaya dihantar ke IPJPSM.');
    }

    public function shuttle_4_phd($year){

        $batch = Batch::where('status', 'Sedang Diproses')
        ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->get();

        $batch = $this->withLiveFormAB($batch);

        $year_list = Batch::where('status', 'Sedang Diproses')
        ->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->where('tahun', '>=', config('app.data_start_year'))->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.batch.s4', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.batch.s4', date('Y')), 'name' => "Pengesahan Pakej"],
            ['link' => route('phd.batch.s4', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('batch.shuttle_4_phd', compact('returnArr', 'batch', 'year_list', 'year'));
    }

    public function shuttle_4_phd_hantar($id){

        $batch = Batch::findorfail($id);

        if ($incomplete = $this->borangBelumLengkap($batch, ['borang_a', 'borang_b', 'borang_c', 'borang_d', 'borang_e'])) {
            return redirect()->back()->with('error', 'Pakej ini belum boleh dihantar — '.$incomplete.' masih belum disahkan.');
        }

        $batch->status = "Dihantar ke IPJPSM";

        $batch->save();

        //hantar email ke IPJPSM (lampiran baharu)

        return redirect()->back()->with('success', 'Borang berjaya dihantar ke IPJPSM.');
    }

    public function shuttle_5_phd($year){

        $batch = Batch::where('status', 'Sedang Diproses')
        ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->get();

        $batch = $this->withLiveFormAB($batch);

        $year_list = Batch::where('status', 'Sedang Diproses')
        ->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->where('tahun', '>=', config('app.data_start_year'))->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.batch.s5', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.batch.s5', date('Y')), 'name' => "Pengesahan Pakej"],
            ['link' => route('phd.batch.s5', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('batch.shuttle_5_phd', compact('returnArr', 'batch', 'year_list', 'year'));
    }

    public function shuttle_5_phd_hantar($id){

        $batch = Batch::findorfail($id);

        if ($incomplete = $this->borangBelumLengkap($batch, ['borang_a', 'borang_b', 'borang_c', 'borang_d', 'borang_e'])) {
            return redirect()->back()->with('error', 'Pakej ini belum boleh dihantar — '.$incomplete.' masih belum disahkan.');
        }

        $batch->status = "Dihantar ke IPJPSM";

        $batch->save();

        //hantar email ke IPJPSM (lampiran baharu)

        return redirect()->back()->with('success', 'Borang berjaya dihantar ke IPJPSM.');
    }

    /** Batch flag for a form status: 0 = not submitted, 1 = waiting for PHD, 2 = approved by PHD */
    private static function flagFor(?string $status): string
    {
        if (in_array($status, ['Dihantar ke IPJPSM', 'Lulus'], true)) {
            return '2';
        }

        return in_array($status, ['Sedang Diproses', 'Tiada Pengeluaran'], true) ? '1' : '0';
    }

    /**
     * borang_a (yearly) and borang_b (quarterly) on the monthly batch rows are copies that go
     * stale: Borang A never updates later months, and a Borang B submitted for one year could
     * leave a flag on another year's December row. Show the live form status instead, and drop
     * month rows where nothing has actually been submitted (they only appeared via a stale flag).
     */
    private function withLiveFormAB($batches)
    {
        if ($batches->isEmpty()) {
            return $batches;
        }

        $shuttleIds = $batches->pluck('shuttle_id')->unique();
        $years = $batches->pluck('tahun')->unique();

        $formA = FormA::whereIn('shuttle_id', $shuttleIds)->whereIn('tahun', $years)->get()
            ->keyBy(fn ($f) => $f->shuttle_id . '-' . $f->tahun);
        $formB = FormB::whereIn('shuttle_id', $shuttleIds)->whereIn('tahun', $years)->get()
            ->keyBy(fn ($f) => $f->shuttle_id . '-' . $f->tahun . '-' . $f->suku_tahun);

        return $batches->map(function ($batch) use ($formA, $formB) {
            $batch->status_a = optional($formA->get($batch->shuttle_id . '-' . $batch->tahun))->status;
            $batch->borang_a = self::flagFor($batch->status_a);

            $bulan = (int) $batch->bulan;
            $batch->borang_b = in_array($bulan, [3, 6, 9, 12], true)
                ? self::flagFor(optional($formB->get($batch->shuttle_id . '-' . $batch->tahun . '-' . ($bulan / 3)))->status)
                : '0';

            return $batch;
        })->filter(function ($batch) {
            return $batch->borang_b != '0' || $batch->borang_c != '0' || $batch->borang_d != '0' || ($batch->borang_e ?? '0') != '0';
        })->values();
    }

    /**
     * Returns a human-readable label for the first borang field on the batch
     * that isn't confirmed (status "2") yet, or null if all of them are.
     */
    private function borangBelumLengkap(Batch $batch, array $fields): ?string
    {
        $labels = [
            'borang_a' => 'Borang A',
            'borang_b' => 'Borang B',
            'borang_c' => 'Borang C',
            'borang_d' => 'Borang D',
            'borang_e' => 'Borang E',
        ];

        // Borang B is quarterly: only the quarter-end month's batch (bulan 3/6/9/12)
        // ever gets borang_b confirmed to '2' (see ShuttleThree\MainController::
        // update_status_phd_form3B()). Every other month's batch row is seeded with
        // borang_b = '0' and nothing ever updates it, so requiring it outside the
        // quarter-end months would make sending permanently impossible for 8 of
        // every 12 months. The blade views already gate the "Hantar Pakej" button
        // this same way — this mirrors that.
        $isQuarterEndMonth = in_array((int) $batch->bulan, [3, 6, 9, 12], true);

        foreach ($fields as $field) {
            if ($field === 'borang_b' && !$isQuarterEndMonth) {
                continue;
            }

            // Form A has no month dimension - it's confirmed once per shuttle/year -
            // but `batches` is keyed per month, so `borang_a` on any given month's row
            // is only as fresh as the last time something happened to cascade-update
            // it (see update_status_phd_form3A()). A batch row created afterwards
            // (e.g. Form B/D/E's first submission for a later month, via
            // Batch::firstOrNew()) never sets borang_a, so it silently defaults to
            // "0" even when Form A was already confirmed. Check the live FormA record
            // instead of the stale mirror to avoid that false negative.
            if ($field === 'borang_a') {
                $formAStatus = FormA::where('shuttle_id', $batch->shuttle_id)
                    ->where('tahun', $batch->tahun)
                    ->value('status');

                if (!in_array($formAStatus, ['Dihantar ke IPJPSM', 'Lulus'], true)) {
                    return $labels[$field];
                }

                continue;
            }

            // Borang B on a quarter-end month: check the live quarterly form, not the stale copy
            if ($field === 'borang_b') {
                $formBStatus = FormB::where('shuttle_id', $batch->shuttle_id)
                    ->where('tahun', $batch->tahun)
                    ->where('suku_tahun', (int) $batch->bulan / 3)
                    ->value('status');

                if (self::flagFor($formBStatus) !== '2') {
                    return $labels[$field];
                }

                continue;
            }

            if ($batch->{$field} != '2') {
                return $labels[$field];
            }
        }

        return null;
    }
}
