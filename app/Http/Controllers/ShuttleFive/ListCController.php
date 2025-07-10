<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormC;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListCController extends Controller
{
    public $shuttle_listC;
    public function shuttle_5_listC_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );

        // $formC_kilang = FormC::select('shuttle_id')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->distinct()->where('tahun', $year)->get();


        $formC_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM form_c_s
        INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_c_s.tahun
        AND (form_c_s.status = 'Dihantar ke IPJPSM' OR form_c_s.status = 'Lulus')
        AND batches.shuttle_id = form_c_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '5'
        AND form_c_s.tahun = $year"));

        // dd($formC_kilang);

        // $formC = FormC::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();

        // $formC = DB::select(DB::raw('SELECT form_c_s.* FROM batches, form_c_s WHERE batches.tahun = form_c_s.tahun AND batches.bulan = form_c_s.bulan AND batches.shuttle_id = form_c_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
            // dd($formC);

        $formC = FormC::where('tahun', $year)->where('shuttle_type', '5')->get();

        $year_list = DB::select(DB::raw("SELECT DISTINCT form_c_s.tahun FROM form_c_s
        INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_c_s.tahun
        AND (form_c_s.status = 'Dihantar ke IPJPSM' OR form_c_s.status = 'Lulus')
        AND batches.shuttle_id = form_c_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '5'
        AND form_c_s.tahun = $year"));

$buffer = Buffer::where('borang', 'c')->where('shuttle', '5')->first();
$batch = Batch::get();




         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
        ];

        $kembali = route('home');


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        // dd($formC);
        return view('admins.shuttle-five.shuttle-5-listC-ipjpsm',compact('user','formC', 'formC_kilang', 'year_list','year','buffer', 'returnArr','batch'));
    }

    public function shuttle_5_listC_jpn($year){
        $user=auth()->user();


        $formC_kilang = FormC::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
        })
        ->distinct()->where('tahun', $year)->get();

        $formC = FormC::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '5');
         })->where('tahun', $year)->get();

         $year_list = FormC::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '5');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'c')->where('shuttle', '5')->first();

         $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Borang 5C"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listC-jpn',compact('returnArr','formC','user','year_list','year','buffer','formC_kilang'));
    }
}
