<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Form5E;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListEController extends Controller
{
    public $shuttle_listE;
    public function shuttle_5_listE_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );

        // $formD_kilang = FormD::select('shuttle_id')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->distinct()->where('tahun', $year)->get();

        $form5E_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM form5_e_s
        INNER JOIN shuttles ON form5_e_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form5_e_s.tahun
        AND (form5_e_s.status = 'Dihantar ke IPJPSM' OR form5_e_s.status = 'Lulus')
        AND batches.shuttle_id = form5_e_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '5'
        AND form5_e_s.tahun = $year"));
        // $formD = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();
        // $formD = DB::select(DB::raw('SELECT form5_e_s.* FROM batches, form5_e_s WHERE batches.tahun = form5_e_s.tahun AND batches.bulan = form5_e_s.bulan AND batches.shuttle_id = form5_e_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
        $form5E = Form5E::where('tahun', $year)->where('shuttle_type', '5')->get();

            // dd($formD);

            $year_list = DB::select(DB::raw("SELECT DISTINCT form5_e_s.tahun FROM form5_e_s
            INNER JOIN shuttles ON form5_e_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = form5_e_s.tahun
            AND (form5_e_s.status = 'Dihantar ke IPJPSM' OR form5_e_s.status = 'Lulus')
            AND batches.shuttle_id = form5_e_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '5'
            AND form5_e_s.tahun = $year"));

        //  $year_list = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'd')->where('shuttle', '5')->first();
         $batch = Batch::get();


         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Senarai Borang 5E"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listE-ipjpsm',compact('form5E','user','year_list','year','buffer','form5E_kilang', 'returnArr','batch'));
    }

    public function shuttle_5_listE_jpn($year){
        $user=auth()->user();

        $formE_kilang = Form5E::select('shuttle_id')->
        whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
        })->
        distinct()->where('tahun', $year)->get();

        $formE = Form5E::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '5');
         })->get();

        // dd($formD[10]->shuttle->id);

         $year_list = Form5E::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri);
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'e')->where('shuttle', '5')->first();


         $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('home-jpn');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listE-jpn',compact('returnArr','formE','user','year_list','year','buffer','formE_kilang'));
    }

    public function ibk_shuttle_5_form5E_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $form5e = Form5E::findorfail($id);

        $kilang_info = Shuttle::where('id',$form5e->shuttle_id)->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Borang 5E - PENYATA PENJUALAN"],
        ];

        $kembali = route('phd.shuttle-5-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];




        return view('admins.shuttle-five.view-form5e-ibk',compact('kilang_info','id','form5e','returnArr'));
    }

    public function jpn_shuttle_5_form5E_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $form5e = Form5E::findorfail($id);

        $kilang_info = Shuttle::where('id',$form5e->shuttle_id)->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-5-listE-jpn', date('Y')), 'name' => "Senarai Borang 5E"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('phd.shuttle-5-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];




        return view('admins.shuttle-five.view-form5e-jpn',compact('kilang_info','id','form5e','returnArr'));
    }
}
