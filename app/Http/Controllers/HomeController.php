<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\Shuttle;
use App\Models\User;
use App\Models\Buffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_shuttle3 = User::where('shuttle_type', 3)->where('is_approved', 1)->whereNull('pengguna_kilang_id')->count();
        $count_shuttle4 = User::where('shuttle_type', 4)->where('is_approved', 1)->whereNull('pengguna_kilang_id')->count();
        $count_shuttle5 = User::where('shuttle_type', 5)->where('is_approved', 1)->whereNull('pengguna_kilang_id')->count();





        return view('home', compact('count_shuttle3', 'count_shuttle4', 'count_shuttle5'));
    }

    public function ajax_count_user_ibk(){
        $count_ibk = User::where('kategori_pengguna', 'IBK')->where('is_approved', 0)->count();
        return response()->json($count_ibk, 200);
    }

    public function ajax_count_user_phd(){
        $count_phd = User::where('kategori_pengguna', 'PHD')->where('is_approved_ipjpsm', 0)->count();
        return response()->json($count_phd, 200);
    }

    public function ajax_count_user_jpn(){
        $count_ipjpsm = User::where('kategori_pengguna', 'JPN')->where('is_approved_ipjpsm', 0)->count();
        return response()->json($count_ipjpsm, 200);
    }

    public function ajax_count_user_bpe(){
        $count_ipjpsm = User::where('kategori_pengguna', 'BPE')->where('is_approved_ipjpsm', 0)->count();
        return response()->json($count_ipjpsm, 200);
    }

    public function ajax_count_tugasan_ipjpsm_shuttle3()
    {
        $currentYear = date('Y');

        $form3A_count = DB::selectOne('SELECT COUNT(*) as cnt FROM batches, form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            AND (form_a_s.status = "Dihantar ke IPJPSM" OR form_a_s.status = "Lulus")
            WHERE batches.tahun = form_a_s.tahun
            AND batches.shuttle_id = form_a_s.shuttle_id
            AND batches.borang_a = "2"
            AND batches.status = "Dihantar ke IPJPSM"
            AND shuttles.shuttle_type = 3
            AND form_a_s.tahun = ?', [$currentYear])->cnt;

        $form3B_count = DB::selectOne("SELECT COUNT(DISTINCT formbs.id) as cnt FROM formbs
            INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
            AND batches.shuttle_id = formbs.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_b = '2'
            AND shuttles.shuttle_type = '3'
            AND formbs.tahun = ?", [$currentYear])->cnt;

        $form3C_count = DB::selectOne("SELECT COUNT(DISTINCT form_c_s.id) as cnt FROM form_c_s
            INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form_c_s.bulan
            AND batches.status = 'Dihantar ke IPJPSM'
            AND (form_c_s.status = 'Dihantar ke IPJPSM' OR form_c_s.status = 'Lulus')
            AND batches.shuttle_id = form_c_s.shuttle_id
            AND batches.borang_c = '2'
            AND shuttles.shuttle_type = '3'
            AND form_c_s.tahun = ?", [$currentYear])->cnt;

        $form3D_count = DB::selectOne("SELECT COUNT(DISTINCT form_d_s.id) as cnt FROM form_d_s
            INNER JOIN shuttles ON form_d_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form_d_s.bulan
            AND (form_d_s.status = 'Dihantar ke IPJPSM' OR form_d_s.status = 'Lulus')
            AND batches.shuttle_id = form_d_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_d = '2'
            AND shuttles.shuttle_type = '3'
            AND form_d_s.tahun = ?", [$currentYear])->cnt;

        $shuttle3_count = $form3A_count + $form3B_count + $form3C_count + $form3D_count;

        return response()->json($shuttle3_count, 200);
    }



    public function ajax_count_tugasan_ipjpsm_shuttle4()
    {
        $currentYear = date('Y');

        $form4A_count = DB::selectOne('SELECT COUNT(*) as cnt FROM batches, form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE batches.tahun = form_a_s.tahun
            AND batches.shuttle_id = form_a_s.shuttle_id
            AND batches.borang_a = "2"
            AND batches.status = "Dihantar ke IPJPSM"
            AND (form_a_s.status = "Dihantar ke IPJPSM" OR form_a_s.status = "Lulus")
            AND shuttles.shuttle_type = 4
            AND form_a_s.tahun = ?', [$currentYear])->cnt;

        $form4B_count = DB::selectOne("SELECT COUNT(DISTINCT formbs.id) as cnt FROM formbs
            INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = formbs.tahun
            AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
            AND batches.shuttle_id = formbs.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_b = '2'
            AND shuttles.shuttle_type = '4'
            AND formbs.tahun = ?", [$currentYear])->cnt;

        $form4C_count = DB::selectOne("SELECT COUNT(DISTINCT form_c_s.id) as cnt FROM form_c_s
            INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form_c_s.bulan
            AND (form_c_s.status = 'Dihantar ke IPJPSM' OR form_c_s.status = 'Lulus')
            AND batches.shuttle_id = form_c_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_c = '2'
            AND shuttles.shuttle_type = '4'
            AND form_c_s.tahun = ?", [$currentYear])->cnt;

        $form4D_count = DB::selectOne("SELECT COUNT(DISTINCT form4_d_s.id) as cnt FROM form4_d_s
            INNER JOIN shuttles ON form4_d_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form4_d_s.bulan
            AND (form4_d_s.status = 'Dihantar ke IPJPSM' OR form4_d_s.status = 'Lulus')
            AND batches.shuttle_id = form4_d_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_d = '2'
            AND shuttles.shuttle_type = '4'
            AND form4_d_s.tahun = ?", [$currentYear])->cnt;

        $form4E_count = DB::selectOne("SELECT COUNT(DISTINCT form4_e_s.id) as cnt FROM form4_e_s
            INNER JOIN shuttles ON form4_e_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form4_e_s.bulan
            AND (form4_e_s.status = 'Dihantar ke IPJPSM' OR form4_e_s.status = 'Lulus')
            AND batches.shuttle_id = form4_e_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_e = '2'
            AND shuttles.shuttle_type = '4'
            AND form4_e_s.tahun = ?", [$currentYear])->cnt;

        $shuttle4_count = $form4A_count + $form4B_count + $form4C_count + $form4D_count + $form4E_count;

        return response()->json($shuttle4_count, 200);
    }

    public function ajax_count_tugasan_ipjpsm_shuttle5()
    {
        $currentYear = date('Y');

        $form5A_count = DB::selectOne('SELECT COUNT(*) as cnt FROM batches, form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE batches.tahun = form_a_s.tahun
            AND batches.shuttle_id = form_a_s.shuttle_id
            AND batches.borang_a = "2"
            AND batches.status = "Dihantar ke IPJPSM"
            AND (form_a_s.status = "Dihantar ke IPJPSM" OR form_a_s.status = "Lulus")
            AND shuttles.shuttle_type = 5
            AND form_a_s.tahun = ?', [$currentYear])->cnt;

        $form5B_count = DB::selectOne("SELECT COUNT(DISTINCT formbs.id) as cnt FROM formbs
            INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = formbs.tahun
            AND (formbs.status = 'Dihantar ke IPJPSM' OR formbs.status = 'Lulus')
            AND batches.shuttle_id = formbs.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_b = '2'
            AND shuttles.shuttle_type = '5'
            AND formbs.tahun = ?", [$currentYear])->cnt;

        $form5C_count = DB::selectOne("SELECT COUNT(DISTINCT form_c_s.id) as cnt FROM form_c_s
            INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form_c_s.bulan
            AND (form_c_s.status = 'Dihantar ke IPJPSM' OR form_c_s.status = 'Lulus')
            AND batches.shuttle_id = form_c_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_c = '2'
            AND shuttles.shuttle_type = '5'
            AND form_c_s.tahun = ?", [$currentYear])->cnt;

        $form5D_count = DB::selectOne("SELECT COUNT(DISTINCT form5_d_s.id) as cnt FROM form5_d_s
            INNER JOIN shuttles ON form5_d_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form5_d_s.bulan
            AND (form5_d_s.status = 'Dihantar ke IPJPSM' OR form5_d_s.status = 'Lulus')
            AND batches.shuttle_id = form5_d_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_d = '2'
            AND shuttles.shuttle_type = '5'
            AND form5_d_s.tahun = ?", [$currentYear])->cnt;

        $form5E_count = DB::selectOne("SELECT COUNT(DISTINCT form5_e_s.id) as cnt FROM form5_e_s
            INNER JOIN shuttles ON form5_e_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.bulan = form5_e_s.bulan
            AND (form5_e_s.status = 'Dihantar ke IPJPSM' OR form5_e_s.status = 'Lulus')
            AND batches.shuttle_id = form5_e_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND batches.borang_e = '2'
            AND shuttles.shuttle_type = '5'
            AND form5_e_s.tahun = ?", [$currentYear])->cnt;

        $shuttle5_count = $form5A_count + $form5B_count + $form5C_count + $form5D_count + $form5E_count;

        return response()->json($shuttle5_count, 200);
    }

    public function ajax_count_tugasan_ipjpsm_detail(Request $request)
    {
        $currentYear = (int) ($request->year ?? date('Y'));
        $shuttle_type = (int) ($request->shuttle_type ?? 3);

        // Counts distinct factories (shuttle_id) matching exactly what each blade highlights:
        //   - formA: page checks only form_a_s.status (no batch condition in the view)
        //   - formB/C/D/E: page checks form.status + batch.status + batch.borang_x=2, same year

        // formA: annual — no batch condition needed; view highlights purely on form status
        $formA_count = DB::selectOne("SELECT COUNT(DISTINCT form_a_s.shuttle_id) as cnt
            FROM form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE form_a_s.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = ?
            AND form_a_s.tahun = ?", [$shuttle_type, $currentYear])->cnt;

        // formB: quarterly — suku_tahun 1/2/3/4 maps to batch bulan 3/6/9/12, same year
        $formB_count = DB::selectOne("SELECT COUNT(DISTINCT formbs.shuttle_id) as cnt
            FROM formbs
            INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
            INNER JOIN batches ON batches.shuttle_id = formbs.shuttle_id
                AND batches.tahun = formbs.tahun
                AND batches.bulan = (formbs.suku_tahun * 3)
                AND batches.borang_b = '2'
                AND batches.status = 'Dihantar ke IPJPSM'
            WHERE formbs.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = ?
            AND formbs.tahun = ?", [$shuttle_type, $currentYear])->cnt;

        // formC: monthly — batch joined on same year + bulan
        $formC_count = DB::selectOne("SELECT COUNT(DISTINCT form_c_s.shuttle_id) as cnt
            FROM form_c_s
            INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
            INNER JOIN batches ON batches.shuttle_id = form_c_s.shuttle_id
                AND batches.tahun = form_c_s.tahun
                AND batches.bulan = form_c_s.bulan
                AND batches.borang_c = '2'
                AND batches.status = 'Dihantar ke IPJPSM'
            WHERE form_c_s.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = ?
            AND form_c_s.tahun = ?", [$shuttle_type, $currentYear])->cnt;

        if ($shuttle_type == 4) { $tableD = 'form4_d_s'; } elseif ($shuttle_type == 5) { $tableD = 'form5_d_s'; } else { $tableD = 'form_d_s'; }
        $formD_count = DB::selectOne("SELECT COUNT(DISTINCT {$tableD}.shuttle_id) as cnt
            FROM {$tableD}
            INNER JOIN shuttles ON {$tableD}.shuttle_id = shuttles.id
            INNER JOIN batches ON batches.shuttle_id = {$tableD}.shuttle_id
                AND batches.tahun = {$tableD}.tahun
                AND batches.bulan = {$tableD}.bulan
                AND batches.borang_d = '2'
                AND batches.status = 'Dihantar ke IPJPSM'
            WHERE {$tableD}.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = ?
            AND {$tableD}.tahun = ?", [$shuttle_type, $currentYear])->cnt;

        $result = [
            'formA' => $formA_count,
            'formB' => $formB_count,
            'formC' => $formC_count,
            'formD' => $formD_count,
        ];

        if ($shuttle_type >= 4) {
            $tableE = $shuttle_type === 4 ? 'form4_e_s' : 'form5_e_s';
            $result['formE'] = DB::selectOne("SELECT COUNT(DISTINCT {$tableE}.shuttle_id) as cnt
                FROM {$tableE}
                INNER JOIN shuttles ON {$tableE}.shuttle_id = shuttles.id
                INNER JOIN batches ON batches.shuttle_id = {$tableE}.shuttle_id
                    AND batches.tahun = {$tableE}.tahun
                    AND batches.bulan = {$tableE}.bulan
                    AND batches.borang_e = '2'
                    AND batches.status = 'Dihantar ke IPJPSM'
                WHERE {$tableE}.status = 'Dihantar ke IPJPSM'
                AND shuttles.shuttle_type = ?
                AND {$tableE}.tahun = ?", [$shuttle_type, $currentYear])->cnt;
        }

        return response()->json($result, 200);
    }

    public function index_bpm()
    {
        $count_shuttle3 = User::where('shuttle_type', 3)->where('is_approved', 1)->count();
        $count_shuttle4 = User::where('shuttle_type', 4)->where('is_approved', 1)->count();
        $count_shuttle5 = User::where('shuttle_type', 5)->where('is_approved', 1)->count();

        return view('home-bpm', compact('count_shuttle3', 'count_shuttle4', 'count_shuttle5'));
    }


        //borang keseluruhan SHUTTLE 3
    public function shuttle_3_keseluruhan_borang_A($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle3.borangA', config('app.data_start_year'));

        // $form_a = FormA::where('tahun', $year)
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->get();

        $form_a = FormA::where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', '3');
        })
        ->with('shuttle')
        ->get();

        $year_list = FormA::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $batch = Batch::where('tahun', $year)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y')), 'name' => "Borang 3A"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle3_borangA', compact('returnArr','year', 'form_a', 'year_list','batch'));
    }

    public function shuttle_3_keseluruhan_borang_B($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle3.borangB', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '3')->get();

        $formB = FormB::where('tahun', $year)->get();

        $year_list = FormB::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();


        $batch = Batch::where('tahun', $year)->get();

        $formBIndex = [];
        foreach ($formB as $item) { $formBIndex[$item->shuttle_id][$item->suku_tahun] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y')), 'name' => "
             Borang 3B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle3_borangB', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formBIndex', 'batchIndex'));
    }

    public function shuttle_3_keseluruhan_borang_C($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle3.borangC', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '3')->get();

        $formC = FormC::where('tahun', $year)->get();

        $year_list = FormC::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'c')->where('shuttle', '3')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y')), 'name' => "Borang 3C"],
        ];

        $kembali = route('home');
        $batch = Batch::where('tahun', $year)->get();

        $formCIndex = [];
        foreach ($formC as $item) { $formCIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle3_borangC', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formCIndex', 'batchIndex'));
    }

    public function shuttle_3_keseluruhan_borang_D($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle3.borangD', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '3')->get();

        $formD = FormD::where('tahun', $year)->get();

        $year_list = FormD::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '3')->first();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y')), 'name' => "Borang 3D"],
        ];

        $kembali = route('home');
        $batch = Batch::where('tahun', $year)->get();

        $formDIndex = [];
        foreach ($formD as $item) { $formDIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle3_borangD', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formDIndex', 'batchIndex'));
    }

       //borang keseluruhan SHUTTLE 4
       public function shuttle_4_keseluruhan_borang_A($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle4.borangA', config('app.data_start_year'));

        $form_a = FormA::where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', '4');
        })
        ->with('shuttle')
        ->get();

        // dd($form_a);

        $year_list = FormA::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y')), 'name' => "Borang 4A"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle4_borangA', compact('returnArr','year', 'form_a', 'year_list'));
    }

    public function shuttle_4_keseluruhan_borang_B($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle4.borangB', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $formB = FormB::where('tahun', $year)->get();

        $year_list = FormB::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();
        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "
            Borang 4B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $formBIndex = [];
        foreach ($formB as $item) { $formBIndex[$item->shuttle_id][$item->suku_tahun] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle4_borangB', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formBIndex', 'batchIndex'));
    }

    public function shuttle_4_keseluruhan_borang_C($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle4.borangC', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $formC = FormC::where('tahun', $year)->get();

        $year_list = FormC::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'c')->where('shuttle', '4')->first();

        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Borang 4C"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $formCIndex = [];
        foreach ($formC as $item) { $formCIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle4_borangC', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formCIndex', 'batchIndex'));
    }

    public function shuttle_4_keseluruhan_borang_D($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle4.borangD', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $form4D = Form4D::where('tahun', $year)->get();

        $year_list = Form4D::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '4')->first();

        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Borang 4D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $form4DIndex = [];
        foreach ($form4D as $item) { $form4DIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle4_borangD', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'form4DIndex', 'batchIndex'));
    }

    public function shuttle_4_keseluruhan_borang_E($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle4.borangE', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $form4E = Form4E::where('tahun', $year)->get();

        $year_list = Form4E::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'e')->where('shuttle', '4')->first();

        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $form4EIndex = [];
        foreach ($form4E as $item) { $form4EIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle4_borangE', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'form4EIndex', 'batchIndex'));
    }

    //borang keseluruhan SHUTTLE 5
    public function shuttle_5_keseluruhan_borang_A($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle5.borangA', config('app.data_start_year'));

        $form_a = FormA::where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', '5');
        })
        ->with('shuttle')
        ->get();
        //   dd($form_a);

        // $form_a = DB::select(DB::raw("SELECT *, form_a_s.status as 'form_a_status' FROM `form_a_s`
        // inner join `batches`
        // on `form_a_s`.`shuttle_id` = `batches`.`shuttle_id`
        // where form_a_s.`tahun` = '2022'
        // and
        // exists (select *
        //     from `shuttles`
        //     where `form_a_s`.`shuttle_id` = `shuttles`.`id`
        //     and `shuttle_type` = '5')
        // AND `batches`.`borang_a` = '2'
        // AND `batches`.`status` = 'Sedang Diproses'"));
        //   dd($form_a);
        $year_list = FormA::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y')), 'name' => "Borang 5A"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // dd($batch);

        return view('admins.borangKeseluruhan.shuttle5_borangA', compact('returnArr','year', 'form_a', 'year_list'));
    }

    public function shuttle_5_keseluruhan_borang_B($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle5.borangB', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $formB = FormB::where('tahun', $year)->get();

        $year_list = FormB::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '5')->first();

        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')), 'name' => "
            Borang 5B"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $formBIndex = [];
        foreach ($formB as $item) { $formBIndex[$item->shuttle_id][$item->suku_tahun] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle5_borangB', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formBIndex', 'batchIndex'));
    }

    public function shuttle_5_keseluruhan_borang_C($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle5.borangC', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $formC = FormC::where('tahun', $year)->get();

        $year_list = FormC::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'c')->where('shuttle', '5')->first();
        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')), 'name' => "Borang 5C"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $formCIndex = [];
        foreach ($formC as $item) { $formCIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle5_borangC', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'formCIndex', 'batchIndex'));
    }

    public function shuttle_5_keseluruhan_borang_D($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle5.borangD', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $form5D = Form5D::where('tahun', $year)->get();

        $year_list = Form5D::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '5')->first();
        $batch = Batch::where('tahun', $year)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')), 'name' => "Borang 5D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $form5DIndex = [];
        foreach ($form5D as $item) { $form5DIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle5_borangD', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'form5DIndex', 'batchIndex'));
    }

    public function shuttle_5_keseluruhan_borang_E($year){
        if ($year < config('app.data_start_year')) return redirect()->route('ipjpsm.borang-keseluruhan.shuttle5.borangE', config('app.data_start_year'));
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $form5E = Form5E::where('tahun', $year)->get();

        $year_list = Form5E::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'e')->where('shuttle', '5')->first();

        $batch = Batch::where('tahun', $year)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $form5EIndex = [];
        foreach ($form5E as $item) { $form5EIndex[$item->shuttle_id][$item->bulan] = $item; }
        $batchIndex = [];
        foreach ($batch as $b) { $batchIndex[$b->shuttle_id][$b->bulan] = $b; }

        return view('admins.borangKeseluruhan.shuttle5_borangE', compact('returnArr', 'year', 'list_kilang', 'buffer', 'year_list', 'form5EIndex', 'batchIndex'));
    }

    private function buildGraphData(int $shuttle_type, int $year = 0): array
    {
        if ($year <= 0) $year = (int) date('Y');
        // System-wide reset point: never chart data older than the start year.
        $year = max($year, (int) config('app.data_start_year'));

        $rows = DB::select("SELECT shuttles.negeri_id, COUNT(DISTINCT form_a_s.shuttle_id) as total_kilang
            FROM form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE shuttles.shuttle_type = ?
            AND form_a_s.tahun = ?
            GROUP BY shuttles.negeri_id", [$shuttle_type, $year]);

        $byNegeri = collect($rows)->keyBy('negeri_id');

        return [
            'year'       => $year,
            'johor'      => optional($byNegeri->get('Johor'))->total_kilang ?? 0,
            'kedah'      => optional($byNegeri->get('Kedah'))->total_kilang ?? 0,
            'kelantan'   => optional($byNegeri->get('Kelantan'))->total_kilang ?? 0,
            'melaka'     => optional($byNegeri->get('Melaka'))->total_kilang ?? 0,
            'n9'         => optional($byNegeri->get('Negeri Sembilan'))->total_kilang ?? 0,
            'pahang'     => optional($byNegeri->get('Pahang'))->total_kilang ?? 0,
            'perak'      => optional($byNegeri->get('Perak'))->total_kilang ?? 0,
            'perlis'     => optional($byNegeri->get('Perlis'))->total_kilang ?? 0,
            'pinang'     => optional($byNegeri->get('Pulau Pinang'))->total_kilang ?? 0,
            'selangor'   => optional($byNegeri->get('Selangor'))->total_kilang ?? 0,
            'terengganu' => optional($byNegeri->get('Terengganu'))->total_kilang ?? 0,
            'wp'         => optional($byNegeri->get('W.P Kuala Lumpur'))->total_kilang ?? 0,
        ];
    }

    public function graph_dashboard_default()
    {
        return response($this->buildGraphData(3), 200);
    }

    public function graph_dashboard(Request $request)
    {
        $shuttle_type = (int) ($request->shuttle_type ?? 3);
        $year = (int) ($request->year ?? date('Y'));
        return response($this->buildGraphData($shuttle_type, $year), 200);
    }
}
