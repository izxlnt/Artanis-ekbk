<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\Shuttle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListBController extends Controller
{
    public $shuttle_listB;

    public function shuttle_3_listB_phd($year)
    {



        $user = auth()->user();

        $formB_kilang = FormB::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->distinct()->where('tahun', $year)->get();

        $formB = FormB::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '3');
         })->where('tahun', $year)->get();

         $year_list = FormB::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '3');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();

         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listB',compact('user','formB', 'formB_kilang', 'year_list','year','buffer','returnArr'));
    }

    public function shuttle_3_listB_jpn($year)
    {
        $user = auth()->user();

        $formB_kilang = FormB::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '3');
        })
        ->distinct()->where('tahun', $year)->get();

        $formB = FormB::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '3');
         })->where('tahun', $year)->get();

         $year_list = FormB::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '3');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();


         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Borang 3B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listB-jpn',compact('returnArr','user','formB', 'formB_kilang', 'year_list','year','buffer'));
    }

    public function shuttle_3_listB_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );
        $formB_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM formbs
        INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = formbs.tahun
        AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
        AND batches.shuttle_id = formbs.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '3'
        AND formbs.tahun = $year"));

    //     $formB_kilang = FormB::with('shuttle')->select('shuttle_id')
    //     ->whereHas('shuttle', function ($q) {
    //         $q->where('shuttle_type', '3');
    //     })
    //    ->distinct()->where('tahun', $year)->get();

    //    dd($formB_kilang);

        // $formB = FormB::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();



        // $formB = DB::select(DB::raw("SELECT formbs.*, batches.status as BatchStatus, batches.bulan,
        // ( CASE WHEN formbs.suku_tahun = '1' THEN '1-3' WHEN formbs.suku_tahun = '2' THEN '4-6' WHEN formbs.suku_tahun = '3' THEN '7-9' ELSE '10-12' END)
        // AS bulanrange
        // FROM batches, formbs
        // WHERE batches.tahun = formbs.tahun
        // AND (formbs.status = 'Dihantar ke IPJPSM'
        // OR formbs.status = 'Lulus')
        // AND batches.shuttle_id = formbs.shuttle_id
        // AND batches.status = 'Dihantar ke IPJPSM'
        // AND bulan = batches.bulan"));

        $formB = FormB::where('tahun', $year)->where('shuttle_type', '3')->get();

        // dd($formB);

        // $year_list = DB::select(DB::raw("SELECT DISTINCT formbs.tahun, batches.status as BatchStatus, batches.bulan,
        // ( CASE WHEN formbs.suku_tahun = '1' THEN '1-3' WHEN formbs.suku_tahun = '2' THEN '4-6' WHEN formbs.suku_tahun = '3' THEN '7-9' ELSE '10-12' END)
        // AS bulanrange
        // FROM batches, formbs
        // WHERE batches.tahun = formbs.tahun
        // AND (formbs.status = 'Dihantar ke IPJPSM'
        // OR formbs.status = 'Lulus')
        // AND batches.shuttle_id = formbs.shuttle_id
        // AND batches.status = 'Dihantar ke IPJPSM'
        // AND bulan = batches.bulan"));

        $year_list = DB::select(DB::raw("SELECT DISTINCT formbs.tahun FROM formbs
        INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = formbs.tahun
        AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
        AND batches.shuttle_id = formbs.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '3'
        "));

        //  $year_list = FormB::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();

        $batch = Batch::get();

        //  $formB = DB::select(DB::raw('SELECT formbs.* FROM batches, formbs WHERE batches.tahun = formbs.tahun AND batches.bulan = formbs.bulan AND batches.shuttle_id = formbs.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));

        //  dd($formB);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        // $shuttle_listB = Shuttle::where('shuttle_type', '3')->paginate(10);
        return view('admins.shuttle-three.shuttle-3-listB-ipjpsm',compact('returnArr','user','formB', 'formB_kilang', 'year_list','year','buffer','batch'));
    }

    public function shuttle_3_listB_bpm()
    {
        $user = auth()->user();

        $shuttle_listB = Shuttle::where('shuttle_type', '3')->paginate(10);


        $breadcrumbs    = [
            ['link' => route('home-bpm'), 'name' => "Laman Utama"],
            ['link' => route('bpm.shuttle-3-listB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('bpm.shuttle-3-listB', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('bpm.shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('bpm.shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],
        ];

        $kembali = route('home-bpm');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];






        return view('bpe.shuttle-three.shuttle-3-listB',compact('returnArr','shuttle_listB','user'));
    }
}
