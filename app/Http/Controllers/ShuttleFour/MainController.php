<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Http\Livewire\ShuttleFour\FormD;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\TarafSyarikat;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Models\Warganegara;
use App\Notifications\IBK\BorangDiHantar;
use App\Notifications\PHD\BorangTidakLengkapNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public $shuttle_listA, $shuttle_listB;
    // public function shuttle_4_listA()
    // {
    //     $shuttle_listA = Shuttle::where('shuttle_type', '4')->paginate(10);
    //     return view('admins.shuttle-four.shuttle-4-listA',compact('shuttle_listA'));
    // }

    public function shuttle_4_listA_ipjpsm($year)
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
        AND shuttles.shuttle_type = '4'
        AND form_a_s.tahun = $year"));


        $formA = DB::select(DB::raw('SELECT form_a_s.* FROM batches, form_a_s
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"'));

        $year_list = DB::select(DB::raw('SELECT distinct form_a_s.tahun FROM batches, form_a_s
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND batches.status = "Dihantar ke IPJPSM"'));

        // $year_list = DB::select(DB::raw('SELECT form_a_s.tahun FROM batches, form_a_s
        // WHERE batches.tahun = form_a_s.tahun
        // AND batches.shuttle_id = form_a_s.shuttle_id
        // AND batches.borang_a = "2"
        // AND batches.status = "Dihantar ke IPJPSM"'));

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Senarai Borang 4A"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        // $buffer = Buffer::where('borang', 'a')->where('shuttle', '3')->first();

        return view('admins.shuttle-four.shuttle-4-listA-ipjpsm', compact(
            'user',
            'formA',
            'formA_kilang',
            'year_list',
            'year',
            'returnArr'
        ));
    }


    public function shuttle_4_formA()
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $forma_count = FormA::where('status', 'Tidak Lengkap')->where('shuttle_id', $user->shuttle_id)->where('tahun', date('Y'))->count();
        // dd($forma_count);

        $form_a = NULL;
        if($forma_count > 0 ){
            $form_a = FormA::where('status','Tidak Lengkap')->where('shuttle_id', $user->shuttle_id)->where('tahun',date('Y'))->first();
        }

        else{
            $form_a = FormA::where('status','Tidak Diisi')->where('tahun',date('Y'))->first();
        }
        $taraf_sah_syarikat = TarafSyarikat::get();
        $hak_milik = HakMilik::get();
        $warganegara = Warganegara::get();

        $user = auth()->user();

        $kilang_info = Shuttle::where('id', $user->shuttle_id)->first();

        $ulasan = UlasanPhd::where('formas_id', $form_a->id)->latest('created_at')->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-4-formA'), 'name' => "Borang 4A"],
        ];

        $kembali = route('user.shuttle-4-senaraiA', date('Y'));


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // return view('ibk.formA',compact('returnArr', 'kilang_info','ulasan','form_a','forma_count'));
        return view('admins.shuttle-four.shuttle-4-formA', compact('returnArr', 'kilang_info', 'ulasan', 'form_a', 'forma_count'));
    }

    public function updateForm4A(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);

        $form_a_checker = FormA::where('shuttle_id', auth()->user()->shuttle->id)->where('tahun', date("Y"))->first();
        if ($form_a_checker->status == "Sedang Diproses") {
            return redirect('/pengguna/halaman-utama')->with('error', 'Borang A telah dihantar');
        }

        $this->validator($request->all())->validate();
        $shuttle = Shuttle::where('id', $id)->first();

        $formA_update = FormA::where('shuttle_id', $shuttle->id)->whereYear('created_at', date("Y"))->first();
        // dd($formA_update);

        $formA_update->status = 'Sedang Diproses';

        $formA_update->save();

        $batch = Batch::where('tahun', $formA_update->tahun)->where('bulan', date("n"))->where('borang_a', '0')->where('shuttle_id',$shuttle->id)->first();
        $batch->status = "Sedang Diproses";
        $batch->borang_a = "1";

        // dd($batch);
        $batch->save();

        if ($request->has('sijil_ssm')) {
            // dd('masuk');
            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
            // dd($sijil_ssm);
            $shuttle->sijil_ssm  = $sijil_ssm;
        } else if ($request->has('lesen_kilang')) {
            // dd('masuk lsen');
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
            $shuttle->lesen_kilang  = $lesen_kilang;
        } else if ($request->has('lesen_kilang') && $request->has('sijil_ssm')) {
            // dd('masuk lsen');
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
            $shuttle->lesen_kilang  = $lesen_kilang;

            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
            // dd($sijil_ssm);
            $shuttle->sijil_ssm  = $sijil_ssm;
        }

        if (isset($request->alamat_sama)) {
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
        } else {
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

        $pegawais = User::where(
            'daerah',
            $daerah_id->daerah_id
        )->where('kategori_pengguna', 'PHD')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formA_update))->delay($delay));
        }

        return redirect()->route('home-user')->with('success','Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
    }
    public function validator(array $data)
    {
        if (isset($data['alamat_sama'])) {
            return Validator::make($data, [

                'no_telefon' => ['required', 'string', 'max:255'],
                'no_faks' => ['nullable', 'string', 'max:255'],
                'no_ssm' => ['required', 'string', 'max:255'],
                'tarikh_tubuh' => ['required', 'date'],
                'tarikh_operasi' => ['required', 'date'],
                'taraf_syarikat_catatan' => ['required', 'string', 'max:255'],
                'nilai_harta' => ['required', 'string', 'max:255'],
                'catatan_1' => ['nullable', 'string', 'max:255'],
                'catatan_2' => ['nullable', 'string', 'max:255'],
                'status' => ['nullable', 'string', 'max:255'],
                'email_kilang' => ['required', 'email'],
                'website' => ['nullable', 'string', 'max:255'],
                'no_lesen' => ['required', 'string', 'max:255'],
                'status_hak_milik' => ['required', 'string', 'max:255'],
                'status_warganegara' => ['required', 'string', 'max:255'],
                // 'sijil_ssm'=> ['required', 'max:10000'],
                // 'lesen_kilang'=> ['required','max:10000'],
            ]);
        } else {
            return Validator::make($data, [
                'alamat_surat_menyurat_poskod' => ['required'],
                'alamat_surat_menyurat_daerah' => ['required'],
                'no_telefon' => ['required', 'string', 'max:255'],
                'no_faks' => ['nullable', 'string', 'max:255'],
                'no_ssm' => ['required', 'string', 'max:255'],
                'tarikh_tubuh' => ['required', 'date'],
                'tarikh_operasi' => ['required', 'date'],
                'taraf_syarikat_catatan' => ['required', 'string', 'max:255'],
                'nilai_harta' => ['required', 'string', 'max:255'],
                'catatan_1' => ['nullable', 'string', 'max:255'],
                'catatan_2' => ['nullable', 'string', 'max:255'],
                'status' => ['nullable', 'string', 'max:255'],
                'email_kilang' => ['required', 'email'],
                'website' => ['nullable', 'string', 'max:255'],
                'no_lesen' => ['required', 'string', 'max:255'],
                'status_hak_milik' => ['required', 'string', 'max:255'],
                'status_warganegara' => ['required', 'string', 'max:255'],
                // 'sijil_ssm'=> ['required', 'max:10000'],
                // 'lesen_kilang'=> ['required','max:10000'],
            ]);
        }
    }

    public function shuttle_4_formB($id)
    {
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
            return view('admins.shuttle-four.shuttle-4-formB', compact('id'));
        }

        // if ($id != $early_buffer_date) {
        //     if ($form_b_checker == 0) {
        //         return redirect()->back()->with('error', 'Sila isi Borang B suku tahun sebelum ini terlebih dahulu.');
        //     }
        // }

        return view('admins.shuttle-four.shuttle-4-formB', compact('id'));
    }

    public function shuttle_4_formC($id)
    {
        $form_a_checker = FormA::where('tahun', date("Y"))
            ->where('shuttle_id', auth()->user()->shuttle->id)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }
        return view('admins.shuttle-four.shuttle-4-formC', compact('id'));
    }

    // SHUTTLE 4 FORM C

    public function shuttle_4_formCKKB($id, $year = null)
    {
        $year = $year ?? date("Y");
        
        if (auth()->user()->kategori_pengguna == "IBK") {
            $form_a_checker = FormA::where('tahun', $year)
                ->where('shuttle_id', auth()->user()->shuttle->id)
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($id != 1) {
                $lastmonth = $id - 1;
            } else {
                $lastmonth = $id;
            }


            // dd($id);
            if($id == 1 || $id <= 3){
                $suku_tahun = 1;
            }elseif($id == 4 || $id <= 6){
                $suku_tahun = 2;
            }elseif($id == 7 || $id <= 9){
                $suku_tahun = 3;
            }elseif($id == 10 || $id <= 12){
                $suku_tahun = 4;
            }else{
                $suku_tahun =0;
            }

            $form_b_checker = FormB::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('suku_tahun', $suku_tahun)
            ->whereYear('created_at', $year)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

            $buffer = Buffer::where('shuttle', 4)->where('borang', 'C')->first();
            $early_buffer_date = (int)date('m') - (int)$buffer->delay;

            if ($form_a_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
            }

            // if ($form_b_checker == 0) {
            //     return redirect()->back()->with('error', 'Sila isi Borang B bagi suku tahun yang dipilih terlebih dahulu.');
            // }

            if ($id == 1) {
                // return view('admins.shuttle-four.FormC.shuttle-4-formC-KKB', compact('id'));
                return redirect()->route('user.view.shuttle-4-formC.KKB', ['bulan' => $id, 'year' => $year]);
            }


        }

        // return view('admins.shuttle-four.FormC.shuttle-4-formC-KKB', compact('id'));
        return redirect()->route('user.view.shuttle-4-formC.KKB', ['bulan' => $id, 'year' => $year]);
    }

    public function shuttle_4_formCKKS($id, $year = null)
    {
        $year = $year ?? date("Y");
        return redirect()->route('user.view.shuttle-4-formC.KKS', ['bulan' => $id, 'year' => $year]);
    }

    public function shuttle_4_formCKKR($id)
    {
        return redirect()->route('user.view.shuttle-4-formC.KKR', $id);
    }

    public function shuttle_4_formCKayuLembut($id)
    {
        return redirect()->route('user.view.shuttle-4-formC.KayuLembut', $id);
    }

    public function shuttle_4_formCLainLain($id)
    {
        return redirect()->route('user.view.shuttle-4-formC.LainLain', $id);
    }

    // END OF SHUTTLE 3 FORM C

    public function shuttle_4_formD($id)
    {
        $form_a_checker = FormA::where('tahun', date("Y"))
            ->where('shuttle_id', auth()->user()->shuttle->id)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $buffer = Buffer::where('shuttle', 4)->where('borang', 'D')->first();

        // dd($form_a_checker_data->created_at->month);
        // dd($buffer);

        if ($id != 1) {
            $lastmonth = $id - 1;
        } else {
            $lastmonth = $id;
        }

        $early_buffer_date = (int)date('m') - (int)$buffer->delay;

        $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $id)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $form_d_checker = Form4D::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();
        // dd($early_buffer_date);

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }

        if ($form_c_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang C bagi bulan yang dipilih terlebih dahulu.');
        }

        if($id == 1){
            return view('admins.shuttle-four.shuttle-4-formD',compact('id'));
        }

        if ($id != $early_buffer_date) {
            if ($form_d_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang D bulan sebelum ini terlebih dahulu.');
            }
        }

        return view('admins.shuttle-four.shuttle-4-formD',compact('id'));
    }

    public function shuttle_4_formE($id)
    {
        if ($id != 1) {
            $lastmonth = $id - 1;
        } else {
            $lastmonth = $id;
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
            ->where('shuttle_id', auth()->user()->shuttle->id)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

            // dd($lastmonth);
        $form_d_checker = Form4D::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $id)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

            // dd( $form_d_checker);



        $buffer = Buffer::where('shuttle', 4)->where('borang', 'E')->first();


        $early_buffer_date = (int)date('m') - (int)$buffer->delay;

        $form_e_checker = Form4E::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        // dd($form_e_checker);

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }

        if ($form_d_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang D bagi bulan yang dipilih terlebih dahulu.');
        }

        if ($id == 1) {
            return view('admins.shuttle-four.shuttle-4-formE', compact('id'));
        }

        if ($id != $early_buffer_date) {
            if ($form_e_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang E bulan sebelum ini terlebih dahulu.');
            }
        }



        return view('admins.shuttle-four.shuttle-4-formE', compact('id'));
    }

    //Status Borang PHD shuttle 4
    public function senarai_tugasan_4A($year)
    {

        $formA = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->get();
        // dd($formA);

        $year_list = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4A', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4A', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4A', date('Y')), 'name' => "Status Borang 4A"],
        ];

        $kembali = route('home');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.phd.senarai-tugasan-4A', compact('returnArr', 'formA', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4B($year)
    {

        $formB = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4B', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4B', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4B', date('Y')), 'name' => "Status Borang 4B"],
        ];

        $kembali = route('home');
        $batch = Batch::get();

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.phd.senarai-tugasan-4B', compact('returnArr', 'formB', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4C($year)
    {
        $formC = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4C', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4C', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4C', date('Y')), 'name' => "Status Borang 4C"],

        ];

        $batch = Batch::get();
        // dd($batch);
        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.phd.senarai-tugasan-4C', compact('returnArr', 'formC', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4D($year)
    {

        $form4D = Form4D::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = Form4D::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4D', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4D', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4D', date('Y')), 'name' => "Status Borang 4D"],

        ];

        $batch = Batch::get();
        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.phd.senarai-tugasan-4D', compact('returnArr', 'form4D', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4E($year)
    {

        $form4E = Form4E::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = Form4E::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4E', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4E', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4E', date('Y')), 'name' => "Status Borang 4E"],

        ];

        $batch = Batch::get();
        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.phd.senarai-tugasan-4E', compact('returnArr', 'form4E', 'year_list', 'year', 'batch'));
    }


    public function update_status_phd_form4D(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $form4D = Form4D::find($id);
        $form4D->status = $request->status;
        $form4D->save();
        // dd($form4D);

        UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'form4ds_id' => $id,
        ]);

        $batch = Batch::where('tahun', $form4D->tahun)->where('bulan', $form4D->bulan)->where('shuttle_id', $form4D->shuttle_id)->first();

        // if ($request->status == "Tidak Lengkap") {

        //     $batch->borang_d = "0";
        //     $batch->save();

        //     //notification tidak lengkap
        //     $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $form4D->shuttle->id)->first();
        //     $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();

        //     foreach ($pengguna_kilangs as $pengguna_kilang) {
        //         $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $form4D, $request->status, $request->ulasan_phd, $pengguna_kilang));
        //     }
        // } elseif ($request->status == "Dihantar ke IPJPSM") {
            // dd($batch);

            $batch->borang_d = "2";
            $batch->save();

            // dd($batch);


        // }

        // if ($request->status == "Tidak Lengkap") {
        //     // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
        //     return redirect()->route('phd.shuttle-4-listD', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        // } elseif ($request->status == "Dihantar ke IPJPSM") {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-4-listD', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        // }
    }

    public function update_status_phd_form4E(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $form4E = Form4E::find($id);
        $form4E->status = $request->status;
        $form4E->save();

        UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'form4es_id' => $id,
        ]);

        $batch = Batch::where('tahun', $form4E->tahun)->where('bulan', $form4E->bulan)->where('shuttle_id', $form4E->shuttle_id)->first();

        if ($request->status == "Tidak Lengkap") {

            $batch->borang_e = "0";
            $batch->save();

            //notification tidak lengkap
            $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $form4E->shuttle->id)->first();
            $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();

            foreach ($pengguna_kilangs as $pengguna_kilang) {
                $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $form4E, $request->status, $request->ulasan_phd, $pengguna_kilang));
            }
        } elseif ($request->status == "Dihantar ke IPJPSM") {

            $batch->borang_e = "2";
            $batch->save();
        }

        if ($request->status == "Tidak Lengkap") {
            // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
            return redirect()->route('phd.shuttle-4-listE', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        } elseif ($request->status == "Dihantar ke IPJPSM") {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-4-listE', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
    }

    public function shuttle_4_form_view_form4C_ipjpsm($id)
    {
        // $kilang_info = Shuttle::where('id',$id)->first();
        // dd($kilang_info);
        $kategori_pekerja = KategoriGunaTenaga::get();


        // $formc = FormC::where('shuttle_id',$kilang_info->id)->where('status','Dihantar ke IPJPSM')->first();
        $formc = FormC::findorfail($id);
        // dd($formc);
        $kilang_info = Shuttle::findorfail($formc->shuttle->id);

        // $id =$formc->id;
        // dd($formc);

        $ulasan_phd = UlasanPhd::where('formcs_id', $formc->id)->get();


        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        $kumpulan_kayu = KumpulanKayu::get();

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();
        // $form_c = $form;

        // dd($form_c[0]);

        $kemasukan_bahan_calc_kkb = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '1');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kks = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '2');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kkr = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '3');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kayu_lembut = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '4');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_lain_lain = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '5');
        })->where('formcs_id', $formc->id)->first();

        $breadcrumbs3c    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
            ['link' => route('ipjpsm.shuttle-3-view-formC', date('Y')), 'name' => "Borang 3C "],
        ];

        $breadcrumbs4c    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Senarai Borang 4C"],
            ['link' => route('ipjpsm.shuttle-3-view-formC', date('Y')), 'name' => "Borang 4C "],
        ];

        $breadcrumbs5c    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
            ['link' => route('ipjpsm.shuttle-3-view-formC', date('Y')), 'name' => "Borang 5C "],
        ];

        $kembali3c = route('shuttle-3-listC', date('Y'));

        if($formc->status=='Lulus'){
            $kembali4c = route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y'));

        }
        else
        $kembali4c = route('shuttle-4-listC', date('Y'));
        $kembali5c = route('shuttle-5-listC', date('Y'));

        if ($formc->shuttle_type == 3) {
            $returnArr = [
                'breadcrumbs' => $breadcrumbs3c,
                'kembali'     => $kembali3c,
            ];
        } elseif ($formc->shuttle_type == 4) {
            $returnArr = [
                'breadcrumbs' => $breadcrumbs4c,
                'kembali'     => $kembali4c,
            ];
        } elseif ($formc->shuttle_type == 5) {
            $returnArr = [
                'breadcrumbs' => $breadcrumbs5c,
                'kembali'     => $kembali5c,
            ];
        }


        return view('livewire.view-form4c-Ipjpsm', compact(
            'returnArr',
            'kilang_info',
            'kategori_pekerja',
            'form_c',
            'id',
            'ulasan_phd',
            'formc',
            'species',
            'kumpulan_kayu',
            'kemasukan_bahan_calc_kkb',
            'kemasukan_bahan_calc_kkr',
            'kemasukan_bahan_calc_kks',
            'kemasukan_bahan_calc_kayu_lembut',
            'kemasukan_bahan_calc_lain_lain'
        ));
    }
}
