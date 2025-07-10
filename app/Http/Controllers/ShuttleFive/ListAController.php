<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Buffer;
use App\Models\FormA;
use Illuminate\Http\Request;

class ListAController extends Controller
{
    public function shuttle_5_listA_jpn($year){
        $user = auth()->user();

        $formA_kilang = FormA::select('shuttle_id')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
            })
            ->distinct()->where('tahun', $year)->get();

        $formA = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
        })->where('tahun', $year)->get();

        $year_list = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->distinct()->orderBy('tahun')->get('tahun');

        // $year_list = FormA::select('shuttle_id')
        //     ->whereHas('shuttle', function ($q) {
        //         $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        //     })
        //     ->distinct()->where('tahun', $year)->orderBy('tahun')->get('tahun');


        $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Borang 5A "],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.shuttle-five.shuttle-5-listA-jpn', compact(
            'user',
            'formA',
            // 'formB_kilang',
            'year_list',
            'year',
            // 'buffer',
            'formA_kilang',
            'returnArr'
        ));
    }
}
