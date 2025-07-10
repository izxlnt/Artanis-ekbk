<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\FormB as ModelsFormB;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListBController extends Controller
{
    public $shuttle_listB;
    public function shuttle_5_listB_ipjpsm($year)
    {



        // $breadcrumbs    = [
        //     ['link' => route('home'), 'name' => "Laman Utama"],
        //     ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Perakuan Maklumat"],
        // ];

        // $kembali = route('home');

        // $returnArr = [
        //     'breadcrumbs' => $breadcrumbs,
        //     'kembali'     => $kembali,
        // ];

        $user = auth()->user();
        // dd($user );
        $formB_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM formbs
            INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = formbs.tahun
            AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
            AND batches.shuttle_id = formbs.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '5'
            AND formbs.tahun = $year"));

        $formB = ModelsFormB::where('tahun', $year)->where('shuttle_type', '5')->get();

        $year_list = DB::select(DB::raw("SELECT DISTINCT formbs.tahun FROM formbs
            INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = formbs.tahun
            AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
            AND batches.shuttle_id = formbs.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '5'
            AND formbs.tahun = $year"));

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '5')->first();
        $batch = Batch::get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Senarai Borang 5B"],
        ];

        $kembali = route('home');


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listB-ipjpsm', compact('returnArr', 'user', 'formB', 'formB_kilang', 'year_list', 'year', 'buffer', 'batch'));
    }

    public function shuttle_5_listB_jpn($year)
    {
        $user = auth()->user();


        $formB_kilang = ModelsFormB::select('shuttle_id')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
            })
            ->distinct()->where('tahun', $year)->get();

        $formB = ModelsFormB::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
        })->where('tahun', $year)->get();

        $year_list = ModelsFormB::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '5');
        })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '5')->first();

        // dd($formB_kilang);
        $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Borang 5B"],
        ];

        $kembali = route('home-jpn');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-five.shuttle-5-listB-jpn', compact('returnArr', 'user', 'formB', 'formB_kilang', 'year_list', 'year', 'buffer'));
    }
}
