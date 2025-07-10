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
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->get();

        $year_list = Batch::where('status', 'Sedang Diproses')
        // ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

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


        // dd($id);
        $batch = Batch::findorfail($id);

        $batch->status = "Dihantar ke IPJPSM";

        $batch->save();

        //hantar email ke IPJPSM (lampiran baharu)

        return redirect()->back()->with('success', 'Borang berjaya dihantar ke IPJPSM.');
    }

    public function shuttle_4_phd($year){


        $batch = Batch::where('status', 'Sedang Diproses')
        ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->get();

        $year_list = Batch::where('status', 'Sedang Diproses')
        // ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

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

        // dd($id);
        $batch = Batch::findorfail($id);

        $batch->status = "Dihantar ke IPJPSM";

        $batch->save();

        //hantar email ke IPJPSM (lampiran baharu)

        return redirect()->back()->with('success', 'Borang berjaya dihantar ke IPJPSM.');
    }

    public function shuttle_5_phd($year){

        $batch = Batch::where('status', 'Sedang Diproses')
        ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->get();

        $year_list = Batch::where('status', 'Sedang Diproses')
        ->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

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

        $batch->status = "Dihantar ke IPJPSM";

        $batch->save();

        //hantar email ke IPJPSM (lampiran baharu)

        return redirect()->back()->with('success', 'Borang berjaya dihantar ke IPJPSM.');
    }
}
