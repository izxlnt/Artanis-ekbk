<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Buffer;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use Illuminate\Http\Request;

class ListOverallController extends Controller
{
    public function shuttle_5_listA($year)
    {
        $user = auth()->user();

        // $formB_kilang = FormB::select('shuttle_id')->distinct()->where('tahun', $year)->get();
        $formA = FormA::where('status', '!=', 'Tidak Diisi')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
            })->where('tahun', $year)->get();


        $year_list = FormA::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah);
        })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'a')->where('shuttle', '5')->first();

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Senarai Borang 5A"],


        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.phd.shuttle-5-listA', compact(
            'user',
            'formA',
            // 'formB_kilang',
            'year_list',
            'year',
            'buffer',
            'returnArr'
        ));
    }

    public function shuttle_5_listB($year){
        $user = auth()->user();

        $formB_kilang = FormB::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->where('tahun', $year)->get();

        $formB = FormB::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '5');
         })->where('tahun', $year)->get();

         $year_list = FormB::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '5');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'b')->where('shuttle', '5')->first();

         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Senarai Borang 5B"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.phd.shuttle-5-listB',compact('user','formB', 'formB_kilang', 'year_list','year','buffer','returnArr'));
    }

    public function shuttle_5_listC($year){
        $user=auth()->user();
        // $shuttle_listC = Shuttle::where('shuttle_type', '3')->paginate(10);
        $formC_kilang = FormC::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->where('tahun', $year)->get();

        $formC = FormC::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '5');
         })->where('tahun', $year)->get();

         $year_list = FormC::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '5');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'c')->where('shuttle', '5')->first();


         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.phd.shuttle-5-listC',compact('formC','user','year_list','year','buffer','formC_kilang','returnArr'));
    }

    public function shuttle_5_listD($year){
        $user=auth()->user();

        $formD_kilang = Form5D::select('shuttle_id')->
        whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })->
        distinct()->where('tahun', $year)->get();

        $formD = Form5D::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '5');
         })->get();

        // dd($formD[10]->shuttle->id);

         $year_list = Form5D::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah);
         })->distinct()->orderBy('tahun')->get('tahun');
         $buffer = Buffer::where('borang', 'd')->where('shuttle', '5')->first();

         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Senarai Borang 5D"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.phd.shuttle-5-listD',compact('formD','user','year_list','year','buffer','formD_kilang','returnArr'));
    }

    public function shuttle_5_listE($year){
        $user=auth()->user();

        $formD_kilang = Form5E::select('shuttle_id')->
        whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })->
        distinct()->where('tahun', $year)->get();

        $formD = Form5E::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '5');
         })->get();

        // dd($formD[10]->shuttle->id);

         $year_list = Form5E::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah);
         })->distinct()->orderBy('tahun')->get('tahun');
         $buffer = Buffer::where('borang', 'e')->where('shuttle', '5')->first();

         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Senarai Borang 5E"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.phd.shuttle-5-listE',compact('formD','user','year_list','year','buffer','formD_kilang','returnArr'));
    }
}
