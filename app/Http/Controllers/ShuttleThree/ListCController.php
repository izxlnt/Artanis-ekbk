<?php

namespace App\Http\Controllers\ShuttleThree;

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
    public function shuttle_3_listC_phd($year)
    {
        $user=auth()->user();
        // $shuttle_listC = Shuttle::where('shuttle_type', '3')->paginate(10);
        $formC_kilang = FormC::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->distinct()->where('tahun', $year)->get();

        $formC = FormC::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '3');
         })->where('tahun', $year)->get();

         $year_list = FormC::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '3');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'c')->where('shuttle', '3')->first();


         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listC',compact('formC','user','year_list','year','buffer','formC_kilang','returnArr'));
    }

    public function shuttle_3_listC_jpn($year)
    {
        $user=auth()->user();
        // $shuttle_listC = Shuttle::where('shuttle_type', '3')->paginate(10);
        $formC_kilang = FormC::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '3');
        })
        ->distinct()->where('tahun', $year)->get();

        $formC = FormC::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '3');
         })->where('tahun', $year)->get();

         $year_list = FormC::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '3');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'c')->where('shuttle', '3')->first();

         $breadcrumbs    = [

            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Borang 3C"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listC-jpn',compact('returnArr','formC','user','year_list','year','buffer','formC_kilang'));
    }

    public function shuttle_3_listC_ipjpsm($year)
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
        AND shuttles.shuttle_type = '3'
        AND form_c_s.tahun = $year"));

        // dd($formC_kilang);

        // $formC = FormC::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();

        // $formC = DB::select(DB::raw('SELECT form_c_s.* FROM batches, form_c_s WHERE batches.tahun = form_c_s.tahun AND batches.bulan = form_c_s.bulan AND batches.shuttle_id = form_c_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
            // dd($formC);

        $formC = FormC::where('tahun', $year)->where('shuttle_type', '3')->get();

        $year_list = DB::select(DB::raw("SELECT DISTINCT form_c_s.tahun FROM form_c_s
        INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_c_s.tahun
        AND (form_c_s.status = 'Dihantar ke IPJPSM' OR form_c_s.status = 'Lulus')
        AND batches.shuttle_id = form_c_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '3'
        "));

        // dd($year_list);


        //  $year_list = FormC::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'c')->where('shuttle', '3')->first();

         $batch = Batch::get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        // dd($formC);
        return view('admins.shuttle-three.shuttle-3-listC-ipjpsm',compact('returnArr','user','formC', 'formC_kilang', 'year_list','year','buffer','batch'));
    }

    public function shuttle_3_listC_bpm()
    {
        $user=auth()->user();
        // $shuttle_listC = Shuttle::where('shuttle_type', '3')->paginate(10);

        $formC = FormC::where('status','Dihantar ke IPJPSM')->paginate(10);

        $breadcrumbs    = [
            ['link' => route('home-bpm'), 'name' => "Laman Utama"],
            ['link' => route('bpm.shuttle-3-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('bpm.shuttle-3-listC', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('bpm.shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('bpm.shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],

        ];

        $kembali = route('home-bpm');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];





        return view('admins.shuttle-three.shuttle-3-listC',compact('returnArr','formC','user'));
    }
}
