<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormD;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListDController extends Controller
{
    public $shuttle_listD;
    public function shuttle_3_listD_phd($year)
    {
        $user=auth()->user();

        $formD_kilang = FormD::select('shuttle_id')->
        whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })->
        distinct()->where('tahun', $year)->get();

        $formD = FormD::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '3');
         })->where('tahun', $year)->get();


         $year_list = FormD::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah);
         })->distinct()->orderBy('tahun')->get('tahun');
         $buffer = Buffer::where('borang', 'd')->where('shuttle', '3')->first();

        // dd($year_list);

         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listD',compact('formD','user','year_list','year','buffer','formD_kilang','returnArr'));
    }

    public function shuttle_3_listD_jpn($year)
    {
        $user=auth()->user();

        $formD_kilang = FormD::select('shuttle_id')->
        whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '3');
        })->
        distinct()->where('tahun', $year)->get();

        $formD = FormD::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '3');
         })->where('tahun', $year)->get();

         $year_list = FormD::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri);
         })->distinct()->orderBy('tahun')->get('tahun');
         $buffer = Buffer::where('borang', 'd')->where('shuttle', '3')->first();


         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Borang 3D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listD-jpn',compact('returnArr','formD','user','year_list','year','buffer','formD_kilang'));
    }

    public function shuttle_3_listD_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );

        // $formD_kilang = FormD::select('shuttle_id')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->distinct()->where('tahun', $year)->get();

        $formD_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM form_d_s
        INNER JOIN shuttles ON form_d_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_d_s.tahun
        AND (form_d_s.status = 'Dihantar ke IPJPSM' OR form_d_s.status = 'Lulus')
        AND batches.shuttle_id = form_d_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '3'
        AND form_d_s.tahun = $year"));
        // $formD = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();
        // $formD = DB::select(DB::raw('SELECT form_d_s.* FROM batches, form_d_s WHERE batches.tahun = form_d_s.tahun AND batches.bulan = form_d_s.bulan AND batches.shuttle_id = form_d_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
        $formD = FormD::where('tahun', $year)->where('shuttle_type', '3')->get();

            // dd($formD);

            $year_list = DB::select(DB::raw("SELECT DISTINCT form_d_s.tahun FROM form_d_s
            INNER JOIN shuttles ON form_d_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = form_d_s.tahun
            AND (form_d_s.status = 'Dihantar ke IPJPSM' OR form_d_s.status = 'Lulus')
            AND batches.shuttle_id = form_d_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '3'"));

        //  $year_list = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '3')->first();

        $batch = Batch::get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.shuttle-three.shuttle-3-listD-ipjpsm',compact('returnArr','formD','user','year_list','year','buffer','formD_kilang', 'batch'));
    }

    public function shuttle_3_listD_bpm()
    {
        $user=auth()->user();
        $formD = FormD::where('status','Dihantar ke IPJPSM')->paginate(10);


        $breadcrumbs    = [
            ['link' => route('home-bpm'), 'name' => "Laman Utama"],
            ['link' => route('bpm.shuttle-3-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('bpm.shuttle-3-listD', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('bpm.shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('bpm.shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],
        ];

        $kembali = route('home-bpm');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];






        return view('admins.shuttle-three.shuttle-3-listD',compact('returnArr','formD','user'));
    }
}
