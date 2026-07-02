<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Http\Livewire\ShuttleFour\FormD;
use App\Services\FormFlowService;
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
use App\Models\ProdukPengeluaran;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\UlasanIpjpsm;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Models\Daerah;
use App\Models\Warganegara;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
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
        if ($year < 2025) return redirect()->route('shuttle-4-listA', 2025);
        $user = auth()->user();

        // $formB_kilang = FormB::select('shuttle_id')->distinct()->where('tahun', $year)->get();
        // $formA = FormA::where('status', '=', 'Dihantar ke IPJPSM')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })->where('tahun', $year)->get();

        $formA_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.*, COALESCE(d.daerah_hutan, shuttles.daerah_id) as daerah_display FROM form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        LEFT JOIN daerahs d ON d.id = shuttles.daerah_id AND d.deleted_at IS NULL
        WHERE (form_a_s.status = 'Dihantar ke IPJPSM' OR form_a_s.status = 'Lulus')
        AND shuttles.shuttle_type = '4'
        AND form_a_s.tahun = $year"));

        $formA = DB::select(DB::raw("SELECT form_a_s.* FROM form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        WHERE form_a_s.tahun = $year
        AND shuttles.shuttle_type = '4'"));

        $year_list = DB::select(DB::raw("SELECT DISTINCT form_a_s.tahun FROM form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = '4'
        AND (form_a_s.status = 'Dihantar ke IPJPSM' OR form_a_s.status = 'Lulus')
        ORDER BY form_a_s.tahun DESC"));

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


    public function shuttle_4_formA($year = null)
    {
        // Use current year if no year provided
        $year = $year ?? date("Y");
        
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        // First check if ANY Form A exists for this year and shuttle (regardless of status)
        $form_a = FormA::where('shuttle_id', $user->shuttle_id)->where('tahun', $year)->first();
        
        // If no form found for this year, create it automatically
        if (!$form_a) {
            $form_a = FormA::create([
                'shuttle_id' => $user->shuttle_id,
                'status' => 'Tidak Diisi',
                'tahun' => $year,
            ]);
        }
        
        $forma_count = ($form_a->status == 'Tidak Lengkap') ? 1 : 0;
        
        $taraf_sah_syarikat = TarafSyarikat::get();
        $hak_milik = HakMilik::get();
        $warganegara = Warganegara::get();

        $user = auth()->user();

        $kilang_info = Shuttle::where('id', $user->shuttle_id)->first();

        $ulasan = UlasanPhd::where('formas_id', $form_a->id)->latest('created_at')->first();

        $daerah_hutan_display = $kilang_info->daerah_id;
        $daerah_sivil_display = '';
        if ($kilang_info->daerah_id && is_numeric($kilang_info->daerah_id)) {
            $daerah_rec = Daerah::find($kilang_info->daerah_id);
            if ($daerah_rec) {
                $daerah_hutan_display = $daerah_rec->daerah_hutan;
                $daerah_sivil_display = $daerah_rec->daerah_sivil;
            }
        }

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiA', $year), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-4-formA', $year), 'name' => "Borang 4A"],
        ];

        $kembali = route('user.shuttle-4-senaraiA', $year);


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // return view('ibk.formA',compact('returnArr', 'kilang_info','ulasan','form_a','forma_count'));
        return view('admins.shuttle-four.shuttle-4-formA', compact('returnArr', 'kilang_info', 'ulasan', 'form_a', 'forma_count', 'daerah_hutan_display', 'daerah_sivil_display'));
    }

    public function updateForm4A(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);

        $this->validator($request->all())->validate();
        $shuttle = Shuttle::where('id', $id)->first();

        $formA_update = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $request->tahun)->first();
        // dd($formA_update);

        $formA_update->status = 'Sedang Diproses';

        $formA_update->save();

        $batch = Batch::where('tahun', $formA_update->tahun)->where('borang_a', '0')->where('shuttle_id',$shuttle->id)->first();

        if ($batch) {
            $batch->status = "Sedang Diproses";
            $batch->borang_a = "1";
            $batch->save();
        }

        if ($request->hasFile('sijil_ssm')) {
            $shuttle->sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
        }
        if ($request->hasFile('lesen_kilang')) {
            $shuttle->lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
        }

        if (isset($request->alamat_sama)) {
            $shuttle->nama_kilang  = request()->nama_kilang;
            $shuttle->alamat_surat_menyurat_1  = request()->alamat_kilang_1;
            $shuttle->alamat_surat_menyurat_2  = request()->alamat_kilang_2;
            $shuttle->alamat_surat_menyurat_poskod  = request()->alamat_kilang_poskod;
            $shuttle->alamat_surat_menyurat_daerah  = request()->alamat_kilang_daerah;
            $shuttle->no_ssm  = request()->no_ssm;
            $shuttle->no_lesen  = request()->no_lesen;
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
            $shuttle->nama_kilang  = request()->nama_kilang;
            $shuttle->alamat_surat_menyurat_1  = request()->alamat_surat_menyurat_1;
            $shuttle->alamat_surat_menyurat_2  = request()->alamat_surat_menyurat_2;
            $shuttle->alamat_surat_menyurat_poskod  = request()->alamat_surat_menyurat_poskod;
            $shuttle->alamat_surat_menyurat_daerah  = request()->alamat_surat_menyurat_daerah;
            $shuttle->no_ssm  = request()->no_ssm;
            $shuttle->no_lesen  = request()->no_lesen;
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

        try {
            $pegawais = User::where(
                'daerah',
                $daerah_id->daerah_id
            )->where('kategori_pengguna', 'PHD')->get();

            $delay = now()->addMinutes(1);

            foreach ($pegawais as $pegawai) {
                $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formA_update))->delay($delay));
            }
        } catch (\Exception $e) {
            \Log::warning('Form 4A notification failed: ' . $e->getMessage());
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

    public function shuttle_4_formB($id, $year = null)
    {
        $year = $year ?? date("Y");

        if ((int)$year > (int)date('Y') || ((int)$year == (int)date('Y') && (int)ceil(date('n') / 3) < (int)$id)) {
            return redirect()->back()->with('error', 'Borang untuk suku tahun ini belum dibuka.');
        }

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
        $form_a_checker = FormA::where('tahun', $year)
            ->where('shuttle_id', auth()->user()->shuttle->id)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $form_b_checker = FormB::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('suku_tahun', $lastmonth)
            ->where('tahun', $year)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

            // dd($form_b_checker);

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang A tahun ' . $year . ' terlebih dahulu.');
        }

        $formb = FormB::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('suku_tahun', $id)
            ->where('tahun', $year)
            ->first();
        if ($formb && $formb->status === 'Ditutup') {
            $formb->status = 'Tidak Diisi';
            $formb->save();
        }

        if ($id == 1) {
            return view('admins.shuttle-four.shuttle-4-formB', compact('id', 'year'));
        }

        // if ($id != $early_buffer_date) {
        //     if ($form_b_checker == 0) {
        //         return redirect()->back()->with('error', 'Sila isi Borang B suku tahun sebelum ini terlebih dahulu.');
        //     }
        // }

        return view('admins.shuttle-four.shuttle-4-formB', compact('id', 'year'));
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
        $year    = $year ?? date('Y');
        $shuttle = auth()->user()->shuttle;
        $flow    = FormFlowService::getStatus($shuttle->id, 4, (int) $year);

        if (!$flow['formC'][(int) $id]['can_fill']) {
            return redirect()->back()->with('error', $flow['formC'][(int) $id]['reason']);
        }

        return redirect()->route('user.view.shuttle-4-formC.KKB', ['bulan' => $id, 'year' => $year]);
    }

    public function shuttle_4_formCKKS($id, $year = null)
    {
        $year = $year ?? date("Y");
        return redirect()->route('user.view.shuttle-4-formC.KKS', ['bulan' => $id, 'year' => $year]);
    }

    public function shuttle_4_formCKKR($id, $year = null)
    {
        $year = $year ?? date("Y");
        return redirect()->route('user.view.shuttle-4-formC.KKR', ['bulan' => $id, 'year' => $year]);
    }

    public function shuttle_4_formCKayuLembut($id, $year = null)
    {
        $year = $year ?? date("Y");
        return redirect()->route('user.view.shuttle-4-formC.KayuLembut', ['bulan' => $id, 'year' => $year]);
    }

    public function shuttle_4_formCLainLain($id, $year = null)
    {
        $year = $year ?? date("Y");
        return redirect()->route('user.view.shuttle-4-formC.LainLain', ['bulan' => $id, 'year' => $year]);
    }

    // END OF SHUTTLE 3 FORM C

    public function shuttle_4_formD($year, $id)
    {
        $shuttle = auth()->user()->shuttle;
        $flow    = FormFlowService::getStatus($shuttle->id, 4, (int) $year);

        if (!$flow['formD'][(int) $id]['can_fill']) {
            return redirect()->back()->with('error', $flow['formD'][(int) $id]['reason']);
        }

        return view('admins.shuttle-four.shuttle-4-formD', compact('id'));
    }

    public function shuttle_4_formE($year, $id)
    {
        $shuttle = auth()->user()->shuttle;
        $flow    = FormFlowService::getStatus($shuttle->id, 4, (int) $year);

        if (!$flow['formE'][(int) $id]['can_fill']) {
            return redirect()->back()->with('error', $flow['formE'][(int) $id]['reason']);
        }

        return view('admins.shuttle-four.shuttle-4-formE', compact('id'));
    }

    //Status Borang PHD shuttle 4
    public function senarai_tugasan_4A($year)
    {

        $formA = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->get();
        // dd($formA);

        $year_list = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4A', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4A', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4A', date('Y')), 'name' => "Status Borang 4A"],
        ];

        $kembali = route('home');
        $batch = Batch::where('tahun', $year)->get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.PHD.senarai-tugasan-4A', compact('returnArr', 'formA', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4B($year)
    {

        $formB = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4B', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4B', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4B', date('Y')), 'name' => "Status Borang 4B"],
        ];

        $kembali = route('home');
        $batch = Batch::where('tahun', $year)->get();

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.PHD.senarai-tugasan-4B', compact('returnArr', 'formB', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4C($year)
    {
        $formC = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->orderByRaw("CASE status
                WHEN 'Sedang Diproses'    THEN 1
                WHEN 'Tiada Pengeluaran'  THEN 2
                WHEN 'Tidak Lengkap'      THEN 3
                WHEN 'Dihantar ke IPJPSM' THEN 4
                WHEN 'Lulus'              THEN 5
                ELSE 6 END")
            ->orderBy('bulan')
            ->get();

        $year_list = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4C', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4C', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4C', date('Y')), 'name' => "Status Borang 4C"],

        ];

        $batch = Batch::where('tahun', $year)->get();
        // dd($batch);
        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-4C', compact('returnArr', 'formC', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4D($year)
    {

        $form4D = Form4D::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = Form4D::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4D', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4D', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4D', date('Y')), 'name' => "Status Borang 4D"],

        ];

        $batch = Batch::where('tahun', $year)->get();
        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-4D', compact('returnArr', 'form4D', 'year_list', 'year', 'batch'));
    }

    public function senarai_tugasan_4E($year)
    {

        $form4E = Form4E::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->get();

        $year_list = Form4E::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-4E', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-4E', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.senarai-tugasan-4E', date('Y')), 'name' => "Status Borang 4E"],

        ];

        $batch = Batch::where('tahun', $year)->get();
        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-4E', compact('returnArr', 'form4E', 'year_list', 'year', 'batch'));
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

        if ($batch) {
            if ($request->status == "Tidak Lengkap") {
                $batch->borang_d = "0";
                $batch->save();
            } elseif ($request->status == "Dihantar ke IPJPSM") {
                $batch->borang_d = "2";
                $batch->save();
            }
        }

        if ($request->status == "Tidak Lengkap") {
            return redirect()->route('phd.shuttle-4-listD', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        } elseif ($request->status == "Dihantar ke IPJPSM") {
            return redirect()->route('phd.shuttle-4-listD', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
        return redirect()->route('phd.shuttle-4-listD', date("Y"))->with('success', 'Borang Berjaya Dikemaskini.');
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

        if ($batch) {
            if ($request->status == "Tidak Lengkap") {
                $batch->borang_e = "0";
                $batch->save();
            } elseif ($request->status == "Dihantar ke IPJPSM") {
                $batch->borang_e = "2";
                $batch->save();
            }
        }

        if ($request->status == "Tidak Lengkap") {
            if ($batch) {
                $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $form4E->shuttle->id)->first();
                $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();
                foreach ($pengguna_kilangs as $pengguna_kilang) {
                    $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $form4E, $request->status, $request->ulasan_phd, $pengguna_kilang));
                }
            }
            return redirect()->route('phd.shuttle-4-listE', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        } elseif ($request->status == "Dihantar ke IPJPSM") {
            return redirect()->route('phd.shuttle-4-listE', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
        return redirect()->route('phd.shuttle-4-listE', date("Y"))->with('success', 'Borang Berjaya Dikemaskini.');
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


        $species = Spesis::with('kumpulan_kayu')->orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
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

        $fromKeseluruhan = request()->get('from') == 'keseluruhan';
        $kembali3c = $fromKeseluruhan ? route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y')) : route('shuttle-3-listC', date('Y'));
        $kembali4c = $fromKeseluruhan ? route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')) : route('shuttle-4-listC', date('Y'));
        $kembali5c = $fromKeseluruhan ? route('ipjpsm.borang-keseluruhan.shuttle5.borangC', date('Y')) : route('shuttle-5-listC', date('Y'));

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

    public function shuttle_4_form_view_form4D_ipjpsm($id)
    {
        $form4d = Form4D::findorfail($id);
        $kilang_info = Shuttle::findorfail($form4d->shuttle->id);

        // Keep the original ID for use in the view
        $formId = $id;

        // Add missing variables that the view expects
        $nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<=', '11.99')->get();
        $tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12.00')->get();
        $jumlah_kecil_nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<', '12')->first();
        $jumlah_kecil_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12')->first();

        $layout = auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : 'layouts.layout-phd-nicepage';

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Senarai Borang 4D"],
            ['link' => route('ipjpsm.shuttle-4-view-formD', $id), 'name' => "Borang 4D "],
        ];

        $kembali = request()->get('from') == 'keseluruhan'
            ? route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y'))
            : route('shuttle-4-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali' => $kembali,
            'layout' => $layout
        ];

        return view('admins.shuttle-four.view-form4d', compact('returnArr', 'form4d', 'kilang_info', 'nipis', 'tebal', 'jumlah_kecil_nipis', 'jumlah_kecil_tebal', 'id'));
    }

    public function shuttle_4_form_view_form4E_ipjpsm($id)
    {
        $form4e = Form4E::findorfail($id);
        $kilang_info = Shuttle::findorfail($form4e->shuttle->id);

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();
        $form4_e = PenjualanPembeli::where('form4es_id', $form4e->id)->get();

        $layout = auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : 'layouts.layout-phd-nicepage';

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Senarai Borang 4E"],
            ['link' => route('ipjpsm.shuttle-4-view-formE', $id), 'name' => "Borang 4E "],
        ];

        $kembali = request()->get('from') == 'keseluruhan'
            ? route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y'))
            : route('shuttle-4-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali' => $kembali,
            'layout' => $layout
        ];

        return view('admins.shuttle-four.view-form4e', compact('returnArr', 'form4e', 'kilang_info', 'jenis_pembeli', 'form4_e', 'id'));
    }

    public function update_status_ipjpsm4D(Request $request, $id)
    {
        $user = auth()->user();
        $form4D = Form4D::find($id);

        if (!$form4D) {
            return redirect()->back()->with('error', 'Form not found');
        }

        $form4D->status = $request->status;
        $form4D->save();

        UlasanIpjpsm::create([
            'ulasan' => $request->ulasan_ipjpsm,
            'user_id' => $user->id,
            'form4ds_id' => $id,
        ]);

        return redirect()->route('shuttle-4-listD', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }

    public function update_status_ipjpsm4E(Request $request, $id)
    {
        $user = auth()->user();
        $form4E = Form4E::find($id);

        if (!$form4E) {
            return redirect()->back()->with('error', 'Form not found');
        }

        $form4E->status = $request->status;
        $form4E->save();

        UlasanIpjpsm::create([
            'ulasan' => $request->ulasan_ipjpsm,
            'user_id' => $user->id,
            'form4es_id' => $id,
        ]);

        return redirect()->route('shuttle-4-listE', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }
}
