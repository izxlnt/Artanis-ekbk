<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Form4E;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListEController extends Controller
{
    public $shuttle_listE;

    public function shuttle_4_listE($year)
    {
        $user=auth()->user();
        // $shuttle_listC = Shuttle::where('shuttle_type', '3')->paginate(10);
        $form4E_kilang = Form4E::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->distinct()->where('tahun', $year)->get();

        $form4E = Form4E::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '4');
         })->where('tahun', $year)->get();

         $year_list = Form4E::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '4');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'e')->where('shuttle', '4')->first();


         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Senarai Borang 4E"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listE-phd',compact('form4E','user','year_list','year','buffer','form4E_kilang','returnArr'));
    }

    public function ibk_shuttle_4_form4E_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();


        $kilang_info = Shuttle::where('id',$id)->first();

        $form4e = Form4E::where('id',$id)->first();
        $id =$form4e->id;

        $form4_e = PenjualanPembeli::where('form4es_id',$form4e->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "BORANG 4E"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-four.view-form4e-ibk',compact('returnArr','kilang_info','form4_e','id','jenis_pembeli','form4e'));
    }

    public function jpn_shuttle_4_form4E_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();


        $kilang_info = Shuttle::where('id',$id)->first();

        $form4e = Form4E::where('id',$id)->first();
        $id =$form4e->id;

        $form4_e = PenjualanPembeli::where('form4es_id',$form4e->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Senarai Borang 4E"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-four.view-form4e-jpn',compact('returnArr','kilang_info','form4_e','id','jenis_pembeli','form4e'));
    }

    public function shuttle_4_listE_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );

        // $formD_kilang = FormD::select('shuttle_id')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->distinct()->where('tahun', $year)->get();

        $form4E_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM form4_e_s
        INNER JOIN shuttles ON form4_e_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form4_e_s.tahun
        AND (form4_e_s.status = 'Dihantar ke IPJPSM' OR form4_e_s.status = 'Lulus')
        AND batches.shuttle_id = form4_e_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '4'
        AND form4_e_s.tahun = $year"));
        // $formD = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();
        // $formD = DB::select(DB::raw('SELECT form4_e_s.* FROM batches, form4_e_s WHERE batches.tahun = form4_e_s.tahun AND batches.bulan = form4_e_s.bulan AND batches.shuttle_id = form4_e_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
        $form4E = Form4E::where('tahun', $year)->where('shuttle_type', '4')->get();

            // dd($formD);

            $year_list = DB::select(DB::raw("SELECT DISTINCT form4_e_s.tahun FROM form4_e_s
            INNER JOIN shuttles ON form4_e_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = form4_e_s.tahun
            AND (form4_e_s.status = 'Dihantar ke IPJPSM' OR form4_e_s.status = 'Lulus')
            AND batches.shuttle_id = form4_e_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '4'"));

        //  $year_list = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'd')->where('shuttle', '4')->first();
        $batch = Batch::get();



         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Senarai Borang 4E"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listE-ipjpsm',compact('returnArr','form4E','user','year_list','year','buffer','form4E_kilang','batch'));

    }

    public function shuttle_4_listE_jpn($year){
        $user=auth()->user();

        $formE_kilang = Form4E::select('shuttle_id')->
        whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        })->
        distinct()->where('tahun', $year)->get();

        $formE = Form4E::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '4');
         })->get();

        // dd($formD[10]->shuttle->id);

         $year_list = Form4E::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri);
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'e')->where('shuttle', '4')->first();


         $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('jpn.shuttle-4-listE-jpn', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listE-jpn',compact('returnArr','formE','user','year_list','year','buffer','formE_kilang'));
    }
}


