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
use App\Models\Spesis;
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
        $users = User::get();
        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->get();
        $count_shuttle3 = $user3->count();

        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->get();
        $count_shuttle4 = $user4->count();

        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->get();

        $count_shuttle5 = $user5->count();





        return view('home',compact('users',
        'count_shuttle3',
        'count_shuttle4',
        'count_shuttle5'));
    }

    public function ajax_count_user_ibk(){
        $user = User::where('kategori_pengguna','IBK')->where('is_approved', 0)->get();
        $count_ibk = $user->count();

        return response()->json($count_ibk, 200);
    }

    public function ajax_count_user_phd(){
        $user = User::where('kategori_pengguna','PHD')->where('is_approved_ipjpsm', 0)->get();
        $count_phd = $user->count();

        return response()->json($count_phd, 200);
    }

    public function ajax_count_user_jpn(){
        $user = User::where('kategori_pengguna','JPN')->where('is_approved_ipjpsm', 0)->get();
        $count_ipjpsm = $user->count();

        return response()->json($count_ipjpsm, 200);
    }

    public function ajax_count_user_bpe(){
        $user = User::where('kategori_pengguna','BPE')->where('is_approved_ipjpsm', 0)->get();
        $count_ipjpsm = $user->count();

        return response()->json($count_ipjpsm, 200);
    }

    public function ajax_count_tugasan_ipjpsm_shuttle3()
    {

        $form3A = DB::select(DB::raw('SELECT form_a_s.* FROM batches, form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        AND (form_a_s.status = "Dihantar ke IPJPSM")
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"
        AND shuttles.shuttle_type = 3'));

// dd($form3A);

        if(empty($form3A)){
            $form3A_count = 0;
        }else{
            $form3A_count = count($form3A);
        }
        // dd($form3A_count);


        $form3B = DB::select(DB::raw("SELECT DISTINCT formbs.* FROM formbs
        INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        AND (formbs.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = formbs.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_b = '2'
        AND shuttles.shuttle_type = '3'"));

        if(empty($form3B)){
            $form3B_count = 0;
        }else{
            $form3B_count = count($form3B);
        }

        // dd($form3B);
        $form3C = DB::select(DB::raw("SELECT DISTINCT  form_c_s.* FROM form_c_s
        INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form_c_s.bulan
        AND batches.status = 'Dihantar ke IPJPSM'
        AND form_c_s.status = 'Dihantar ke IPJPSM'
        AND batches.shuttle_id = form_c_s.shuttle_id
        AND batches.borang_c = '2'
        AND shuttles.shuttle_type = '3'"));

        if(empty($form3C)){
            $form3C_count = 0;
        }else{
            $form3C_count = count($form3C);
        }

        $form3D = DB::select(DB::raw("SELECT DISTINCT  form_d_s.* FROM form_d_s
        INNER JOIN shuttles ON form_d_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form_d_s.bulan
        AND form_d_s.status = 'Dihantar ke IPJPSM'
        AND batches.shuttle_id = form_d_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_d = '2'
        AND shuttles.shuttle_type = '3'"));

        if(empty($form3D)){
            $form3D_count = 0;
        }else{
            $form3D_count = count($form3D);
        }

        $shuttle3_count = ($form3B_count + $form3C_count + $form3D_count + $form3A_count);

        return response()->json($shuttle3_count, 200);
    }



    public function ajax_count_tugasan_ipjpsm_shuttle4()
    {


        $formA = DB::select(DB::raw('SELECT form_a_s.* FROM batches, form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"
        AND (form_a_s.status = "Dihantar ke IPJPSM")

        AND shuttles.shuttle_type = 4'));


        if(empty($formA)){
            $form4A_count = 0;
        }else{
            $form4A_count = count($formA);
        }

        $formB = DB::select(DB::raw("SELECT DISTINCT formbs.* FROM formbs
        INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = formbs.tahun
        AND (formbs.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = formbs.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_b = '2'
        AND shuttles.shuttle_type = '4'"));

        if(empty($formB)){
            $form4B_count = 0;
        }else{
            $form4B_count = count($formB);
        }

        $formC = DB::select(DB::raw("SELECT DISTINCT form_c_s.* FROM form_c_s
        INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form_c_s.bulan
        AND (form_c_s.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = form_c_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_c = '2'
        AND shuttles.shuttle_type = '4'"));

        if(empty($formC)){
            $form4C_count = 0;
        }else{
            $form4C_count = count($formC);
        }

        $formD = DB::select(DB::raw("SELECT DISTINCT form4_d_s.* FROM form4_d_s
        INNER JOIN shuttles ON form4_d_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form4_d_s.bulan
        AND form4_d_s.status = 'Dihantar ke IPJPSM'
        AND batches.shuttle_id = form4_d_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_d = '2'
        AND shuttles.shuttle_type = '4'"));

        if(empty($formD)){
            $form4D_count = 0;
        }else{
            $form4D_count = count($formD);
        }

        $formE = DB::select(DB::raw("SELECT DISTINCT form4_e_s.* FROM form4_e_s
        INNER JOIN shuttles ON form4_e_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form4_e_s.bulan
        AND (form4_e_s.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = form4_e_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_e = '2'
        AND shuttles.shuttle_type = '4'"));

        if(empty($formE)){
            $form4E_count = 0;
        }else{
            $form4E_count = count($formE);
        }

        $shuttle4_count = $form4B_count + $form4C_count + $form4D_count + $form4A_count + $form4E_count;

        return response()->json($shuttle4_count, 200);
    }

    public function ajax_count_tugasan_ipjpsm_shuttle5()
    {

        $formA = DB::select(DB::raw('SELECT form_a_s.* FROM batches, form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"
        AND (form_a_s.status = "Dihantar ke IPJPSM")
        AND shuttles.shuttle_type = 5'));

        if(empty($formA)){
            $form5A_count = 0;
        }else{
            $form5A_count = count($formA);
        }


        $formB = DB::select(DB::raw("SELECT DISTINCT formbs.* FROM formbs
        INNER JOIN shuttles ON formbs.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = formbs.tahun
        AND (formbs.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = formbs.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_b = '2'
        AND shuttles.shuttle_type = '5'"));

        if(empty($formB)){
            $form5B_count = 0;
        }else{
            $form5B_count = count($formB);
        }

        // dd($form5B_count);

        $formC = DB::select(DB::raw("SELECT DISTINCT form_c_s.* FROM form_c_s
        INNER JOIN shuttles ON form_c_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form_c_s.bulan
        AND (form_c_s.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = form_c_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_c = '2'
        AND shuttles.shuttle_type = '5'"));

        if(empty($formC)){
            $form5C_count = 0;
        }else{
            $form5C_count = count($formC);
        }
        // dd($form5C_count);


        $formD = DB::select(DB::raw("SELECT DISTINCT form5_d_s.* FROM form5_d_s
        INNER JOIN shuttles ON form5_d_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form5_d_s.bulan
        AND form5_d_s.status = 'Dihantar ke IPJPSM'
        AND batches.shuttle_id = form5_d_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_d = '2'
        AND shuttles.shuttle_type = '5'"));

        if(empty($formD)){
            $form5D_count = 0;
        }else{
            $form5D_count = count($formD);
        }


        $formE = DB::select(DB::raw("SELECT DISTINCT form5_e_s.* FROM form5_e_s
        INNER JOIN shuttles ON form5_e_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.bulan = form5_e_s.bulan
        AND (form5_e_s.status = 'Dihantar ke IPJPSM')
        AND batches.shuttle_id = form5_e_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND batches.borang_e = '2'
        AND shuttles.shuttle_type = '5'"));

        if(empty($formE)){
            $form5e_count = 0;
        }else{
            $form5e_count = count($formE);
        }

        // dd($form5e_count);

        $shuttle5_count = $form5B_count + $form5C_count + $form5D_count + $form5A_count + $form5e_count;

        return response()->json($shuttle5_count, 200);
    }

    public function index_bpm()
    {
        $spesis_aktif= Spesis::get();
        $shuttle = FormB::where('status','Dihantar ke IPJPSM')->get();

        $tidak_lengkap = FormB::where('status','Tidak Lengkap')->get();



        $users= User::get();

        foreach($users as $data){
            $shuttles[] = Shuttle::where('no_ssm',$data->login_id)->get();
        }

        $user3 = User::where('shuttle_type',3)->where('is_approved',1)->get();
        $count_shuttle3 = $user3->count();

        $user4 = User::where('shuttle_type',4)->where('is_approved',1)->get();
        $count_shuttle4 = $user4->count();

        $user5 = User::where('shuttle_type',5)->where('is_approved',1)->get();
        $count_shuttle5 = $user5->count();
        // dd($count);


        return view('home-bpm',compact('spesis_aktif','shuttle','users','count_shuttle3','count_shuttle4','count_shuttle5','tidak_lengkap'));
    }


        //borang keseluruhan SHUTTLE 3
    public function shuttle_3_keseluruhan_borang_A($year){

        // $form_a = FormA::where('tahun', $year)
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->get();

        $form_a = FormA::where('form_a_s.tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', '3');
        })->leftJoin('batches', function($join) {
            $join->on('form_a_s.shuttle_id', '=', 'batches.shuttle_id');
        })->where('batches.borang_a', '2')
        ->select('batches.status as batches_status', 'form_a_s.*')
        ->get();

        $year_list = FormA::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $batch = Batch::get();

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

        $list_kilang = Shuttle::where('shuttle_type', '3')->get();

        $formB = FormB::where('tahun', $year)->get();

        $year_list = FormB::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();


        $batch = Batch::get();

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

        return view('admins.borangKeseluruhan.shuttle3_borangB', compact('returnArr', 'year','list_kilang', 'formB', 'buffer', 'year_list','batch'));
    }

    public function shuttle_3_keseluruhan_borang_C($year){
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
        $batch = Batch::get();

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle3_borangC', compact('returnArr','year','list_kilang', 'formC', 'buffer', 'year_list','batch'));
    }

    public function shuttle_3_keseluruhan_borang_D($year){
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
        $batch=Batch::get();

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.borangKeseluruhan.shuttle3_borangD', compact('returnArr','year','list_kilang', 'formD', 'buffer', 'year_list','batch'));
    }

       //borang keseluruhan SHUTTLE 4
       public function shuttle_4_keseluruhan_borang_A($year){

        $form_a = FormA::where('form_a_s.tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', '4');
        })->leftJoin('batches', function($join) {
            $join->on('form_a_s.shuttle_id', '=', 'batches.shuttle_id');
        })->where('batches.borang_a', '2')
        ->select('batches.status as batches_status', 'form_a_s.*')
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

        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $formB = FormB::where('tahun', $year)->get();

        $year_list = FormB::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '4')->first();
        $batch = Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle4_borangB', compact('returnArr', 'year','list_kilang', 'formB', 'buffer', 'year_list','batch'));
    }

    public function shuttle_4_keseluruhan_borang_C($year){
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $formC = FormC::where('tahun', $year)->get();

        $year_list = FormC::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'c')->where('shuttle', '4')->first();

        $batch=Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle4_borangC', compact('returnArr','year','list_kilang', 'formC', 'buffer', 'year_list','batch'));
    }

    public function shuttle_4_keseluruhan_borang_D($year){
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $form4D = Form4D::where('tahun', $year)->get();

        $year_list = Form4D::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '4')->first();

        $batch = Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle4_borangD', compact('returnArr','year','list_kilang', 'form4D', 'buffer', 'year_list','batch'));
    }

    public function shuttle_4_keseluruhan_borang_E($year){
        $list_kilang = Shuttle::where('shuttle_type', '4')->get();

        $form4E = Form4E::where('tahun', $year)->get();

        $year_list = Form4E::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'e')->where('shuttle', '4')->first();

        $batch = Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle4_borangE', compact('returnArr','year','list_kilang', 'form4E', 'buffer', 'year_list','batch'));
    }

    //borang keseluruhan SHUTTLE 5
    public function shuttle_5_keseluruhan_borang_A($year){

        $form_a = FormA::where('form_a_s.tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', '5');
        })->leftJoin('batches', function($join) {
            $join->on('form_a_s.shuttle_id', '=', 'batches.shuttle_id');
        })->where('batches.borang_a', '2')
        ->select('batches.status as batches_status', 'form_a_s.*')
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

        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $formB = FormB::where('tahun', $year)->get();

        $year_list = FormB::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '5')->first();

        $batch = Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle5_borangB', compact('returnArr', 'year','list_kilang', 'formB', 'buffer', 'year_list','batch'));
    }

    public function shuttle_5_keseluruhan_borang_C($year){
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $formC = FormC::where('tahun', $year)->get();

        $year_list = FormC::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'c')->where('shuttle', '5')->first();
        $batch = Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle5_borangC', compact('returnArr','year','list_kilang', 'formC', 'buffer', 'year_list','batch'));
    }

    public function shuttle_5_keseluruhan_borang_D($year){
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $form5D = Form5D::where('tahun', $year)->get();

        $year_list = Form5D::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '5')->first();
        $batch = Batch::get();


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

        return view('admins.borangKeseluruhan.shuttle5_borangD', compact('returnArr','year','list_kilang', 'form5D', 'buffer', 'year_list','batch'));
    }

    public function shuttle_5_keseluruhan_borang_E($year){
        $list_kilang = Shuttle::where('shuttle_type', '5')->get();

        $form5E = Form5E::where('tahun', $year)->get();

        $year_list = Form5E::where('tahun', $year)->distinct()->orderby('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'e')->where('shuttle', '5')->first();

        $batch = Batch::get();

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

        return view('admins.borangKeseluruhan.shuttle5_borangE', compact('returnArr','year','list_kilang', 'form5E', 'buffer', 'year_list','batch'));
    }

    public function graph_dashboard_default()
    {
        // dd($request->all());
        $shuttle_type = '3';


        $johor = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Johor'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $kedah = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Kedah'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $kelantan = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Kelantan'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $melaka = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Melaka'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $n9 = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Negeri Sembilan'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $pahang = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Pahang'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $perak = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Perak'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $perlis = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Perlis'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $pinang = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Pulau Pinang'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $selangor = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Selangor'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $terengganu = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Terengganu'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $wp = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'W.P Kuala Lumpur'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        // dd($johor);

        // $query_past = DB::select("SELECT shuttles.negeri_id, COUNT(shuttles.negeri_id) as total_kilang
        // FROM form_a_s
        // INNER JOIN shuttles
        // ON form_a_s.shuttle_id = shuttles.id
        // WHERE shuttles.shuttle_type = $shuttle_type
        // AND YEAR(date(form_a_s.created_at)) = YEAR(now())-1
        // GROUP BY shuttles.negeri_id");

        $returnArr = [
            'johor' => $johor[0]->total_kilang?? 0,
            'kedah' => $kedah[0]->total_kilang ?? 0,
            'kelantan' => $kelantan[0]->total_kilang?? 0,
            'melaka' => $melaka[0]->total_kilang?? 0,
            'n9' => $n9[0]->total_kilang?? 0,
            'pahang' => $pahang[0]->total_kilang?? 0,
            'perak' => $perak[0]->total_kilang?? 0,
            'perlis' => $perlis[0]->total_kilang?? 0,
            'pinang' => $pinang[0]->total_kilang?? 0,
            'selangor' => $selangor[0]->total_kilang?? 0,
            'terengganu' => $terengganu[0]->total_kilang?? 0,
            'wp' => $wp[0]->total_kilang?? 0,


            // 'query_past' => $query_past
        ];

        return response($returnArr, 200);
    }

    public function graph_dashboard(Request $request)
    {
        // dd($request->all());
        $shuttle_type = $request->shuttle_type ?? 3;

        $johor = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Johor'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $kedah = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Kedah'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $kelantan = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Kelantan'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $melaka = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Melaka'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $n9 = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Negeri Sembilan'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $pahang = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Pahang'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $perak = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Perak'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $perlis = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Perlis'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $pinang = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Pulau Pinang'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $selangor = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Selangor'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $terengganu = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'Terengganu'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        $wp = DB::select("SELECT COUNT(shuttles.negeri_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = $shuttle_type
        AND shuttles.negeri_id = 'W.P Kuala Lumpur'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.negeri_id");

        // dd($johor);

        // $query_past = DB::select("SELECT shuttles.negeri_id, COUNT(shuttles.negeri_id) as total_kilang
        // FROM form_a_s
        // INNER JOIN shuttles
        // ON form_a_s.shuttle_id = shuttles.id
        // WHERE shuttles.shuttle_type = $shuttle_type
        // AND YEAR(date(form_a_s.created_at)) = YEAR(now())-1
        // GROUP BY shuttles.negeri_id");

        $returnArr = [
            'johor' => $johor[0]->total_kilang?? 0,
            'kedah' => $kedah[0]->total_kilang ?? 0,
            'kelantan' => $kelantan[0]->total_kilang?? 0,
            'melaka' => $melaka[0]->total_kilang?? 0,
            'n9' => $n9[0]->total_kilang?? 0,
            'pahang' => $pahang[0]->total_kilang?? 0,
            'perak' => $perak[0]->total_kilang?? 0,
            'perlis' => $perlis[0]->total_kilang?? 0,
            'pinang' => $pinang[0]->total_kilang?? 0,
            'selangor' => $selangor[0]->total_kilang?? 0,
            'terengganu' => $terengganu[0]->total_kilang?? 0,
            'wp' => $wp[0]->total_kilang?? 0,


            // 'query_past' => $query_past
        ];

        // $query_past = DB::select("SELECT shuttles.negeri_id, COUNT(shuttles.negeri_id) as total_kilang
        // FROM form_a_s
        // INNER JOIN shuttles
        // ON form_a_s.shuttle_id = shuttles.id
        // WHERE shuttles.shuttle_type = $shuttle_type
        // AND YEAR(date(form_a_s.created_at)) = YEAR(now())-1
        // GROUP BY shuttles.negeri_id");



        return response($returnArr, 200);
    }
}
