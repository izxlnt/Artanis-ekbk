<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormB;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListBController extends Controller
{
    public $shuttle_listB;

    public function shuttle_4_listB($year)
    {
        $user = auth()->user();

        $formB_kilang = FormB::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->distinct()->where('tahun', $year)->get();

        // dd($formB_kilang);

        $formB = FormB::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '4');
         })->where('tahun', $year)->get();

         $year_list = FormB::whereHas('shuttle', function($q){
            $q->where('daerah_id',auth()->user()->daerah)->where('shuttle_type', '4');
         })->distinct()->orderBy('tahun')->get('tahun');

        //  dd($formB);
         $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();

         $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Senarai Borang 4B"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listB-phd',compact('user','formB', 'formB_kilang', 'year_list','year','buffer','returnArr'));
    }

    public function shuttle_4_listB_ipjpsm($year)
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
        AND shuttles.shuttle_type = '4'
        AND formbs.tahun = $year"));


        $breadcrumbs    = [
        ['link' => route('home'), 'name' => "Laman Utama"],
        ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
        ];

        $formB = FormB::where('tahun', $year)->where('shuttle_type', '4')->get();



        $year_list = DB::select(DB::raw("SELECT DISTINCT formbs.tahun FROM formbs
        INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = formbs.tahun
        AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
        AND batches.shuttle_id = formbs.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '4'"));



        $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();
        $batch = Batch::get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Senarai Borang 4B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        // $shuttle_listB = Shuttle::where('shuttle_type', '3')->paginate(10);
        return view('admins.shuttle-four.shuttle-4-listB-ipjpsm',compact('returnArr', 'user','formB', 'formB_kilang', 'year_list','year','buffer','batch'));

    }

    public function shuttle_4_listB_jpn($year){
        $user = auth()->user();

        $formB_kilang = FormB::select('shuttle_id')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        })
        ->distinct()->where('tahun', $year)->get();

        $formB = FormB::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '4');
         })->where('tahun', $year)->get();

         $year_list = FormB::whereHas('shuttle', function($q){
            $q->where('negeri_id',auth()->user()->negeri)->where('shuttle_type', '4');
         })->distinct()->orderBy('tahun')->get('tahun');

         $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();


         $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Borang 4B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listB-jpn',compact('returnArr','user','formB', 'formB_kilang', 'year_list','year','buffer'));
    }


}
