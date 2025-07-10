<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Form5D;
use App\Models\JenisKayu;
use App\Models\PengeluaranForm5D;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListDController extends Controller
{
    public $shuttle_listD;
    public function shuttle_5_listD_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );

        // $formD_kilang = FormD::select('shuttle_id')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->distinct()->where('tahun', $year)->get();

        $form5D_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM form5_d_s
        INNER JOIN shuttles ON form5_d_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form5_d_s.tahun
        AND (form5_d_s.status = 'Dihantar ke IPJPSM' OR form5_d_s.status = 'Lulus')
        AND batches.shuttle_id = form5_d_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '5'
        AND form5_d_s.tahun = $year"));
        // $formD = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();
        // $formD = DB::select(DB::raw('SELECT form5_d_s.* FROM batches, form5_d_s WHERE batches.tahun = form5_d_s.tahun AND batches.bulan = form5_d_s.bulan AND batches.shuttle_id = form5_d_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
        $form5D = Form5D::where('tahun', $year)->where('shuttle_type', '5')->get();

            // dd($formD);

            $year_list = DB::select(DB::raw("SELECT DISTINCT form5_d_s.tahun FROM form5_d_s
            INNER JOIN shuttles ON form5_d_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = form5_d_s.tahun
            AND (form5_d_s.status = 'Dihantar ke IPJPSM' OR form5_d_s.status = 'Lulus')
            AND batches.shuttle_id = form5_d_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '5'
            AND form5_d_s.tahun = $year"));

        //  $year_list = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'd')->where('shuttle', '5')->first();
        $batch = Batch::get();

         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Senarai Borang 5D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listD-ipjpsm',compact('form5D','user','year_list','year','buffer','form5D_kilang', 'returnArr','batch'));
    }

    public function shuttle_5_listD_jpn($year){

        $user = auth()->user();

        $formD_kilang = Form5D::select('shuttle_id')->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
            })->distinct()->where('tahun', $year)->get();

        $form5D = Form5D::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
        })->get();

        // dd($formD_kilang);

        $year_list = Form5D::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->distinct()->orderBy('tahun')->get('tahun');
        $buffer = Buffer::where('borang', 'd')->where('shuttle', '5')->first();


        $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Borang 4D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listD-jpn',compact('returnArr','form5D','user','year_list','year','buffer','formD_kilang'));
    }

    public function ibk_shuttle_5_form5D_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_kumai = JenisKayu::get();

        $form5d = Form5D::findorfail($id);

        $kilang_info = Shuttle::findorfail($form5d->shuttle_id);

        // $form5d = Form5D::where('shuttle_id',$kilang_info->id)->first();
        $id =$form5d->id;


        $form_5d = PengeluaranForm5D::where('form5ds_id',$form5d->id)->get();
        // dd($form_5d);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Borang 5D - PENYATA PENGELUARAN"],
        ];

        $kembali = route('phd.shuttle-5-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-five.view-form5d-ibk',compact('kilang_info','id','form5d','jenis_kumai','form_5d','returnArr'));
    }

    public function jpn_shuttle_5_form5D_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_kumai = JenisKayu::get();

        $form5d = Form5D::findorfail($id);

        $kilang_info = Shuttle::findorfail($form5d->shuttle_id);

        // $form5d = Form5D::where('shuttle_id',$kilang_info->id)->first();
        $id =$form5d->id;


        $form_5d = PengeluaranForm5D::where('form5ds_id',$form5d->id)->get();
        // dd($form_5d);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-5-listD-jpn', date('Y')), 'name' => "Senarai Borang 5D"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Borang 5D"],
        ];

        $kembali = route('phd.shuttle-5-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-five.view-form5d-jpn',compact('kilang_info','id','form5d','jenis_kumai','form_5d','returnArr'));
    }
}
