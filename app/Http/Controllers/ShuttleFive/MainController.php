<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\HakMilik;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\Shuttle;
use App\Models\TarafSyarikat;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Models\Warganegara;
use App\Notifications\IBK\BorangDiHantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{

    public $shuttle_listA,$shuttle_listB;
    public function shuttle_5_listA_ipjpsm($year)
    {
        $user = auth()->user();

        // $formB_kilang = FormB::select('shuttle_id')->distinct()->where('tahun', $year)->get();
        // $formA = FormA::where('status', '=', 'Dihantar ke IPJPSM')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })->where('tahun', $year)->get();

        $formA_kilang = DB::select(DB::raw("SELECT shuttles.* FROM form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_a_s.tahun
        AND batches.status = 'Dihantar ke IPJPSM'
        AND (form_a_s.status = 'Dihantar ke IPJPSM' OR form_a_s.status = 'Lulus')
        AND batches.borang_a = '2'
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND shuttles.shuttle_type = '5'
        AND form_a_s.tahun = $year"));


        $formA = DB::select(DB::raw('SELECT form_a_s.* FROM batches, form_a_s
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"'));

        $year_list = DB::select(DB::raw("SELECT DISTINCT form_a_s.tahun FROM form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_a_s.tahun
        AND batches.status = 'Dihantar ke IPJPSM'
        AND (form_a_s.status = 'Dihantar ke IPJPSM' OR form_a_s.status = 'Lulus')
        AND batches.borang_a = '2'
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND shuttles.shuttle_type = '5'
        AND form_a_s.tahun = $year"));

        $year_list = DB::select(DB::raw('SELECT distinct form_a_s.tahun FROM batches, form_a_s
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"'));

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Senarai Borang 5A"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        // $buffer = Buffer::where('borang', 'a')->where('shuttle', '3')->first();

        return view('admins.shuttle-five.shuttle-5-listA-ipjpsm', compact(
            'user',
            'formA',
            'formA_kilang',
            'year_list',
            'year',
            'returnArr'
        ));
    }

    public function shuttle_5_formA()
    {
        $user = auth()->user();
        $shuttle= Shuttle::where('id',$user->shuttle_id)->first();

        $forma_count = FormA::where('status','Tidak Lengkap')->where('shuttle_id', $user->shuttle_id)->where('tahun',date('Y'))->count();

        // dd($forma_count);
        $form_a = NULL;
        if($forma_count > 0 ){
            $form_a = FormA::where('status','Tidak Lengkap')->where('shuttle_id', $user->shuttle_id)->where('tahun',date('Y'))->first();
        }

        else{
            $form_a = FormA::where('status','Tidak Diisi')->where('tahun',date('Y'))->first();
        }
        // dd($form_a);
        $taraf_sah_syarikat = TarafSyarikat::get();
        $hak_milik = HakMilik::get();
        $warganegara = Warganegara::get();

        $user = auth()->user();

        $kilang_info = Shuttle::where('id', $user->shuttle_id)->first();

        // dd($kilang_info);

        $ulasan = UlasanPhd::where('formas_id', $form_a->id)->latest('created_at')->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-5-formA'), 'name' => "Borang 5A"],
        ];

        $kembali = route('user.shuttle-5-senaraiA', date('Y'));


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.shuttle-five.shuttle-5-formA',compact('returnArr', 'kilang_info','ulasan','form_a','forma_count'));
    }
    public function updateForm5A(Request $request, $id){
        // dd($request->all());

        $this->validator($request->all())->validate();

        $shuttle=Shuttle::where('id',$id)->first();

        $formA_update = FormA::where('shuttle_id', $shuttle->id)->whereYear('created_at', date("Y"))->first();

        // dd($formA_update);
        $formA_update->status = 'Sedang Diproses';

        $formA_update->save();

        $batch = Batch::where('tahun', $formA_update->tahun)->where('bulan', date("n"))->where('borang_a', '0')->where('shuttle_id',$shuttle->id)->first();
        // dd($batch);

        $batch->status = "Sedang Diproses";

        $batch->borang_a = "1";

        $batch->save();

        // dd($formA_checker);

        if($request->has('sijil_ssm')){
            // dd('masuk');
            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
            // dd($sijil_ssm);
            $shuttle->sijil_ssm  = $sijil_ssm;
        }

        else if($request->has('lesen_kilang')){
            // dd('masuk lsen');
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
            $shuttle->lesen_kilang  = $lesen_kilang;

        }
        else if($request->has('lesen_kilang') && $request->has('sijil_ssm')){
            // dd('masuk lsen');
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
            $shuttle->lesen_kilang  = $lesen_kilang;

            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
            // dd($sijil_ssm);
            $shuttle->sijil_ssm  = $sijil_ssm;

        }

        if(isset($request->alamat_sama)){
            $shuttle->alamat_surat_menyurat_1  = request()->alamat_kilang_1;
            $shuttle->alamat_surat_menyurat_2  = request()->alamat_kilang_2;
            $shuttle->alamat_surat_menyurat_poskod  = request()->alamat_kilang_poskod;
            $shuttle->alamat_surat_menyurat_daerah  = request()->alamat_kilang_daerah;
            $shuttle->no_ssm  = request()->no_ssm;
            $shuttle->no_telefon  = request()->no_telefon;
            $shuttle->no_faks  = request()->no_faks;
            $shuttle->email  = request()->email_kilang;
            $shuttle->website  = request()->website;
            $shuttle->tarikh_tubuh  = request()->tarikh_tubuh;
            $shuttle->tarikh_operasi  = request()->tarikh_operasi;
            $shuttle->taraf_syarikat_catatan  = request()->taraf_syarikat_catatan;
            $shuttle->status_hak_milik  = request()->status_hak_milik;
            $shuttle->status_warganegara  = request()->status_warganegara;
            $shuttle->nilai_harta  = request()->nilai_harta;
            $shuttle->save();
        }else{
            $shuttle->alamat_surat_menyurat_1  = request()->alamat_surat_menyurat_1;
            $shuttle->alamat_surat_menyurat_2  = request()->alamat_surat_menyurat_2;
            $shuttle->alamat_surat_menyurat_poskod  = request()->alamat_surat_menyurat_poskod;
            $shuttle->alamat_surat_menyurat_daerah  = request()->alamat_surat_menyurat_daerah;
            $shuttle->no_ssm  = request()->no_ssm;
            $shuttle->no_telefon  = request()->no_telefon;
            $shuttle->no_faks  = request()->no_faks;
            $shuttle->email  = request()->email_kilang;
            $shuttle->website  = request()->website;
            $shuttle->tarikh_tubuh  = request()->tarikh_tubuh;
            $shuttle->tarikh_operasi  = request()->tarikh_operasi;
            $shuttle->taraf_syarikat_catatan  = request()->taraf_syarikat_catatan;
            $shuttle->status_hak_milik  = request()->status_hak_milik;
            $shuttle->status_warganegara  = request()->status_warganegara;
            $shuttle->nilai_harta  = request()->nilai_harta;
            $shuttle->save();
        }
        // Session::flash('message', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah',
            $daerah_id->daerah_id
        )->where('kategori_pengguna', 'PHD')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formA_update))->delay($delay));
        }

        return redirect()->route('home-user')->with('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

    }
    public function validator(array $data){
        if(isset($data['alamat_sama'])){
        return Validator::make($data, [

            'no_telefon'=> ['required', 'string', 'max:255'],
            'no_faks'=> ['nullable', 'string', 'max:255'],
            'no_ssm'=> ['required', 'string', 'max:255'],
            'tarikh_tubuh'=> ['required', 'date'],
            'tarikh_operasi'=> ['required', 'date'],
            'taraf_syarikat_catatan'=> ['required', 'string', 'max:255'],
            'nilai_harta'=> ['required', 'string', 'max:255'],
            'catatan_1'=> ['nullable', 'string', 'max:255'],
            'catatan_2'=> ['nullable', 'string', 'max:255'],
            'status'=> ['nullable', 'string', 'max:255'],
            'email_kilang'=> ['required', 'email'],
            'website'=> ['nullable', 'string', 'max:255'],
            'no_lesen'=> ['required', 'string', 'max:255'],
            'status_hak_milik'=> ['required', 'string', 'max:255'],
            'status_warganegara'=> ['required', 'string', 'max:255'],
            // 'sijil_ssm'=> ['required', 'max:10000'],
            // 'lesen_kilang'=> ['required','max:10000'],
        ]);
        }else{
            return Validator::make($data, [
                'alamat_surat_menyurat_poskod' => ['required'],
                'alamat_surat_menyurat_daerah' => ['required'],
                'no_telefon'=> ['required', 'string', 'max:255'],
                'no_faks'=> ['nullable', 'string', 'max:255'],
                'no_ssm'=> ['required', 'string', 'max:255'],
                'tarikh_tubuh'=> ['required', 'date'],
                'tarikh_operasi'=> ['required', 'date'],
                'taraf_syarikat_catatan'=> ['required', 'string', 'max:255'],
                'nilai_harta'=> ['required', 'string', 'max:255'],
                'catatan_1'=> ['nullable', 'string', 'max:255'],
                'catatan_2'=> ['nullable', 'string', 'max:255'],
                'status'=> ['nullable', 'string', 'max:255'],
                'email_kilang'=> ['required', 'email'],
                'website'=> ['nullable', 'string', 'max:255'],
                'no_lesen'=> ['required', 'string', 'max:255'],
                'status_hak_milik'=> ['required', 'string', 'max:255'],
                'status_warganegara'=> ['required', 'string', 'max:255'],
                // 'sijil_ssm'=> ['required', 'max:10000'],
                // 'lesen_kilang'=> ['required','max:10000'],
            ]);
        }
    }

    public function shuttle_5_formB($id)
    {
        // dd($id);
        if ($id != 1) {
            $lastmonth = $id - 1;
        } else {
            $lastmonth = $id;
        }

        if (auth()->user()->shuttle_type == "3"){
            $buffer = Buffer::where('shuttle', 3)->where('borang', 'B')->first();
        }else if(auth()->user()->shuttle_type == "4"){
            $buffer = Buffer::where('shuttle', 4)->where('borang', 'B')->first();
        }else{
            $buffer = Buffer::where('shuttle', 5)->where('borang', 'B')->first();
        }

        $early_buffer_date = (int)date('m') - (int)$buffer->delay;
        $form_a_checker = FormA::where('tahun', date("Y"))
            ->where('shuttle_id', auth()->user()->shuttle->id)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $form_b_checker = FormB::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('suku_tahun', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

            // dd($form_b_checker);

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }

        if ($id == 1) {
            return view('admins.shuttle-five.shuttle-5-formB', compact('id'));
        }

        // if ($id != $early_buffer_date) {
        //     if ($form_b_checker == 0) {
        //         return redirect()->back()->with('error', 'Sila isi Borang B suku tahun sebelum ini terlebih dahulu.');
        //     }
        // }
        return view('admins.shuttle-five.shuttle-5-formB',compact('id'));
    }
    public function shuttle_5_formC($id)
    {
        $form_a_checker = FormA::where('tahun', date("Y"))
        ->where('shuttle_id', auth()->user()->shuttle->id)
        ->where('status', '!=', 'Tidak Diisi')
        ->count();

        if($form_a_checker == 0){
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }
        return view('admins.shuttle-five.shuttle-5-formC',compact('id'));
    }
    public function shuttle_5_formD($id)
    {
        $buffer = Buffer::where('shuttle', 5)->where('borang', 'D')->first();

        if ($id != 1) {
            $lastmonth = $id - 1;
        } else {
            $lastmonth = $id;
        }

        $early_buffer_date = (int)date('m') - (int)$buffer->delay;

        $form_a_checker = FormA::where('tahun', date("Y"))
        ->where('shuttle_id', auth()->user()->shuttle->id)
        ->where('status', '!=', 'Tidak Diisi')
        ->count();

        $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $id)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $form_c_data = FormC::where('shuttle_id', auth()->user()->shuttle_id)
        ->where('bulan', $id)
        ->whereYear('created_at', date("Y"))
        ->where('status', '!=', 'Tidak Diisi')
        ->first();

        // dd($form_c_data);

        $form_d_checker = Form5D::where('shuttle_id', auth()->user()->shuttle_id)
        ->where('bulan', $lastmonth)
        ->whereYear('created_at', date("Y"))
        ->where('status', '!=', 'Tidak Diisi')
        ->count();

        if ($form_c_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang C bagi bulan yang dipilih terlebih dahulu.');
        }

        if($form_a_checker == 0){
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }

        if($id == 1){
            return view('admins.shuttle-five.shuttle-5-formD',compact('id','form_c_data'));
        }

        if ($id != $early_buffer_date) {
            if ($form_d_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang D bulan sebelum ini terlebih dahulu.');
            }
        }
        return view('admins.shuttle-five.shuttle-5-formD',compact('id','form_c_data'));
    }

    public function shuttle_5_edit_formD($id)
    {

        return view('admins.shuttle-five.shuttle-5-edit-formD',compact('id'));
    }

    public function shuttle_5_edit_formE($id)
    {
        // dd($id);
        $form_5e = Form5E::find($id);
        $id = $form_5e->bulan;

        $form_5e_id =$form_5e->id;
        // dd($id);
        $shuttle_id = $form_5e->shuttle_id;
        // dd($shuttle_id);

        $ulasan_phd = UlasanPhd::where('form5es_id', $form_5e->id)->latest('created_at')->first();
        // dd($ulasan_phd);
        return view('admins.shuttle-five.shuttle-5-edit-formE',compact('id','ulasan_phd','shuttle_id','form_5e_id'));
    }

    public function shuttle_5_formE($id)
    {
        $buffer = Buffer::where('shuttle', 5)->where('borang', 'E')->first();

        if ($id != 1) {
            $lastmonth = $id - 1;
        } else {
            $lastmonth = $id;
        }

        $early_buffer_date = (int)date('m') - (int)$buffer->delay;

        $form_a_checker = FormA::where('tahun', date("Y"))
        ->where('shuttle_id', auth()->user()->shuttle->id)
        ->where('status', '!=', 'Tidak Diisi')
        ->count();

        $form_d_checker = Form5D::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $id)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $form_e_checker = Form5E::where('shuttle_id', auth()->user()->shuttle_id)
        ->where('bulan', $lastmonth)
        ->whereYear('created_at', date("Y"))
        ->where('status', '!=', 'Tidak Diisi')
        ->count();

        if($form_a_checker == 0){
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }
        if ($form_d_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang D bagi bulan yang dipilih terlebih dahulu.');
        }

        if($id == 1){
            return view('admins.shuttle-five.shuttle-5-formE',compact('id'));
        }

        if ($id != $early_buffer_date) {
            if ($form_e_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang E bulan sebelum ini terlebih dahulu.');
            }
        }
        return view('admins.shuttle-five.shuttle-5-formE',compact('id'));
    }

    public function update_status_phd_form5D(Request $request,$id){
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $form5D = Form5D::find($id);
        $form5D->status = $request->status;
        $form5D->save();

        UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'form5ds_id' => $id,
        ]);

        $batch = Batch::where('tahun', $form5D->tahun)->where('bulan', $form5D->bulan)->where('shuttle_id', $form5D->shuttle_id)->first();

        if ($request->status == "Tidak Lengkap") {

            $batch->borang_d = "0";
            $batch->save();

            //hantar email n inapps noti to ibk

        } elseif ($request->status == "Dihantar ke IPJPSM") {

            $batch->borang_d = "2";
            $batch->save();
        }

        if ($request->status == "Tidak Lengkap") {
            // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
            return redirect()->route('phd.shuttle-5-listD', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        } elseif ($request->status == "Dihantar ke IPJPSM") {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-5-listD', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
    }

    public function update_status_phd_form5E(Request $request,$id){
        // dd($request->all());

        // dd($id);
        $user = auth()->user();
        $form5E = Form5E::where('id',$id)->first();
        // dd( $form5E);
        $form5E->status = $request->status;
        $form5E->save();

        $test=UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'form5es_id' => $form5E->id,
        ]);
        // dd($test);

        $batch = Batch::where('tahun', $form5E->tahun)->where('bulan', $form5E->bulan)->where('shuttle_id', $form5E->shuttle_id)->first();

        if ($request->status == "Tidak Lengkap") {

            $batch->borang_e = "0";
            $batch->save();

            //hantar email n inapps noti to ibk

        } elseif ($request->status == "Dihantar ke IPJPSM") {

            $batch->borang_e = "2";
            $batch->save();
        }

        if ($request->status == "Tidak Lengkap") {
            // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
            return redirect()->route('phd.shuttle-5-listE', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        } elseif ($request->status == "Dihantar ke IPJPSM") {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-5-listE', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
    }

    //Status Borang PHD shuttle 5
    public function senarai_tugasan_5A($year){

        $formA = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
            })
            ->get();

        $year_list = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-5A', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-5A', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.senarai-tugasan-5A', date('Y')), 'name' => "Status Borang 5A"],
        ];

        $kembali = route('home');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

         return view('admins.PHD.senarai-tugasan-5A',compact('returnArr','formA', 'year_list', 'year','batch'));
    }

    public function senarai_tugasan_5B($year){

        $formB = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->get();

        $year_list = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-5B', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-5B', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.senarai-tugasan-5B', date('Y')), 'name' => "Status Borang 5B"],
        ];

        $kembali = route('home');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


         return view('admins.PHD.senarai-tugasan-5B',compact('returnArr','formB', 'year_list', 'year','batch'));
    }

    public function senarai_tugasan_5C($year){
        $formC = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->get();

        $year_list = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-5C', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-5C', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.senarai-tugasan-5C', date('Y')), 'name' => "Status Borang 5C"],
        ];

        $kembali = route('home-phd');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

         return view('admins.PHD.senarai-tugasan-5C',compact('returnArr','formC', 'year_list', 'year','batch'));
    }

    public function senarai_tugasan_5D($year){

        $form5D = Form5D::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->get();

        $year_list = Form5D::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-5D', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-5D', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.senarai-tugasan-5D', date('Y')), 'name' => "Status Borang 5D"],
        ];

        $kembali = route('home-phd');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

         return view('admins.PHD.senarai-tugasan-5D',compact('returnArr','form5D', 'year_list', 'year','batch'));
    }

    public function senarai_tugasan_5E($year){

        $form5E = Form5E::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->get();

        $year_list = Form5E::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
        ->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-5E', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-5E', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.senarai-tugasan-5E', date('Y')), 'name' => "Status Borang 5E"],
        ];

        $kembali = route('home-phd');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

         return view('admins.PHD.senarai-tugasan-5E',compact('returnArr','form5E', 'year_list', 'year','batch'));
    }


}
