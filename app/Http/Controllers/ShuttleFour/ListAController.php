<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Models\Buffer;
use App\Models\FormA;
use Illuminate\Http\Request;

class ListAController extends Controller
{
    public function shuttle_4_listA($year)
    {
        $user = auth()->user();

        $formA = FormA::where('status', '!=', 'Tidak Diisi')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })->where('tahun', $year)->get();


        $year_list = FormA::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah);
        })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Senarai Borang 4A"],

        ];

        $kembali = route('home');


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listA-phd', compact(
            'user',
            'formA',
            'returnArr',
            'year_list',
            'year',
            'buffer',
            // 'returnArr'
        ));
    }

    public function shuttle_4_listA_jpn($year){
        $user = auth()->user();

        $formA_kilang = FormA::select('shuttle_id')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
            })
            ->distinct()->where('tahun', $year)->get();

        $formA = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        })->where('tahun', $year)->get();

        $year_list = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->distinct()->orderBy('tahun')->get('tahun');

        // $year_list = FormA::select('shuttle_id')
        //     ->whereHas('shuttle', function ($q) {
        //         $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        //     })
        //     ->distinct()->where('tahun', $year)->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();

        $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Borang 4A"],
        ];

        $kembali = route('home-jpn');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.shuttle-four.shuttle-4-listA-jpn', compact(
            'user',
            'formA',
            // 'formB_kilang',
            'year_list',
            'year',
            'buffer',
            'formA_kilang',
            'returnArr'
        ));
    }
}
