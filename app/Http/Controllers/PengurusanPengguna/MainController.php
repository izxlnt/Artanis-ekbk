<?php

namespace App\Http\Controllers\PengurusanPengguna;

use App\Http\Controllers\Controller;
use App\Mail\Registration\SendRegistrationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Daerah;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function pengurusan_pengguna()
    {
        return view('admins.pengurusan-pengguna.pengurusan-pengguna');
    }

    public function pengurusan_pengguna_phd()
    {
        $phd = User::get();
        return view('admins.PHD.pengurusan-pengguna-phd', compact('phd'));
    }

    public function tambah_pengurusan_pengguna_phd()
    {
        return view('admins.PHD.tambah-pengurusan-pengguna-phd');
    }

    //register admin/pengguna
    protected function tambah_pengguna_phd(Request $request)
    {

        $kategori_pengguna = "PHD";
        $hashed_random_password = Hash::make("1234567890");

        User::create([
            'login_id' => $request->kad_pengenalan,
            'peranan' => $request->peranan,
            'status' => $request->status,
            'name' => $request->name,
            'jawatan' => $request->jawatan,
            'negeri' => $request->negeri,
            'daerah' => $request->daerah_id,
            'bahagian' => $request->bahagian,
            'no_telefon' => $request->no_telefon,
            'email' => $request->email,
            'password' => $hashed_random_password,
            'kategori_pengguna' => $kategori_pengguna,
            'is_approved_ipjpsm' => 0,

        ]);
        session()->flash('message', 'Akaun anda telah berjaya didaftarkan untuk pengesahan daripada pentadbir sistem.');

        return redirect()->route('phd.pengurusan-pengguna');
    }

    public function tambah_pengurusan_pengguna_ipjpsm()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('tambah-pengurusan-pengguna-ipjpsm', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('tambah-pengurusan-pengguna-ipjpsm', date('Y')), 'name' => "Tambah Pengguna Modul"],
        ];

        $kembali = route('home');

        if (auth()->user()->kategori_pengguna == "BPE") {
            $layout = 'layouts.layout-ipjpsm-nicepage';
        } else if (auth()->user()->kategori_pengguna == "BPM") {
            $layout = 'layouts.layout-bpm-nicepage';
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.pengurusan-pengguna.tambah-pengguna-ipjpsm', compact('returnArr', 'layout'));
    }

    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [

            'kad_pengenalan' => ['required', 'unique:users,login_id,'],
            // 'peranan' => ['required', 'string'],
            'name' => ['required', 'string'],
            'jawatan' => ['required', 'string'],
            'negeri' => ['nullable', 'string'],
            'daerah' => ['nullable', 'string'],
            'bahagian' => ['nullable', 'string'],
            'no_telefon' => ['required', 'string', 'max:11', 'min:8'],
            'email' => ['required', 'email', 'unique:users'],
            'kategori_pengguna' => ['required', 'string'],
        ]);
    }

    //register admin/pengguna
    protected function tambah_pengguna_ipjpsm(Request $request)
    {
        // dd($request->all());

        $this->validator($request->all())->validate();
        // $hashed_random_password = Hash::make("1234567890");
        $random = Str::random(8);
        $hashed_random_password = Hash::make( $random);

        // dd($request->negeri_id);
        $negeri_name = Daerah::where('id', $request->negeri_id)->first('negeri');
        $daerah_name = Daerah::where('id', $request->daerah_id)->first('daerah_hutan');


        if ($request->kategori_pengguna == 'PHD') {
            $user_counter_phd = User::where('kategori_pengguna', 'PHD')->where('daerah', $daerah_name->daerah_hutan)->where('status', '1')->count();
            // dd($user_counter_phd);
            if ($user_counter_phd >= 2) {
                return redirect()->back()->with("error", "Setiap Pejabat Hutan Daerah hanya boleh mendaftar terhad kepada dua pengguna aktif sahaja.");
            }
        }

        elseif($request->kategori_pengguna == 'JPN'){
            $user_counter_jpn = User::where('kategori_pengguna', 'JPN')->where('negeri', $negeri_name->negeri)->where('status', '1')->count();
            // dd($user_counter_jpn);
            if ($user_counter_jpn >= 2) {
                return redirect()->back()->with("error", "Setiap Jabatan Perhutanan Negeri hanya boleh mendaftar terhad kepada dua pengguna aktif sahaja.");
            }
        }



        // dd($request->all());
        $negeri_name = Daerah::where('id', $request->negeri_id)->first('negeri');

        $daerah_name = Daerah::where('id', $request->daerah_id)->first('daerah_hutan');
        // dd($daerah_name);


        $user = User::create([
            'login_id' => $request->kad_pengenalan,
            'peranan' => $request->peranan,
            'name' => $request->name,
            'jawatan' => $request->jawatan,
            'negeri' => $negeri_name->negeri ?? null,
            'daerah' => $daerah_name->daerah_hutan ?? null,
            'bahagian' => $request->bahagian ?? null,
            'no_telefon' => $request->no_telefon,
            'email' => $request->email,
            'password' => $hashed_random_password,
            'kategori_pengguna' => $request->kategori_pengguna,
            'is_approved_ipjpsm' => 1,

        ]);

          // $random = Str::random(8);
        //   $random = "1234567890";

        //notification registration
        Mail::to($user)->send(new SendRegistrationMail($user, $random));

        Session::flash('message', 'Akaun anda telah berjaya didaftarkan untuk pengesahan daripada pentadbir sistem.');

        return redirect()->route('tambah-pengurusan-pengguna-ipjpsm')->with('success', 'Akaun anda telah berjaya didaftarkan untuk pengesahan daripada pentadbir sistem.');
        // }
    }


    public function pengurusan_pengguna_bpm()
    {
        $user = User::get();
        // dd($user);
        return view('admins.pengurusan-pengguna.pengurusan-pengguna', compact('user'));
    }

    public function tambah_pengurusan_pengguna_bpm()
    {

        $breadcrumbs    = [
            ['link' => route('home-bpm'), 'name' => "Laman Utama"],
            ['link' => route('bpm.pengesahan-permohonan', date('Y')), 'name' => "Status Pengurusan Pengguna"],
            ['link' => route('bpm.tambah-pengurusan-pengguna-bpm', date('Y')), 'name' => "Tambah Pengguna Modul"],
        ];

        $kembali = route('bpm.pengesahan-permohonan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];




        return view('admins.pengurusan-pengguna.tambah-pengurusan-pengguna-ipjpsm', compact('returnArr'));
    }

    protected function tambah_pengguna_bpm(Request $request)
    {

        $hashed_random_password = Hash::make("1234567890");

        User::create([
            'login_id' => $request->kad_pengenalan,
            // 'peranan' => $request->peranan,
            'kategori_pengguna' => $request->kategori_pengguna,
            // 'status' => $request->status,
            'name' => $request->name,
            'jawatan' => $request->jawatan,
            // 'negeri' => $request->negeri_id,
            // 'daerah' => $request->daerah_id,
            'bahagian' => $request->bahagian,
            'no_telefon' => $request->no_telefon,
            'email' => $request->email,
            'password' => $hashed_random_password,
            'is_approved_ipjpsm' => 0,

        ]);
        session()->flash('message', 'Akaun anda telah berjaya didaftarkan untuk pengesahan daripada pentadbir sistem.');

        return redirect()->route('bpm.pengesahan-permohonan');
    }


    public function lampiran_permohonan_phd($id)
    {
        $users = User::find($id);


        return view('admins.PHD.lampiran-pengurusan-pengguna-phd', compact('users'));
    }

    public function sahkan_permohonan_phd($id)
    {
        $user = User::find($id);

        if ($user->status == '1') {
            $user->status = false;
        } else {
            $user->status = true;
        }

        // dd($user->status);
        $user->save();
        session()->flash('message', 'Akaun anda telah berjaya didaftarkan untuk pengesahan daripada pentadbir sistem.');


        return redirect()->route('phd.pengurusan-pengguna');
    }

    public function senarai_phd()
    {

        $users = User::where('kategori_pengguna', 'PHD')->where('is_approved_ipjpsm', 1)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-5', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        if (auth()->user()->kategori_pengguna == "BPE") {
            $layout = 'layouts.layout-ipjpsm-nicepage';
        } else if (auth()->user()->kategori_pengguna == "BPM") {
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-phd', compact('users', 'returnArr', 'layout'));
    }

    public function senarai_ipjpsm()
    {

        $users = User::where('kategori_pengguna', 'BPE')->where('is_approved_ipjpsm', 1)->get();
        // dd($users);

        if (auth()->user()->kategori_pengguna == "BPE") {
            $layout = 'layouts.layout-ipjpsm-nicepage';
        } else if (auth()->user()->kategori_pengguna == "BPM") {
            $layout = 'layouts.layout-bpm-nicepage';
        }

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-5', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ipjpsm', compact('users', 'returnArr', 'layout'));
    }

    public function senarai_jpn()
    {

        $users = User::where('kategori_pengguna', 'JPN')->where('is_approved_ipjpsm', 1)->get();
        // dd($users);

        if (auth()->user()->kategori_pengguna == "BPE") {
            $layout = 'layouts.layout-ipjpsm-nicepage';
        } else if (auth()->user()->kategori_pengguna == "BPM") {
            $layout = 'layouts.layout-bpm-nicepage';
        }

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraijpn', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.senaraijpn', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-jpn', compact('users', 'returnArr', 'layout'));
    }

    public function senarai_bpm()
    {

        $users = User::where('kategori_pengguna', 'BPM')->where('is_approved_ipjpsm', 1)->get();
        // dd($users);

        if (auth()->user()->kategori_pengguna == "BPE") {
            $layout = 'layouts.layout-ipjpsm-nicepage';
        } else if (auth()->user()->kategori_pengguna == "BPM") {
            $layout = 'layouts.layout-bpm-nicepage';
        }

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraijpn', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.senaraijpn', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-bpm', compact('users', 'returnArr', 'layout'));
    }

    public function senarai_ibk3($id)
    {

        $users = User::where('kategori_pengguna', 'IBK')->where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', '!=', NULL)
            ->where('shuttle_id', $id)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraiibk3', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.senaraiibk3', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('ipjpsm.senaraikilang3');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ibk3', compact('users', 'returnArr'));
    }

    public function senarai_ibk4($id)
    {

        $users = User::where('kategori_pengguna', 'IBK')->where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', '!=', NULL)->where('shuttle_id', $id)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraiibk4', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.senaraiibk4', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('ipjpsm.senaraikilang4');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ibk4', compact('users', 'returnArr'));
    }

    public function senarai_ibk5($id)
    {

        $users = User::where('kategori_pengguna', 'IBK')->where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', '!=', NULL)->where('shuttle_id', $id)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraiibk5', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.senaraiibk5', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('ipjpsm.senaraikilang5');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ibk5', compact('users', 'returnArr'));
    }

    public function senarai_kilang3()
    {

        $users = User::with('shuttle')->where('kategori_pengguna', 'IBK')->where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', NULL)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraikilang3', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ibk3-kilang', compact('users', 'returnArr'));
    }
    public function senarai_kilang4()
    {

        $users = User::where('kategori_pengguna', 'IBK')->where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', NULL)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraikilang4', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ibk4-kilang', compact('users', 'returnArr'));
    }
    public function senarai_kilang5()
    {

        $users = User::where('kategori_pengguna', 'IBK')->where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', NULL)->get();
        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraikilang5', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengurusan Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-ibk5-kilang', compact('users', 'returnArr'));
    }

    public function updateEmailKilang(Request $request, $id)
    {

        $user = User::where('id', $id)->first();

        $user->email = $request->email;

        $user->save();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $shuttle->email = $request->email;

        $shuttle->save();


        return redirect()->back()->with('success', 'Emel Pengguna Berjaya Dikemaskini');
    }

    public function updateEmailPengguna(Request $request, $id)
    {

        $user = User::where('id', $id)->first();


        $user->email = $request->email;

        $user->save();

        $pengguna = PenggunaKilang::where('id', $user->shuttle_id)->first();
        // dd($pengguna);

        $pengguna->email = $request->email;

        $pengguna->save();

        return redirect()->back()->with('success', 'Emel Pengguna Berjaya Dikemaskini');
    }

    public function updateEmailPhd(Request $request, $id)
    {

        $user = User::where('id', $id)->first();

        $user->email = $request->email;

        // dd($user);
        $user->save();

        return redirect()->back()->with('success', 'Emel Pengguna Berjaya Dikemaskini');
    }

    public function updateEmailJpn(Request $request, $id)
    {

        $user = User::where('id', $id)->first();

        $user->email = $request->email;

        // dd($user);
        $user->save();

        return redirect()->back()->with('success', 'Emel Pengguna Berjaya Dikemaskini');
    }

    public function updateStatusKilang($id)
    {
        // dd($id);
        $user = User::where('shuttle_id', $id)->get();

        foreach ($user as $key => $value) {
            $value->status = 0;
            $value->save();
        }


        return redirect()->back()->with('success', 'Pengguna Berjaya Dinyahaktifkan');
    }

    public function updateStatusKilangAktif($id)
    {
        // dd($id);
        $user = User::where('shuttle_id', $id)->get();

        foreach ($user as $key => $value) {
            $value->status = 1;
            $value->save();
        }

        return redirect()->back()->with('success', 'Pengguna Berjaya Diaktifkan');
    }

    public function updateStatusUser($id)
    {
        // dd($id);
        $user = User::where('id', $id)->first();
        $user->status = 0;
        $user->save();

        return redirect()->back()->with('success', 'Pengguna Berjaya Dinyahaktifkan');
    }

    public function updateStatusUserAktif($id)
    {
        // dd($id);
        $user = User::where('id', $id)->first();
        $user->status = 1;
        $user->save();

        return redirect()->back()->with('success', 'Pengguna Berjaya Diaktifkan');
    }
}
