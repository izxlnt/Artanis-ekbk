<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use App\Models\Batch;
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

            if ($batch->{$field} != '2') {
                return $labels[$field];
            }
        }

        return null;
    }
}
