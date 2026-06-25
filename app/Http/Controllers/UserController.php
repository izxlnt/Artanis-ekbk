<?php

namespace App\Http\Controllers;

use App\Mail\Registration\SendRegistrationMail;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\PenggunaKilang;
use App\Models\Pengumuman;
use App\Models\PengumumanIpjpsm;
use App\Models\PengumumanJpn;
use App\Models\PenjualanKumai;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\UlasanIpjpsm;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Rules\UniqueEmailAcrossAllTables;
use App\Rules\MalaysianIC;
use App\Models\KemasukanBahan;
use App\Services\FormFlowService;
use App\Services\FormRequirementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index_user()
    {

        $user = Auth::user();
        
        // Initialize Form Requirement Service
        $formRequirementService = new FormRequirementService();
        $currentYear = date("Y");
        
        // Get required forms based on user registration date
        $requirements = $formRequirementService->getRequiredForms($user->created_at, $currentYear);
        
        // Get dashboard tasks for display
        $tugasan = $formRequirementService->getDashboardTasks($user, $currentYear);

        //=========================== checker Batch ===============================================
        // Create batches for all required years
        foreach ($requirements['years_to_fill'] as $year) {
            $batch_checker = Batch::where('shuttle_id', $user->shuttle_id)->where('tahun', $year)->count();
            if ($batch_checker == '0' && !empty($requirements['months_to_fill'][$year])) {
                // Only create batches for required months
                foreach ($requirements['months_to_fill'][$year] as $month) {
                    $batch = Batch::create([
                        'shuttle_id' => $user->shuttle_id,
                        'status' => 'Tidak Diisi',
                        'tahun' => $year,
                        'bulan' => $month,
                        'borang_a' => "0",
                        'borang_b' => "0",
                        'borang_c' => "0",
                        'borang_d' => "0",
                        'borang_e' => "0",
                    ]);
                }
            }
        }



        //=========================== checker A (Shuttle 3,4,5) ===============================================
        // Create FormA for all required years
        foreach ($requirements['forma_required'] as $year) {
            $formA_checker = FormA::where('shuttle_id', $user->shuttle_id)->where('tahun', $year)->count();
            if ($formA_checker == '0') {
                $formas = FormA::create([
                    'shuttle_id' => $user->shuttle_id,
                    'status' => 'Tidak Diisi',
                    'tahun' => $year,
                ]);
            }
        }



        //=========================== checker B (Shuttle 3,4,5) ===============================================
        // Create FormB for all required years and quarters
        $status = 'Tidak Diisi';
        
        foreach ($requirements['years_to_fill'] as $year) {
            if (!empty($requirements['quarters_to_fill'][$year])) {
                foreach ($requirements['quarters_to_fill'][$year] as $quarter) {
                    $formB_exists = FormB::where('shuttle_id', $user->shuttle_id)
                        ->where('tahun', $year)
                        ->where('suku_tahun', $quarter)
                        ->count();
                    
                    if ($formB_exists == '0') {
                        $quarterDates = [
                            1 => ['buka' => $year.'-03-01', 'tutup' => $year.'-04-01'],
                            2 => ['buka' => $year.'-06-01', 'tutup' => $year.'-07-01'],
                            3 => ['buka' => $year.'-09-01', 'tutup' => $year.'-10-01'],
                            4 => ['buka' => $year.'-12-01', 'tutup' => $year.'-12-31'],
                        ];
                        
                        $formbs = FormB::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => $year,
                            'suku_tahun' => $quarter,
                            'tarikh_buka_borang' => $quarterDates[$quarter]['buka'],
                            'tarikh_tutup_borang' => $quarterDates[$quarter]['tutup'],
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    }
                }
            }
        }



        //=========================== checker C (Shuttle 3,4,5) ===============================================
        // Create FormC for all required years and months
        $status = 'Tidak Diisi';
        
        $monthDates = [
            1 => ['buka' => '-01-01', 'tutup' => '-02-01'],
            2 => ['buka' => '-02-01', 'tutup' => '-03-01'],
            3 => ['buka' => '-03-01', 'tutup' => '-04-01'],
            4 => ['buka' => '-04-01', 'tutup' => '-05-01'],
            5 => ['buka' => '-05-01', 'tutup' => '-06-01'],
            6 => ['buka' => '-06-01', 'tutup' => '-07-01'],
            7 => ['buka' => '-07-01', 'tutup' => '-08-01'],
            8 => ['buka' => '-08-01', 'tutup' => '-09-01'],
            9 => ['buka' => '-09-01', 'tutup' => '-10-01'],
            10 => ['buka' => '-10-01', 'tutup' => '-11-01'],
            11 => ['buka' => '-11-01', 'tutup' => '-12-01'],
            12 => ['buka' => '-12-01', 'tutup' => '-12-31'],
        ];
        
        foreach ($requirements['years_to_fill'] as $year) {
            if (!empty($requirements['months_to_fill'][$year])) {
                foreach ($requirements['months_to_fill'][$year] as $month) {
                    FormC::firstOrCreate(
                        ['shuttle_id' => $user->shuttle_id, 'tahun' => $year, 'bulan' => $month],
                        [
                            'shuttle_type'        => $user->shuttle_type,
                            'status'              => $status,
                            'tarikh_buka_borang'  => $year . $monthDates[$month]['buka'],
                            'tarikh_tutup_borang' => $year . $monthDates[$month]['tutup'],
                            'nama_kilang'         => $user->shuttle->nama_kilang,
                            'no_ssm'              => $user->shuttle->no_ssm,
                            'no_lesen'            => $user->shuttle->no_lesen,
                        ]
                    );
                }
            }
        }

        //=========================== checker D ==============================================
        $shuttle_type = $user->shuttle->shuttle_type;


        if ($shuttle_type == 3) {  //=========================== checker D (Shuttle 3) ===============================================
            // Create FormD for all required years and months
            foreach ($requirements['years_to_fill'] as $year) {
                if (!empty($requirements['months_to_fill'][$year])) {
                    foreach ($requirements['months_to_fill'][$year] as $month) {
                        $formD_exists = FormD::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('bulan', $month)
                            ->count();
                        
                        if ($formD_exists == '0') {
                            $formds = FormD::create([
                                'shuttle_id' => $user->shuttle_id,
                                'shuttle_type' => $user->shuttle_type,
                                'status' => $status,
                                'tahun' => $year,
                                'bulan' => $month,
                                'tarikh_buka_borang' => $year . $monthDates[$month]['buka'],
                                'tarikh_tutup_borang' => $year . $monthDates[$month]['tutup'],
                                'nama_kilang' => $user->shuttle->nama_kilang,
                                'no_ssm' => $user->shuttle->no_ssm,
                                'no_lesen' => $user->shuttle->no_lesen,
                            ]);
                        }
                    }
                }
            }
        } elseif ($shuttle_type == 4) { //=========================== checker D (Shuttle 4) ===============================================
            // Create Form4D for all required years and months
            foreach ($requirements['years_to_fill'] as $year) {
                if (!empty($requirements['months_to_fill'][$year])) {
                    foreach ($requirements['months_to_fill'][$year] as $month) {
                        $formD_exists = Form4D::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('bulan', $month)
                            ->count();
                        
                        if ($formD_exists == '0') {
                            $formds = Form4D::create([
                                'shuttle_id' => $user->shuttle_id,
                                'shuttle_type' => $user->shuttle_type,
                                'status' => $status,
                                'tahun' => $year,
                                'bulan' => $month,
                                'tarikh_buka_borang' => $year . $monthDates[$month]['buka'],
                                'tarikh_tutup_borang' => $year . $monthDates[$month]['tutup'],
                                'nama_kilang' => $user->shuttle->nama_kilang,
                                'no_ssm' => $user->shuttle->no_ssm,
                                'no_lesen' => $user->shuttle->no_lesen,
                            ]);
                        }
                    }
                }
            }
        } elseif ($shuttle_type == 5) { //=========================== checker D (Shuttle 5) ===============================================
            // Create Form5D for all required years and months
            foreach ($requirements['years_to_fill'] as $year) {
                if (!empty($requirements['months_to_fill'][$year])) {
                    foreach ($requirements['months_to_fill'][$year] as $month) {
                        $formD_exists = Form5D::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('bulan', $month)
                            ->count();
                        
                        if ($formD_exists == '0') {
                            $formds = Form5D::create([
                                'shuttle_id' => $user->shuttle_id,
                                'shuttle_type' => $user->shuttle_type,
                                'status' => $status,
                                'tahun' => $year,
                                'bulan' => $month,
                                'tarikh_buka_borang' => $year . $monthDates[$month]['buka'],
                                'tarikh_tutup_borang' => $year . $monthDates[$month]['tutup'],
                                'nama_kilang' => $user->shuttle->nama_kilang,
                                'no_ssm' => $user->shuttle->no_ssm,
                                'no_lesen' => $user->shuttle->no_lesen,
                            ]);
                        }
                    }
                }
            }
        }

        //=========================== checker E ==============================================

        if ($shuttle_type == 4) { //=========================== checker E (Shuttle 4 )==============================================
            // Create Form4E for all required years and months
            foreach ($requirements['years_to_fill'] as $year) {
                if (!empty($requirements['months_to_fill'][$year])) {
                    foreach ($requirements['months_to_fill'][$year] as $month) {
                        $formE_exists = Form4E::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('bulan', $month)
                            ->count();
                        
                        if ($formE_exists == '0') {
                            $formes = Form4E::create([
                                'shuttle_id' => $user->shuttle_id,
                                'shuttle_type' => $user->shuttle_type,
                                'status' => $status,
                                'tahun' => $year,
                                'bulan' => $month,
                                'tarikh_buka_borang' => $year . $monthDates[$month]['buka'],
                                'tarikh_tutup_borang' => $year . $monthDates[$month]['tutup'],
                                'nama_kilang' => $user->shuttle->nama_kilang,
                                'no_ssm' => $user->shuttle->no_ssm,
                                'no_lesen' => $user->shuttle->no_lesen,
                            ]);
                        }
                    }
                }
            }
        } elseif ($shuttle_type == 5) { //=========================== checker E (Shuttle 5 )==============================================
            // Create Form5E for all required years and months
            foreach ($requirements['years_to_fill'] as $year) {
                if (!empty($requirements['months_to_fill'][$year])) {
                    foreach ($requirements['months_to_fill'][$year] as $month) {
                        $formE_exists = Form5E::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('bulan', $month)
                            ->count();
                        
                        if ($formE_exists == '0') {
                            $formes = Form5E::create([
                                'shuttle_id' => $user->shuttle_id,
                                'shuttle_type' => $user->shuttle_type,
                                'status' => $status,
                                'tahun' => $year,
                                'bulan' => $month,
                                'tarikh_buka_borang' => $year . $monthDates[$month]['buka'],
                                'tarikh_tutup_borang' => $year . $monthDates[$month]['tutup'],
                                'nama_kilang' => $user->shuttle->nama_kilang,
                                'no_ssm' => $user->shuttle->no_ssm,
                                'no_lesen' => $user->shuttle->no_lesen,
                            ]);
                        }
                    }
                }
            }
        }

        // Count Display home page
        //count shuttle 3 home page ibk

        $shuttleId = auth()->user()->shuttle_id;
        $year = date('Y');

        $excludedStatuses = ['Tidak Diisi', 'Tidak Lengkap', 'Sedang Diisi', 'Ditutup'];

        $formA_count = FormA::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $formB_count = FormB::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $formC_count = FormC::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $formD_count = FormD::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        // shuttle 4 counts
        $form4A_count = FormA::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form4B_count = FormB::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form4C_count = FormC::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form4D_count = Form4D::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form4E_count = Form4E::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        // shuttle 5 counts
        $form5A_count = FormA::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form5B_count = FormB::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form5C_count = FormC::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form5D_count = Form5D::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $form5E_count = Form5E::whereNotIn('status', $excludedStatuses)
            ->where('tahun', $year)->where('shuttle_id', $shuttleId)->count();

        $user_daerah = Auth::user()->shuttle->daerah_id;

        $pengumuman = Pengumuman::where('daerah_hutan', $user_daerah)->orderBy('created_at', 'DESC')->get();
        if ($pengumuman->isEmpty()) {
            $pengumuman = null;
        }

        // Build indexed form data for senarai tugasan table
        $currentMonth = (int) date('n');
        $tableData = [];
        $flowData   = [];
        foreach ($requirements['years_to_fill'] as $reqYear) {
            $tableData[$reqYear]['formA'] = FormA::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->first();
            $tableData[$reqYear]['formB'] = FormB::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('suku_tahun');
            $tableData[$reqYear]['formC'] = FormC::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('bulan');
            if ($shuttle_type == 3) {
                $tableData[$reqYear]['formD'] = FormD::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('bulan');
            } elseif ($shuttle_type == 4) {
                $tableData[$reqYear]['formD'] = Form4D::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('bulan');
                $tableData[$reqYear]['formE'] = Form4E::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('bulan');
            } elseif ($shuttle_type == 5) {
                $tableData[$reqYear]['formD'] = Form5D::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('bulan');
                $tableData[$reqYear]['formE'] = Form5E::where('shuttle_id', $shuttleId)->where('tahun', $reqYear)->get()->keyBy('bulan');
            }
            $flowData[$reqYear] = FormFlowService::getStatus($shuttleId, (int) $shuttle_type, (int) $reqYear);
        }

        return view('home-user', compact(
            'user',
            'formA_count',
            'formB_count',
            'formC_count',
            'formD_count',
            'form4A_count',
            'form4B_count',
            'form4C_count',
            'form4D_count',
            'form4E_count',
            'form5A_count',
            'form5B_count',
            'form5C_count',
            'form5D_count',
            'form5E_count',
            'pengumuman',
            'tugasan',
            'tableData',
            'flowData',
            'requirements',
            'currentMonth'
        ));
    }


    public function user_management()
    {
        $user = User::where('shuttle_id', Auth::user()->shuttle_id)->where('pengguna_kilang_id', '!=', null)->get();


        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('home-user.user-management', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('home-user-management', compact('returnArr', 'user'));
    }

    public function user_management_add()
    {
        // dd(auth()->user()->shuttle_id);

        $user_counter = User::where('shuttle_id', Auth::user()->shuttle_id)->where('pengguna_kilang_id', '!=', null)->where('status', '1')->count();
        // $user_counter = User::where('shuttle_id', Auth::user()->shuttle_id)->where('pengguna_kilang_id', '!=', null)->count();
        // dd($user_counter);

        if ($user_counter >= 2) {
            return redirect()->back()->with("error", "Setiap kilang boleh mendaftar terhad kepada dua pengguna aktif sahaja.");
        }

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('home-user.user-management', date('Y')), 'name' => "Pengurusan Pengguna"],
            ['link' => route('home-user.user-management.add', date('Y')), 'name' => "Pendaftaran Pengguna Kilang Kedua"],
        ];

        $kembali = route('home-user.user-management', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('home-user-management-add', compact('returnArr'));
    }

    public function user_management_create(Request $request)
    {

        $this->validatorAddUser($request->all())->validate();

        $shuttle = Shuttle::findorfail(auth()->user()->shuttle_id);

        $gambar_ic_hadapan = NULL;
        $gambar_ic_belakang = NULL;
        $gambar_passport = NULL;
        $gambar_kad_pekerja = NULL;

        if ($request->gambar_ic_hadapan) {
            $gambar_ic_hadapan = $request->file('gambar_ic_hadapan')->store('public/uploads');
        }

        if ($request->gambar_ic_belakang) {
            $gambar_ic_belakang = $request->file('gambar_ic_belakang')->store('public/uploads');
        }

        if ($request->gambar_kad_pekerja) {
            $gambar_kad_pekerja = $request->file('gambar_kad_pekerja')->store('public/uploads');
        }

        if ($request->gambar_passport) {
            $gambar_passport = $request->file('gambar_passport')->store('public/uploads');
        }

        // $gambar_ic_hadapan = $request->file('gambar_ic_hadapan')->store('public/uploads');
        // $gambar_ic_belakang = $request->file('gambar_ic_belakang')->store('public/uploads');
        // $gambar_passport = $request->file('gambar_passport')->store('public/uploads');
        // $gambar_kad_pekerja = $request->file('gambar_kad_pekerja')->store('public/uploads');

        $pengguna_kilang = PenggunaKilang::create([
            'name' => $request->name,
            'jantina' => $request->jantina,
            'warganegara' => $request->warganegara,
            'kaum' => $request->kaum,
            'email' => $request->email,
            'no_kad_pengenalan' => $request->no_kad_pengenalan,

            'gambar_ic_hadapan' => $gambar_ic_hadapan,
            'gambar_ic_belakang' => $gambar_ic_belakang,
            'gambar_passport' => $gambar_passport,

            'jawatan' => $request->jawatan,
            'no_pekerja' => $request->no_pekerja,
            'gambar_kad_pekerja' => $gambar_kad_pekerja,

            'shuttle_type' => $shuttle->shuttle_type,
            'shuttle_id' => $shuttle->id,
        ]);

        $password = Str::random(8);
        $hashed_random_password = Hash::make($password);
        $kategori_pengguna = "IBK";

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashed_random_password,
            'kategori_pengguna' => $kategori_pengguna,
            'login_id' => $request->no_kad_pengenalan,
            'shuttle_type' => $shuttle->shuttle_type,
            'is_approved' => 0,
            'shuttle_id' => $shuttle->id,
            'pengguna_kilang_id' => $pengguna_kilang->id,
        ]);

        //notification register 2nd users
        Mail::to($user)->send(new SendRegistrationMail($user, $hashed_random_password));

        return redirect('/pengguna/pengurusan-pengguna')->with('success', 'Pengguna baru telah berjaya didaftarkan. Sila tunggu pengesahan akaun daripada pentadbir sistem.');
    }

    protected function validatorAddUser(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'jantina' => ['required', 'string', 'max:255'],
            'warganegara' => ['required', 'string', 'max:255'],
            'kaum' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', new UniqueEmailAcrossAllTables()],
            'no_kad_pengenalan' => ['required', 'string', 'max:12', new MalaysianIC, 'unique:pengguna_kilangs'],

            'gambar_ic_hadapan' => 'required|image|mimes:jpeg,jpg,png|max:8192',
            'gambar_ic_belakang' => 'required|image|mimes:jpeg,jpg,png|max:8192',
            'gambar_passport' => 'required|image|mimes:jpeg,jpg,png|max:8192',


            'jawatan' => ['required', 'string', 'max:255'],
            'gambar_kad_pekerja' => 'image|mimes:jpeg,jpg,png|max:8192',

        ]);
    }

    public function user_status_update(Request $request)
    {
        if ($request->has('user_id_disable')) {
            $user_id = $request->user_id_disable;
        } else {
            $user_id = $request->user_id_enable;
        }

        $user = User::findorfail($user_id);

        if ($user->status == 0) {

            //active user checker - must max 2 user
            $user_counter = User::where('shuttle_id', Auth::user()->shuttle_id)->where('pengguna_kilang_id', '!=', null)->where('status', '1')->count();

            if ($user_counter >= 2) {
                return redirect()->back()->with("error", "Setiap kilang boleh mengaktifkan terhad kepada dua pengguna sahaja..");
            }


            $user->status = 1;
            $user->save();
            return redirect()->route('home-user.user-management')->with('success', 'Pengguna telah diaktifkan.');
        } else {
            $user->status = 0;
            $user->save();
            return redirect()->route('home-user.user-management')->with('success', 'Pengguna telah dinyaktif.');
        }
    }

    public function ajax_count_undeclare_shuttle3()
    {
        $count_form3A = FormA::where('status', 'Tidak Diisi')->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', 3);
        })->get();
        $form3A_count = $count_form3A->count();

        if (date('m') == 1 || date('m') == 2 || date('m') == 3) {
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '3')->where('suku_tahun', '1')->get();
            $form3B_count = $count_form3B->count();
        } else if (date('m') == 4 || date('m') == 5 || date('m') == 6) {
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '3')->where('suku_tahun', '2')->get();
            $form3B_count = $count_form3B->count();
        } else if (date('m') == 7 || date('m') == 8 || date('m') == 9) {

            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '3')->where('suku_tahun', '3')->get();
            $form3B_count = $count_form3B->count();
        } else if (date('m') == 10 || date('m') == 11 || date('m') == 12) {
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '3')->where('suku_tahun', '4')->get();

            $form3B_count = $count_form3B->count();
            // dd($form3B_count);
        }

        $count_form3C = FormC::where('status', 'Tidak Diisi')->where('shuttle_type', '3')->where('bulan', date('m'))->get();
        $form3C_count = $count_form3C->count();


        $count_form3D = FormD::where('status', 'Tidak Diisi')->where('shuttle_type', '3')->where('bulan', date('m'))->get();
        $form3D_count = $count_form3D->count();

        $undeclare_shuttle3_count = $form3B_count + $form3C_count + $form3D_count + $form3A_count;


        return response()->json($undeclare_shuttle3_count, 200);
    }

    public function ajax_count_undeclare_shuttle4()
    {


        $count_form4A = FormA::where('status', 'Tidak Diisi')->where('tahun', date("Y"))
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', 4)->whereIn('daerah_id', auth()->user()->daerah_ids);
            })
            ->get();
        $form4A_count = $count_form4A->count();


        // $count_form4B = FormB::where('status','Tidak Diisi')->where('created_at', '>=')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', 4)->whereIn('daerah_id', auth()->user()->daerah_ids);
        //     })
        // ->get();

        if (date('m') == 1 || date('m') == 2 || date('m') == 3) {

            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '4')->where('suku_tahun', '1')->get();
            $form4B_count = $count_form3B->count();
        } else if (date('m') == 4 || date('m') == 5 || date('m') == 6) {
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '4')->where('suku_tahun', '2')->get();
            $form4B_count = $count_form3B->count();
        } else if (date('m') == 7 || date('m') == 8 || date('m') == 9) {

            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '4')->where('suku_tahun', '3')->get();
            $form4B_count = $count_form3B->count();
        } else if (date('m') == 10 || date('m') == 11 || date('m') == 12) {
            // dd('masuk');
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '4')->where('suku_tahun', '4')->get();
            $form4B_count = $count_form3B->count();
        }



        $count_form4C = FormC::where('status', 'Tidak Diisi')->where('shuttle_type', '4')->get();
        $form4C_count = $count_form4C->count();

        $count_form4D = Form4D::where('status', 'Tidak Diisi')->get();
        $form4D_count = $count_form4D->count();

        $count_form4D = Form4E::where('status', 'Tidak Diisi')->get();
        $form4D_count = $count_form4D->count();

        $undeclare_shuttle4_count = $form4B_count + $form4C_count + $form4D_count + $form4A_count;

        return response()->json($undeclare_shuttle4_count, 200);
    }

    public function ajax_count_undeclare_shuttle5()
    {

        $count_form5A = FormA::where('status', 'Tidak Diisi')->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', 5);
        })->get();
        $form5A_count = $count_form5A->count();

        if (date('m') == 1 || date('m') == 2 || date('m') == 3) {

            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '5')->where('suku_tahun', '1')->get();
            $form5B_count = $count_form3B->count();
        } else if (date('m') == 4 || date('m') == 5 || date('m') == 6) {
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '5')->where('suku_tahun', '2')->get();
            $form5B_count = $count_form3B->count();
        } else if (date('m') == 7 || date('m') == 8 || date('m') == 9) {

            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '5')->where('suku_tahun', '3')->get();
            $form5B_count = $count_form3B->count();
        } else if (date('m') == 10 || date('m') == 11 || date('m') == 12) {
            // dd('masuk');
            $count_form3B = FormB::where('status', 'Tidak Diisi')->where('shuttle_type', '5')->where('suku_tahun', '4')->get();
            $form5B_count = $count_form3B->count();
        }

        $count_form5C = FormC::where('status', 'Tidak Diisi')->where('shuttle_type', '5')->get();
        $form5C_count = $count_form5C->count();

        $count_form5D = Form5D::where('status', 'Tidak Diisi')->get();
        $form5D_count = $count_form5D->count();

        $count_form5D = Form5E::where('status', 'Tidak Diisi')->get();
        $form5D_count = $count_form5D->count();

        $undeclare_shuttle5_count = $form5B_count + $form5C_count + $form5D_count + $form5A_count;

        return response()->json($undeclare_shuttle5_count, 200);
    }

    public function ajax_count_tugasan_phd_shuttle3()
    {
        $currentYear = date('Y');
        $daerahIds = auth()->user()->daerah_ids;

        $count_form3A = FormA::where('status', 'Sedang Diproses')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->where('shuttle_type', 3)->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form3B = FormB::where('status', 'Sedang Diproses')
            ->where('shuttle_type', '3')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form3C = FormC::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '3')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form3D = FormD::where('status', 'Sedang Diproses')
            ->where('shuttle_type', '3')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $shuttle3_count = $count_form3A + $count_form3B + $count_form3C + $count_form3D;

        return response()->json($shuttle3_count, 200);
    }



    public function ajax_count_tugasan_phd_shuttle4()
    {
        $currentYear = date('Y');
        $daerahIds = auth()->user()->daerah_ids;

        $count_form4A = FormA::where('status', 'Sedang Diproses')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds)->where('shuttle_type', '4');
            })->count();

        $count_form4B = FormB::where('status', 'Sedang Diproses')
            ->where('shuttle_type', '4')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form4C = FormC::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '4')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form4D = Form4D::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '4')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form4E = Form4E::where('status', 'Sedang Diproses')
            ->where('shuttle_type', '4')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $shuttle4_count = $count_form4A + $count_form4B + $count_form4C + $count_form4D + $count_form4E;

        return response()->json($shuttle4_count, 200);
    }

    public function ajax_count_tugasan_phd_shuttle5()
    {
        $currentYear = date('Y');
        $daerahIds = auth()->user()->daerah_ids;

        $count_form5A = FormA::where('status', 'Sedang Diproses')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->where('shuttle_type', 5)->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form5B = FormB::where('status', 'Sedang Diproses')
            ->where('shuttle_type', '5')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form5C = FormC::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '5')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form5D = Form5D::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '5')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $count_form5E = Form5E::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '5')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $shuttle5_count = $count_form5A + $count_form5B + $count_form5C + $count_form5D + $count_form5E;

        return response()->json($shuttle5_count, 200);
    }


    public function ajax_count_tugasan_jpn_shuttle3()
    {
        $count_form3A = FormA::where('status', 'Sedang Diproses')->where('shuttle_type','3')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();
        $form3A_count = $count_form3A->count();

        // $count_form3B = FormB::where('status','Sedang Diproses')->where('shuttle_type','3')->get();
        // $form3B_count = $count_form3B->count();

        $count_form3B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '3')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form3B_count = $count_form3B->count();

        // $count_form3C = FormC::where('status','Sedang Diproses')->where('shuttle_type','3')->get();
        // $form3C_count = $count_form3C->count();

        $count_form3C = FormC::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '3')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form3C_count = $count_form3C->count();

        // $count_form3D = FormD::where('status','Sedang Diproses')->where('shuttle_type','3')->get();
        // $form3D_count = $count_form3D->count();

        $count_form3D = FormD::where('status', 'Sedang Diproses')->where('shuttle_type', '3')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form3D_count = $count_form3D->count();

        $shuttle3_count = $form3B_count + $form3C_count + $form3D_count + $form3A_count;

        return response()->json($shuttle3_count, 200);
    }



    public function ajax_count_tugasan_jpn_shuttle4()
    {


        $count_form4A = FormA::where('status', 'Sedang Diproses')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form4A_count = $count_form4A->count();

        // $count_form4B = FormB::where('status','Sedang Diproses')->where('shuttle_type','4')->get();
        // $form4B_count = $count_form4B->count();

        $count_form4B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form4B_count = $count_form4B->count();

        // $count_form4C = FormC::where('status','Sedang Diproses')->where('shuttle_type','4')->get();
        // $form4C_count = $count_form4C->count();

        $count_form4C = FormC::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form4C_count = $count_form4C->count();

        // $count_form4D = Form4D::where('status','Sedang Diproses')->get();
        // $form4D_count = $count_form4D->count();

        $count_form4D = Form4D::where('status', 'Sedang Diproses')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();



        $form4D_count = $count_form4D->count();

        // $count_form4D = Form4E::where('status','Sedang Diproses')->get();
        // $form4D_count = $count_form4D->count();

        $count_form4E = Form4E::where('status', 'Sedang Diproses')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();

        $form4E_count = $count_form4E->count();

        $shuttle4_count = $form4B_count + $form4C_count + $form4D_count + $form4A_count + $form4E_count;

        return response()->json($shuttle4_count, 200);
    }

    public function ajax_count_tugasan_jpn_shuttle5()
    {

        $count_form5A = FormA::where('status', 'Sedang Diproses')->where('shuttle_type', '5')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();
        $form5A_count = $count_form5A->count();

        $count_form5B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })->get();
        $form5B_count = $count_form5B->count();

        $count_form5C = FormC::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form5C_count = $count_form5C->count();

        $count_form5D = Form5D::where(function ($query) {
            $query->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form5D_count = $count_form5D->count();

        $count_form5E = Form5E::where('status', 'Sedang Diproses')->where('shuttle_type', '5')
        ->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })
        ->get();
        $form5E_count = $count_form5E->count();

        $shuttle5_count = $form5B_count + $form5C_count + $form5D_count + $form5A_count + $form5E_count;

        return response()->json($shuttle5_count, 200);
    }

    public function ajax_count_tugasan_phd_detail(Request $request)
    {
        $currentYear = date('Y');
        $shuttle_type = (int) ($request->shuttle_type ?? 3);
        $daerahIds = auth()->user()->daerah_ids;

        $formA = FormA::where('status', 'Sedang Diproses')
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($shuttle_type, $daerahIds) {
                $q->where('shuttle_type', $shuttle_type)->whereIn('daerah_id', $daerahIds);
            })->count();

        $formB = FormB::where('status', 'Sedang Diproses')
            ->where('shuttle_type', (string) $shuttle_type)
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $formC = FormC::where(function ($q) {
            $q->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', (string) $shuttle_type)
            ->where('tahun', $currentYear)
            ->whereHas('shuttle', function ($q) use ($daerahIds) {
                $q->whereIn('daerah_id', $daerahIds);
            })->count();

        $result = ['formA' => $formA, 'formB' => $formB, 'formC' => $formC];

        if ($shuttle_type === 3) {
            $result['formD'] = FormD::where('status', 'Sedang Diproses')
                ->where('shuttle_type', '3')->where('tahun', $currentYear)
                ->whereHas('shuttle', function ($q) use ($daerahIds) { $q->whereIn('daerah_id', $daerahIds); })->count();
        } elseif ($shuttle_type === 4) {
            $result['formD'] = Form4D::where(function ($q) {
                $q->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
            })->where('shuttle_type', '4')->where('tahun', $currentYear)
                ->whereHas('shuttle', function ($q) use ($daerahIds) { $q->whereIn('daerah_id', $daerahIds); })->count();
            $result['formE'] = Form4E::where('status', 'Sedang Diproses')
                ->where('shuttle_type', '4')->where('tahun', $currentYear)
                ->whereHas('shuttle', function ($q) use ($daerahIds) { $q->whereIn('daerah_id', $daerahIds); })->count();
        } elseif ($shuttle_type === 5) {
            $result['formD'] = Form5D::where(function ($q) {
                $q->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
            })->where('shuttle_type', '5')->where('tahun', $currentYear)
                ->whereHas('shuttle', function ($q) use ($daerahIds) { $q->whereIn('daerah_id', $daerahIds); })->count();
            $result['formE'] = Form5E::where(function ($q) {
                $q->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
            })->where('shuttle_type', '5')->where('tahun', $currentYear)
                ->whereHas('shuttle', function ($q) use ($daerahIds) { $q->whereIn('daerah_id', $daerahIds); })->count();
        }

        return response()->json($result, 200);
    }

    public function ajax_count_tugasan_jpn_detail(Request $request)
    {
        $shuttle_type = (int) ($request->shuttle_type ?? 3);

        $formA = FormA::where('status', 'Sedang Diproses')
            ->where('shuttle_type', (string) $shuttle_type)
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })->count();

        $formB = FormB::where('status', 'Sedang Diproses')
            ->where('shuttle_type', (string) $shuttle_type)
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })->count();

        $formC = FormC::where(function ($q) {
            $q->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', (string) $shuttle_type)
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })->count();

        $result = ['formA' => $formA, 'formB' => $formB, 'formC' => $formC];

        if ($shuttle_type === 3) {
            $result['formD'] = FormD::where('status', 'Sedang Diproses')
                ->where('shuttle_type', '3')
                ->whereHas('shuttle', function ($q) { $q->where('negeri_id', auth()->user()->negeri); })->count();
        } elseif ($shuttle_type === 4) {
            $result['formD'] = Form4D::where('status', 'Sedang Diproses')
                ->where('shuttle_type', '4')
                ->whereHas('shuttle', function ($q) { $q->where('negeri_id', auth()->user()->negeri); })->count();
            $result['formE'] = Form4E::where('status', 'Sedang Diproses')
                ->where('shuttle_type', '4')
                ->whereHas('shuttle', function ($q) { $q->where('negeri_id', auth()->user()->negeri); })->count();
        } elseif ($shuttle_type === 5) {
            $result['formD'] = Form5D::where(function ($q) {
                $q->where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran');
            })->where('shuttle_type', '5')
                ->whereHas('shuttle', function ($q) { $q->where('negeri_id', auth()->user()->negeri); })->count();
            $result['formE'] = Form5E::where('status', 'Sedang Diproses')
                ->where('shuttle_type', '5')
                ->whereHas('shuttle', function ($q) { $q->where('negeri_id', auth()->user()->negeri); })->count();
        }

        return response()->json($result, 200);
    }

    public function index_phd()
    {
        $daerahIds = auth()->user()->daerah_ids;

        $count_shuttle3 = User::where('shuttle_type', 3)->where('is_approved', 1)->whereNull('pengguna_kilang_id')
            ->whereHas('shuttle', fn($q) => $q->whereIn('daerah_id', $daerahIds))->count();

        $count_shuttle4 = User::where('shuttle_type', 4)->where('is_approved', 1)->whereNull('pengguna_kilang_id')
            ->whereHas('shuttle', fn($q) => $q->whereIn('daerah_id', $daerahIds))->count();

        $count_shuttle5 = User::where('shuttle_type', 5)->where('is_approved', 1)->whereNull('pengguna_kilang_id')
            ->whereHas('shuttle', fn($q) => $q->whereIn('daerah_id', $daerahIds))->count();

        $placeholders = implode(',', array_fill(0, count($daerahIds), '?'));

        $s3 = DB::select("SELECT COUNT(shuttles.daerah_id) as total_kilang
            FROM form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE shuttles.shuttle_type = '3'
            AND shuttles.daerah_id IN ($placeholders)
            AND YEAR(date(form_a_s.created_at)) = YEAR(now())
            AND form_a_s.status IN ('Dihantar ke IPJPSM', 'Sedang Diproses')", $daerahIds);

        $s4 = DB::select("SELECT COUNT(shuttles.daerah_id) as total_kilang
            FROM form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE shuttles.shuttle_type = '4'
            AND shuttles.daerah_id IN ($placeholders)
            AND YEAR(date(form_a_s.created_at)) = YEAR(now())
            AND form_a_s.status IN ('Dihantar ke IPJPSM', 'Sedang Diproses')", $daerahIds);

        $s5 = DB::select("SELECT COUNT(shuttles.daerah_id) as total_kilang
            FROM form_a_s
            INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
            WHERE shuttles.shuttle_type = '5'
            AND shuttles.daerah_id IN ($placeholders)
            AND YEAR(date(form_a_s.created_at)) = YEAR(now())
            AND form_a_s.status IN ('Dihantar ke IPJPSM', 'Sedang Diproses')", $daerahIds);

        $pengumuman_jpn = PengumumanJpn::where('negeri', auth()->user()->negeri)
            ->orderBy('created_at', 'DESC')->get();
        if ($pengumuman_jpn->isEmpty()) {
            $pengumuman_jpn = null;
        }

        return view('home-phd', compact(
            'count_shuttle3',
            'count_shuttle4',
            'count_shuttle5',
            's3',
            's4',
            's5',
            'pengumuman_jpn'
        ));
    }

    public function list_kilang_aktif()
    {
        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids);
        })->get();

        // dd($user3);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_aktif', date('Y')), 'name' => "Senarai Kilang Papan Aktif"],
        ];

        $kembali = route('home');


        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }
        else if(auth()->user()->kategori_pengguna == "PHD"){
            $layout = 'layouts.layout-phd-nicepage';
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai_kilang_papan_aktif', compact('user3', 'returnArr','layout'));
    }

    public function list_kilang_aktif_jpn()
    {
        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.senarai_kilang_papan_aktif', date('Y')), 'name' => "Senarai Kilang Papan Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.JPN.senarai_kilang_papan_aktif', compact('user3', 'returnArr'));
    }

    public function list_kilang_aktif_bpm()
    {
        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.senarai_kilang_papan_aktif', date('Y')), 'name' => "Senarai Kilang Papan Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.BPM.senarai_kilang_papan_aktif', compact('user3', 'returnArr'));
    }

    public function list_kilang_aktif_ipjpsm()
    {
        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_aktif_ipjpsm', date('Y')), 'name' => "Senarai Kilang Papan Aktif"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }
        else if(auth()->user()->kategori_pengguna == "PHD"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai_kilang_papan_aktif', compact('user3', 'returnArr','layout'));
    }

    public function list_kilang_papan_lapis_aktif_ipjpsm()
    {
        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_aktif_ipjpsm', date('Y')), 'name' => "Senarai Kilang Papan Aktif"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }
        else if(auth()->user()->kategori_pengguna == "PHD"){
            $layout = 'layouts.layout-bpm-nicepage';
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai_kilang_papan_lapis_aktif_ipjpsm', compact('user4', 'returnArr','layout'));
    }

    public function list_kilang_kumai_aktif_ipjpsm()
    {
        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->get();
        // dd($user5);
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_aktif_ipjpsm', date('Y')), 'name' => "Senarai Kilang Papan Aktif"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }
        else if(auth()->user()->kategori_pengguna == "PHD"){
            $layout = 'layouts.layout-phd-nicepage';
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai_kilang_kumai_aktif_ipjpsm', compact('user5', 'returnArr','layout'));
    }

    public function list_kilang_papan_lapis_aktif()
    {
        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_lapis_aktif', date('Y')), 'name' => "Senarai Kilang Papan Lapis/Venir Aktif"],
        ];

        $kembali = route('home');


        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }
        else if(auth()->user()->kategori_pengguna == "PHD"){
            $layout = 'layouts.layout-phd-nicepage';
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai_kilang_papan_lapis_aktif', compact('user4', 'returnArr','layout'));
    }

    public function list_kilang_papan_lapis_aktif_jpn()
    {
        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_lapis_aktif', date('Y')), 'name' => "Senarai Kilang Papan Lapis/Venir Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.JPN.senarai_kilang_papan_lapis_aktif', compact('user4', 'returnArr'));
    }

    public function list_kilang_papan_lapis_aktif_bpm()
    {
        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_papan_lapis_aktif', date('Y')), 'name' => "Senarai Kilang Papan Lapis/Venir Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.BPM.senarai_kilang_papan_lapis_aktif', compact('user4', 'returnArr'));
    }


    public function list_kilang_kumai_aktif()
    {
        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_kumai_aktif', date('Y')), 'name' => "Senarai Kilang Kayu Kumai Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai_kilang_kumai_aktif', compact('user5', 'returnArr'));
    }

    public function list_kilang_kumai_aktif_jpn()
    {
        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_kumai_aktif', date('Y')), 'name' => "Senarai Kilang Kayu Kumai Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.JPN.senarai_kilang_kumai_aktif', compact('user5', 'returnArr'));
    }

    public function list_kilang_kumai_aktif_bpm()
    {
        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('senarai_kilang_kumai_aktif', date('Y')), 'name' => "Senarai Kilang Kayu Kumai Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.BPM.senarai_kilang_kumai_aktif', compact('user5', 'returnArr'));
    }

    public function index_jpn()
    {
        $negeri = auth()->user()->negeri;

        $count_shuttle3 = User::where('shuttle_type', 3)->where('is_approved', 1)->whereNull('pengguna_kilang_id')
            ->whereHas('shuttle', fn($q) => $q->where('negeri_id', $negeri))->count();

        $count_shuttle4 = User::where('shuttle_type', 4)->where('is_approved', 1)->whereNull('pengguna_kilang_id')
            ->whereHas('shuttle', fn($q) => $q->where('negeri_id', $negeri))->count();

        $count_shuttle5 = User::where('shuttle_type', 5)->where('is_approved', 1)->whereNull('pengguna_kilang_id')
            ->whereHas('shuttle', fn($q) => $q->where('negeri_id', $negeri))->count();

        $pengumuman_ipjpsm = PengumumanIpjpsm::where('negeri', $negeri)
            ->orderBy('created_at', 'DESC')->get();
        if ($pengumuman_ipjpsm->isEmpty()) {
            $pengumuman_ipjpsm = null;
        }

        return view('home-jpn', compact('count_shuttle3', 'count_shuttle4', 'count_shuttle5', 'pengumuman_ipjpsm'));
    }

    public function change_password()
    {
        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'JPN' ? 'layouts.layout-jpn-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : (auth()->user()->kategori_pengguna == 'IBK' ? 'layouts.layout-ibk-nicepage' : ''))));

        // $returnArr = null;
        // dd(auth()->user()->kategori_pengguna);
        if (auth()->user()->kategori_pengguna == 'IBK') {

            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Tukar Kata Laluan"],
            ];

            $kembali = route('home-user');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'PHD') {

            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Tukar Kata Laluan"],
            ];

            $kembali = route('home-phd');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'JPN') {

            $breadcrumbs    = [
                ['link' => route('home-jpn'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Tukar Kata Laluan"],
            ];

            $kembali = route('home-jpn');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'IPJPSM') {

            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Tukar Kata Laluan"],
            ];

            $kembali = route('home');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'BPE') {

            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Tukar Kata Laluan"],
            ];

            $kembali = route('home');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'BPM') {

            $breadcrumbs    = [
                ['link' => route('home-bpm'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Tukar Kata Laluan"],
            ];

            $kembali = route('home-bpm');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        }

        return view('tukar-kata-laluan', compact('returnArr', 'layout'));
    }

    public function update_profile(Request $request)
    {
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail(Auth::user()->id);
        $oldEmail = $user->getCurrentEmail(); // Get the current email from the appropriate table

        // Only validate email if it's being updated
        if ($request->has('email') && $request->email !== $oldEmail) {
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    new \App\Rules\UniqueEmailAcrossAllTables($user->id)
                ]
            ]);
        }

        $info = Shuttle::where('id', $user->shuttle_id)->first();
        $pengguna = PenggunaKilang::where('shuttle_id', $info->id)->first();

        if ($request->has('gambar_ic_hadapan')) {
            $gambar_ic_hadapan = $request->file('gambar_ic_hadapan')->store('public/uploads/') ?? 0;
            $pengguna->gambar_ic_hadapan  = $gambar_ic_hadapan;
        } else if ($request->has('gambar_ic_belakang')) {
            $gambar_ic_belakang = $request->file('gambar_ic_belakang')->store('public/uploads/');
            $pengguna->gambar_ic_belakang  = $gambar_ic_belakang;
        } else if ($request->has('gambar_passport')) {
            $gambar_passport = $request->file('gambar_passport')->store('public/uploads/');
            $pengguna->gambar_passport  = $gambar_passport;
        } else if ($request->has('lesen_kilang') && $request->has('sijil_ssm')) {
            $gambar_ic_hadapan = $request->file('lesen_kilang')->store('public/uploads/');
            $pengguna->gambar_ic_hadapan  = $gambar_ic_hadapan;

            $gambar_ic_belakang = $request->file('lesen_kilang')->store('public/uploads/');
            $pengguna->gambar_ic_belakang  = $gambar_ic_belakang;

            $gambar_passport = $request->file('lesen_kilang')->store('public/uploads/');
            $pengguna->gambar_passport  = $gambar_passport;
        }

        // Update email in user and pengguna_kilang only if email was provided and changed
        if ($request->has('email') && $request->email !== $oldEmail) {
            $pengguna->email = $request->email;
            $user->email = $request->email;
            $user->updated_at = now();
        }

        // Update other editable fields
        if ($request->has('jawatan')) {
            $pengguna->jawatan = $request->jawatan;
        }

        if ($request->has('no_pekerja')) {
            $pengguna->no_pekerja = $request->no_pekerja;
        }

        $user->save();
        $pengguna->save();

        return redirect()->back()->with("success", "Berjaya kemaskini profil.");
    }

    public function update_profile_pengguna()
    {
        // Load user with relationships to support getCurrentEmail() method
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail(auth()->user()->id);

        $info = Shuttle::where('id', $user->shuttle_id)->first();

        $pengguna = PenggunaKilang::where('shuttle_id', $info->id)->first();

        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : (auth()->user()->kategori_pengguna == 'IBK' ? 'layouts.layout-ibk-nicepage' : '')));

        $returnArr = null;

        if (auth()->user()->kategori_pengguna == 'IBK') {

            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Kemaskini Profil"],
            ];

            $kembali = route('home-user');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'PHD') {

            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Kemaskini Profil"],
            ];

            $kembali = route('home-phd');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'JPN') {

            $breadcrumbs    = [
                ['link' => route('home-jpn'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Kemaskini Profil"],
            ];

            $kembali = route('home-jpn');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'IPJPSM') {

            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Kemaskini Profil"],
            ];

            $kembali = route('home');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        } elseif (auth()->user()->kategori_pengguna == 'BPM') {

            $breadcrumbs    = [
                ['link' => route('home-bpm'), 'name' => "Laman Utama"],
                ['link' => route('kemaskini-profil'), 'name' => "Kemaskini Profil"],
            ];

            $kembali = route('home-bpm');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        }

        return view('kemaskini-profil', compact('returnArr', 'user', 'info', 'pengguna', 'layout'));
    }

    public function update_password(Request $request)
    {

        // Validate change password form
        $this->validator($request->all())->validate();

        $user = User::findOrFail(Auth::user()->id);

        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Kata laluan terdahulu tidak sama.");
        }

        if (strcmp($request->get('old_password'), $request->get('password')) == 0) {
            return redirect()->back()->with("error", "Kata laluan terdahulu tidak boleh sama dengan kata laluan sekarang.");
        }

        if (strcmp($request->get('password'), $request->get('password_confirmation')) == 1) {
            return redirect()->back()->with("error", "Kata laluan baru tidak sama.");
        }


        $hashed_random_password = Hash::make($request->get('password'));

        $user->password = $hashed_random_password;

        $user->save();


        return redirect()->route('tukar-kata-laluan')->with("success", "Kata laluan telah ditukar.");
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);
    }

    public function shuttle_3_listA_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormA::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-listA', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-listA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_3_listB_ibk($year)
    {

        $user = auth()->user();


        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormB::where('shuttle_id', $shuttle->id)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormB::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-listB', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-listB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_3_listC_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormC::where('shuttle_id', $shuttle->id)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormC::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-listC', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-listC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_3_listD_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormD::where('shuttle_id', $shuttle->id)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormD::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-listD', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-listD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }


    public function shuttle_3_senaraiA_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        // Auto-create FormA record if it doesn't exist for this year
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->first();
        if (!$list) {
            $list = FormA::create([
                'shuttle_id' => $shuttle->id,
                'tahun' => $year,
                'status' => 'Tidak Diisi',
            ]);
        }

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $startYear = max($registrationYear - 1, $currentYear - 1);

        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $isPreviousYear = ($year < $currentYear);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-senaraiA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'isPreviousYear'));
    }

    public function shuttle_3_senaraiB_ibk($year)
    {

        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $prevRegYear = $registrationYear - 1;
        $startYear = max($prevRegYear, $currentYear - 1);

        // Auto-create FormB records for the requested year if they don't exist
        $quarterDates = [
            1 => [$year . '-01-01', $year . '-03-31'],
            2 => [$year . '-04-01', $year . '-06-30'],
            3 => [$year . '-07-01', $year . '-09-30'],
            4 => [$year . '-10-01', $year . '-12-31'],
        ];
        foreach ($quarterDates as $quarter => $dates) {
            $exists = FormB::where('shuttle_id', $shuttle->id)->where('suku_tahun', $quarter)->where('tahun', $year)->exists();
            if (!$exists) {
                FormB::create([
                    'shuttle_id' => $shuttle->id,
                    'shuttle_type' => $shuttle->shuttle_type,
                    'status' => 'Tidak Diisi',
                    'tahun' => $year,
                    'suku_tahun' => $quarter,
                    'tarikh_buka_borang' => $dates[0],
                    'tarikh_tutup_borang' => $dates[1],
                    'nama_kilang' => $shuttle->nama_kilang,
                    'no_ssm' => $shuttle->no_ssm,
                    'no_lesen' => $shuttle->no_lesen,
                ]);
            }
        }

        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->orderBy('suku_tahun')->get();

        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-3-senaraiB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_3_senaraiC_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        // Query Form C records - get one record per month (latest by ID)
        $list = FormC::where('shuttle_id', $shuttle->id)
            ->where('tahun', $year)
            ->orderBy('bulan')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('bulan')
            ->values(); // Reset array keys after unique

        // Get years where data exists, but filter by registration date
        $year_list = FormC::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        // Filter out years before registration if shuttle has registration date
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $currentYear = date('Y');
            
            // Only show years from registration year up to previous year (block years more than 1 year old)
            $year_list = $year_list->filter(function($item) use ($registrationYear, $currentYear) {
                return $item->tahun >= ($registrationYear - 1) && $item->tahun >= ($currentYear - 1);
            });
        }

        // Ensure prevRegYear appears in year_list (Dec of prev reg year is mandatory starting month)
        if ($shuttle && $shuttle->created_at) {
            $prevRegYearCheck = date('Y', strtotime($shuttle->created_at)) - 1;
            if ($prevRegYearCheck >= ($currentYear - 1) && !$year_list->contains('tahun', $prevRegYearCheck)) {
                $year_list->push((object)['tahun' => $prevRegYearCheck]);
                $year_list = $year_list->sortBy('tahun')->values();
            }
            // Also ensure registrationYear itself appears (shuttles registered in a prior year need access to that year)
            $regYearCheck = date('Y', strtotime($shuttle->created_at));
            if ($regYearCheck >= ($currentYear - 1) && !$year_list->contains('tahun', $regYearCheck)) {
                $year_list->push((object)['tahun' => $regYearCheck]);
                $year_list = $year_list->sortBy('tahun')->values();
            }
        }

        // If no data exists but shuttle is registered, show current year
        if ($year_list->isEmpty()) {
            $currentYear = date('Y');
            $year_list = collect();
            $year_list->push((object)['tahun' => $currentYear]);
        }

        // Registration date vars
        $registrationDate = $shuttle->created_at;
        $registrationYear = date('Y', strtotime($registrationDate));
        $currentYear = date('Y');
        $prevRegYear = $registrationYear - 1;

        // Always ensure December of previous registration year exists (mandatory starting month)
        $decPrevRegYear = FormC::where('shuttle_id', $shuttle->id)->where('bulan', 12)->where('tahun', $prevRegYear)->first();
        if (!$decPrevRegYear) {
            $decPrevRegYear = new FormC();
            $decPrevRegYear->shuttle_id = $shuttle->id;
            $decPrevRegYear->bulan = 12;
            $decPrevRegYear->tahun = $prevRegYear;
            $decPrevRegYear->status = 'Tidak Diisi';
            $decPrevRegYear->created_at = $prevRegYear . '-12-01';
            $decPrevRegYear->tarikh_buka_borang = $prevRegYear . '-12-01';
            $decPrevRegYear->tarikh_tutup_borang = $prevRegYear . '-12-31';
            $decPrevRegYear->save();
        }

        // Ensure all 12 months exist for the viewed year (skip for prevRegYear — only December needed there)
        if ($year != $prevRegYear) {
            for ($month = 1; $month <= 12; $month++) {
                $existingRecord = FormC::where('shuttle_id', $shuttle->id)
                    ->where('bulan', $month)
                    ->where('tahun', $year)
                    ->first();

                if (!$existingRecord) {
                    $newFormC = new FormC();
                    $newFormC->shuttle_id = $shuttle->id;
                    $newFormC->bulan = $month;
                    $newFormC->tahun = $year;
                    $newFormC->status = 'Tidak Diisi';
                    $newFormC->created_at = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                    $newFormC->tarikh_buka_borang = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                    $newFormC->tarikh_tutup_borang = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . date('t', strtotime($year . '-' . $month . '-01'));
                    $newFormC->save();
                }
            }
        }

        // Re-query to get all months including newly created ones
        $list = FormC::where('shuttle_id', $shuttle->id)
            ->where('tahun', $year)
            ->orderBy('bulan')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('bulan')
            ->values();

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-3-senaraiC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_3_senaraiD_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormD::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();

        // Get years where data exists, but filter by registration date
        $year_list = FormD::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        // Filter out years before registration if shuttle has registration date
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $currentYear = date('Y');
            
            // Only show years from registration year up to previous year (block years more than 1 year old)
            $year_list = $year_list->filter(function($item) use ($registrationYear, $currentYear) {
                return $item->tahun >= ($registrationYear - 1) && $item->tahun >= ($currentYear - 1);
            });
        }

        // Ensure prevRegYear appears in year_list even if no FormD records exist for it yet
        if ($shuttle && $shuttle->created_at) {
            $prevRegYear = date('Y', strtotime($shuttle->created_at)) - 1;
            if ($prevRegYear >= ($currentYear - 1) && !$year_list->contains('tahun', $prevRegYear)) {
                $year_list->push((object)['tahun' => $prevRegYear]);
                $year_list = $year_list->sortBy('tahun')->values();
            }
        }

        // If no data exists but shuttle is registered, show current year
        if ($year_list->isEmpty()) {
            $currentYear = date('Y');
            $year_list = collect();
            $year_list->push((object)['tahun' => $currentYear]);
        }

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-3-senaraiD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function editform3B($id)
    {

        return view('ibk.editform3B', compact('id'));
    }

    public function editform3C($id)
    {

        return view('ibk.editform3C', compact('id'));
    }

    public function editform3D($id)
    {

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('edit-form3d', date('Y')), 'name' => "Borang 3D"],
        ];

        $kembali = route('user.shuttle-3-senaraiD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.editform3D', compact('id', 'returnArr'));
    }

    public function editform4D($id)
    {


        return view('ibk.editform4D', compact('id'));
    }

    public function editform4E($id)
    {
        return view('ibk.editform4E', compact('id'));
    }


    //shuttle 4
    public function shuttle_4_senaraiA_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->first();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $prevRegYear = $registrationYear - 1;
        $startYear = max($prevRegYear, $currentYear - 1);
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-senaraiA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_4_senaraiB_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $prevRegYear = $registrationYear - 1;
        $startYear = max($prevRegYear, $currentYear - 1);
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $quarterDates = [
            1 => [$year . '-01-01', $year . '-03-31'],
            2 => [$year . '-04-01', $year . '-06-30'],
            3 => [$year . '-07-01', $year . '-09-30'],
            4 => [$year . '-10-01', $year . '-12-31'],
        ];
        foreach ($quarterDates as $quarter => $dates) {
            $exists = FormB::where('shuttle_id', $shuttle->id)->where('suku_tahun', $quarter)->where('tahun', $year)->exists();
            if (!$exists) {
                $newFormB = new FormB();
                $newFormB->shuttle_id = $shuttle->id;
                $newFormB->suku_tahun = $quarter;
                $newFormB->tahun = $year;
                $newFormB->status = 'Tidak Diisi';
                $newFormB->shuttle_type = $shuttle->shuttle_type;
                $newFormB->tarikh_buka_borang = $dates[0];
                $newFormB->tarikh_tutup_borang = $dates[1];
                $newFormB->save();
            }
        }

        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->orderBy('suku_tahun')->get();

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-4-senaraiB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_4_senaraiC_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        // Registration date vars
        $currentYear = date('Y');
        $registrationDate = $shuttle->created_at;
        $registrationMonth = date('n', strtotime($registrationDate));
        $registrationYear = date('Y', strtotime($registrationDate));
        $prevRegYear = $registrationYear - 1;

        // Year list: from max(registrationYear - 1, currentYear - 1) to currentYear
        $startYear = max($prevRegYear, $currentYear - 1);
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        // Always ensure December of previous registration year exists (mandatory starting month)
        $decPrevRegYear = FormC::where('shuttle_id', $shuttle->id)->where('bulan', 12)->where('tahun', $prevRegYear)->first();
        if (!$decPrevRegYear) {
            $newDec = new FormC();
            $newDec->shuttle_id = $shuttle->id;
            $newDec->bulan = 12;
            $newDec->tahun = $prevRegYear;
            $newDec->status = 'Tidak Diisi';
            $newDec->created_at = $prevRegYear . '-12-01';
            $newDec->tarikh_buka_borang = $prevRegYear . '-12-01';
            $newDec->tarikh_tutup_borang = $prevRegYear . '-12-31';
            $newDec->save();
        }

        // Ensure all 12 months exist for the viewed year (skip for prevRegYear — only December needed there)
        if ($year != $prevRegYear) {
            for ($month = 1; $month <= 12; $month++) {
                $existingRecord = FormC::where('shuttle_id', $shuttle->id)
                    ->where('bulan', $month)
                    ->where('tahun', $year)
                    ->first();

                if (!$existingRecord) {
                    $newFormC = new FormC();
                    $newFormC->shuttle_id = $shuttle->id;
                    $newFormC->bulan = $month;
                    $newFormC->tahun = $year;
                    $newFormC->status = 'Tidak Diisi';
                    $newFormC->created_at = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                    $newFormC->tarikh_buka_borang = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                    $newFormC->tarikh_tutup_borang = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . date('t', strtotime($year . '-' . $month . '-01'));
                    $newFormC->save();
                }
            }
        }

        // Re-query to get all months including newly created ones
        $list = FormC::where('shuttle_id', $shuttle->id)
            ->where('tahun', $year)
            ->orderBy('bulan')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('bulan')
            ->values();

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-4-senaraiC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_4_senaraiD_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $list = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $startYear = max($registrationYear - 1, $currentYear - 1);

        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-4-senaraiD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_4_senaraiE_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $list = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $startYear = max($registrationYear - 1, $currentYear - 1);

        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiE', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-4-senaraiE-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_4_listA_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormA::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-listA', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('ibk.shuttle-4-listA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_4_listB_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormB::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-listB', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-listB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_4_listC_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormC::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-listC', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-listC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_4_listD_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = Form4D::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-listD', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-listD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_4_listE_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = Form4E::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-listE', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-listE-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }


    //shuttle 5

    public function shuttle_5_senaraiA_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->first();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $prevRegYear = $registrationYear - 1;
        $startYear = max($prevRegYear, $currentYear - 1);
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-senaraiA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_5_senaraiB_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $prevRegYear = $registrationYear - 1;
        $startYear = max($prevRegYear, $currentYear - 1);
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $quarterDates = [
            1 => [$year . '-01-01', $year . '-03-31'],
            2 => [$year . '-04-01', $year . '-06-30'],
            3 => [$year . '-07-01', $year . '-09-30'],
            4 => [$year . '-10-01', $year . '-12-31'],
        ];
        foreach ($quarterDates as $quarter => $dates) {
            $exists = FormB::where('shuttle_id', $shuttle->id)->where('suku_tahun', $quarter)->where('tahun', $year)->exists();
            if (!$exists) {
                $newFormB = new FormB();
                $newFormB->shuttle_id = $shuttle->id;
                $newFormB->suku_tahun = $quarter;
                $newFormB->tahun = $year;
                $newFormB->status = 'Tidak Diisi';
                $newFormB->shuttle_type = $shuttle->shuttle_type;
                $newFormB->tarikh_buka_borang = $dates[0];
                $newFormB->tarikh_tutup_borang = $dates[1];
                $newFormB->save();
            }
        }

        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->orderBy('suku_tahun')->get();

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-5-senaraiB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_5_senaraiC_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        // Registration date vars
        $currentYear = date('Y');
        $registrationDate = $shuttle->created_at;
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $registrationMonth = $shuttle->created_at ? date('n', strtotime($shuttle->created_at)) : 1;
        $prevRegYear = $registrationYear - 1;

        // Year list: from max(registrationYear - 1, currentYear - 1) to currentYear
        $startYear = max($prevRegYear, $currentYear - 1);
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        // Always ensure December of previous registration year exists (mandatory starting month)
        $decPrevRegYear = FormC::where('shuttle_id', $shuttle->id)->where('bulan', 12)->where('tahun', $prevRegYear)->first();
        if (!$decPrevRegYear) {
            $newDec = new FormC();
            $newDec->shuttle_id = $shuttle->id;
            $newDec->bulan = 12;
            $newDec->tahun = $prevRegYear;
            $newDec->status = 'Tidak Diisi';
            $newDec->created_at = $prevRegYear . '-12-01';
            $newDec->tarikh_buka_borang = $prevRegYear . '-12-01';
            $newDec->tarikh_tutup_borang = $prevRegYear . '-12-31';
            $newDec->save();
        }

        // Ensure all 12 months exist for the viewed year (skip for prevRegYear — only December needed there)
        if ($year != $prevRegYear) {
            for ($month = 1; $month <= 12; $month++) {
                $existingRecord = FormC::where('shuttle_id', $shuttle->id)->where('bulan', $month)->where('tahun', $year)->first();
                if (!$existingRecord) {
                    $newFormC = new FormC();
                    $newFormC->shuttle_id = $shuttle->id;
                    $newFormC->bulan = $month;
                    $newFormC->tahun = $year;
                    $newFormC->status = 'Tidak Diisi';
                    $newFormC->created_at = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                    $newFormC->tarikh_buka_borang = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                    $newFormC->tarikh_tutup_borang = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . date('t', strtotime($year . '-' . $month . '-01'));
                    $newFormC->save();
                }
            }
        }

        $list = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-5-senaraiC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_5_senaraiD_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();

        // Year list: include registrationYear - 1 (Dec of prev year is mandatory starting month)
        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $startYear = max($registrationYear - 1, $currentYear - 1);

        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-5-senaraiD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_5_senaraiE_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();

        // Year list: include registrationYear - 1 (Dec of prev year is mandatory starting month)
        $currentYear = date('Y');
        $registrationYear = $shuttle->created_at ? date('Y', strtotime($shuttle->created_at)) : $currentYear;
        $startYear = max($registrationYear - 1, $currentYear - 1);

        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $flow = FormFlowService::getStatus($shuttle->id, (int) $shuttle->shuttle_type, (int) $year);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiE', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];

        return view('ibk.shuttle-5-senaraiE-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'flow'));
    }

    public function shuttle_5_listA_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormA::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-listA', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('ibk.shuttle-5-listA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_5_listB_ibk($year)
    {

        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();
        $year_list = FormB::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-listB', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-listB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_5_listC_ibk($year)
    {

        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();


        $year_list = FormC::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'c')->where('shuttle', '5')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-listC', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-listC-ibk', compact('returnArr', 'list', 'shuttle','year','year_list'));
    }

    public function shuttle_5_listD_ibk($year)
    {

        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();


        $year_list = Form5D::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'd')->where('shuttle', '5')->first();



        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-listD', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-listD-ibk', compact('returnArr', 'list', 'shuttle','year','year_list'));
    }

    public function shuttle_5_listE_ibk($year)
    {

        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->get();


        $year_list = Form5E::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'e')->where('shuttle', '5')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-listE', date('Y')), 'name' => "Status Borang"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-listE-ibk', compact('returnArr', 'list', 'shuttle','year','year_list'));
    }
}
