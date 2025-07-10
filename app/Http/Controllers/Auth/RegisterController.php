<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\FormA;
use App\Models\HakMilik;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Notifications\IPJPSM\SahPenggunaNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        if(isset($data['alamat_sama'])){

            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'jawatan'=> ['required', 'string', 'max:255'],
                'jantina'=> ['required', 'string', 'max:255'],
                'warganegara'=> ['required', 'string', 'max:255'],
                'kaum'=> ['required', 'string', 'max:255'],
                'no_kad_pengenalan'=> ['required', 'string', 'max:255','unique:pengguna_kilangs'],
                'gambar_ic_hadapan'=> ['required','max:10000', 'mimes:jpeg,jpg,png,gif'],
                'gambar_ic_belakang'=> ['required','max:10000', 'mimes:jpeg,jpg,png,gif'],
                'gambar_passport'=> ['required','max:10000', 'mimes:jpeg,jpg,png,gif'],
                'no_pekerja'=> ['nullable', 'string', 'max:255'],
                'gambar_kad_pekerja'=> ['nullable','max:10000', 'mimes:jpeg,jpg,png,gif'],
                'shuttle_type'=> ['required', 'string', 'max:255'],

                'tahun'=> ['required', 'string', 'max:255'],
                'negeri_id'=> ['required','string', 'max:255'],
                'nama_kilang'=> ['required', 'string', 'max:255'],
                'alamat_kilang_1'=> ['required', 'string', 'max:255'],
                'alamat_kilang_2'=> ['nullable', 'string', 'max:255'],
                'alamat_kilang_poskod'=> ['required', 'string', 'max:255'],
                'alamat_kilang_daerah'=> ['required'],

                // 'alamat_surat_menyurat_1'=> ['required', 'string', 'max:255'],
                // 'alamat_surat_menyurat_2'=> ['nullable', 'string', 'max:255'],
                // 'alamat_surat_menyurat_poskod'=> ['required', 'string', 'max:255'],
                // 'alamat_surat_menyurat_daerah'=> ['required'],

                // 'longtitude_x'=> ['required', 'string', 'max:255'],
                // 'langtitude_y'=> ['required', 'string', 'max:255'],
                'no_telefon'=> ['required', 'string', 'max:11', 'min:9'],
                'no_faks'=> ['nullable', 'string', 'max:255'],
                'no_ssm'=> ['required', 'string', 'max:255','unique:shuttles'],
                'tarikh_tubuh'=> ['required', 'date'],
                'tarikh_operasi'=> ['required', 'date'],
                'taraf_syarikat_catatan'=> ['required', 'string', 'max:255'],
                'nilai_harta'=> ['required', 'string', 'max:255'],
                'catatan_1'=> ['nullable', 'string', 'max:255'],
                'catatan_2'=> ['nullable', 'string', 'max:255'],
                'status'=> ['nullable', 'string', 'max:255'],
                'daerah_id'=> ['required', 'string', 'max:255'],
                'email'=> ['required', 'email'],
                'email_kilang'=> ['required', 'email'],
                'website'=> ['nullable', 'string', 'max:255'],
                'no_lesen'=> ['required', 'string', 'max:255'],
                'status_hak_milik'=> ['required', 'string', 'max:255'],
                'status_warganegara'=> ['required', 'string', 'max:255'],
                'sijil_ssm'=> ['required', 'max:10000', 'mimes:jpeg,jpg,png,gif'],
                'lesen_kilang'=> ['required','max:10000', 'mimes:jpeg,jpg,png,gif'],
            ]);
        }

        else{
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'jawatan'=> ['required', 'string', 'max:255'],
                'jantina'=> ['required', 'string', 'max:255'],
                'warganegara'=> ['required', 'string', 'max:255'],
                'kaum'=> ['required', 'string', 'max:255'],
                'no_kad_pengenalan'=> ['required', 'string', 'max:255'],
                'gambar_ic_hadapan'=> ['required','max:10000'],
                'gambar_ic_belakang'=> ['required','max:10000'],
                'gambar_passport'=> ['required','max:10000'],
                'no_pekerja'=> ['required', 'string', 'max:255'],
                'gambar_kad_pekerja'=> ['required','max:10000'],
                'shuttle_type'=> ['required', 'string', 'max:255'],

                'tahun'=> ['required', 'string', 'max:255'],
                'negeri_id'=> ['required','string', 'max:255'],
                'nama_kilang'=> ['required', 'string', 'max:255'],
                'alamat_kilang_1'=> ['required', 'string', 'max:255'],
                'alamat_kilang_2'=> ['nullable', 'string', 'max:255'],
                'alamat_kilang_poskod'=> ['required', 'string', 'max:255'],
                'alamat_kilang_daerah'=> ['required'],

                'alamat_surat_menyurat_1'=> ['required', 'string', 'max:255'],
                'alamat_surat_menyurat_2'=> ['nullable', 'string', 'max:255'],
                'alamat_surat_menyurat_poskod'=> ['required', 'string', 'max:255'],
                'alamat_surat_menyurat_daerah'=> ['required'],

                // 'longtitude_x'=> ['required', 'string', 'max:255'],
                // 'langtitude_y'=> ['required', 'string', 'max:255'],
                'no_telefon'=> ['required', 'string', 'max:255'],
                'no_faks'=> ['nullable', 'string', 'max:255'],
                'no_ssm'=> ['required', 'string', 'max:255','unique:shuttles'],
                'tarikh_tubuh'=> ['required', 'date'],
                'tarikh_operasi'=> ['required', 'date'],
                'taraf_syarikat_catatan'=> ['required', 'string', 'max:255'],
                'nilai_harta'=> ['required', 'string', 'max:255'],
                'catatan_1'=> ['nullable', 'string', 'max:255'],
                'catatan_2'=> ['nullable', 'string', 'max:255'],
                'status'=> ['nullable', 'string', 'max:255'],
                'daerah_id'=> ['required', 'string', 'max:255'],
                'email'=> ['required', 'email'],
                'email_kilang'=> ['required', 'email'],
                'website'=> ['nullable', 'string', 'max:255'],
                'no_lesen'=> ['required', 'string', 'max:255'],
                'status_hak_milik'=> ['required', 'string', 'max:255'],
                'status_warganegara'=> ['required', 'string', 'max:255'],
                'sijil_ssm'=> ['required', 'max:10000'],
                'lesen_kilang'=> ['required','max:10000'],
            ]);
        }


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createPenggunaKilang(array $data, $gambar_ic_hadapan,$gambar_ic_belakang, $gambar_passport,$gambar_kad_pekerja)
    {
        // $hashed_random_password = Hash::make("1234567890");
        return $pengguna_kilang_id=PenggunaKilang::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'jawatan' => $data['jawatan'],
            'jantina' => $data['jantina'],
            'warganegara' => $data['warganegara'],
            'kaum' => $data['kaum'],
            'no_kad_pengenalan' => $data['no_kad_pengenalan'],
            'gambar_ic_hadapan' => $gambar_ic_hadapan,
            'gambar_ic_belakang' => $gambar_ic_belakang,
            'gambar_passport' => $gambar_passport,
            'no_pekerja' => $data['no_pekerja'],
            'gambar_kad_pekerja' => $gambar_kad_pekerja,
            'shuttle_type' => $data['shuttle_type'],

        ]);
    }

    protected function createKilang(array $data,$keterangan,$daerah_name,$negeri_name,$sijil_ssm,$lesen_kilang, $gambar_ic_hadapan,$gambar_ic_belakang, $gambar_passport,$gambar_kad_pekerja)
    {
        if(isset($data['alamat_sama'])){
            $shuttle_id =Shuttle::create([
                'tahun' => $data['tahun'],
                'nama_kilang' => $data['nama_kilang'],
                'alamat_kilang_1' => $data['alamat_kilang_1'],
                'alamat_kilang_2'=> $data['alamat_kilang_2'],
                'alamat_kilang_poskod'=> $data['alamat_kilang_poskod'],
                'alamat_kilang_daerah'=> $data['alamat_kilang_daerah'],

                'alamat_surat_menyurat_1'=> $data['alamat_kilang_1'],
                'alamat_surat_menyurat_2'=> $data['alamat_kilang_2'],
                'alamat_surat_menyurat_poskod'=> $data['alamat_kilang_poskod'],
                'alamat_surat_menyurat_daerah'=> $data['alamat_kilang_daerah'],
                // 'longtitude_x'=> $data['longtitude_x'],
                // 'langtitude_y'=> $data['langtitude_y'],
                'no_telefon'=> $data['no_telefon'],
                'no_faks'=> $data['no_faks'],
                'no_ssm'=> $data['no_ssm'],
                'tarikh_tubuh'=> $data['tarikh_tubuh'],
                'tarikh_operasi'=> $data['tarikh_operasi'],
                'taraf_syarikat_catatan'=> $data['taraf_syarikat_catatan'],
                'nilai_harta'=> $data['nilai_harta'],
                'catatan_1'=> $data['catatan_1'] ?? null,
                'catatan_2'=> $data['catatan_2'] ?? null,
                'status'=> $data['status'] ?? null,
                'daerah_id'=> $daerah_name->daerah_hutan,
                'negeri_id'=> $negeri_name->negeri,
                'email'=> $data['email_kilang'],
                'website'=> $data['website'],
                'no_lesen'=> $data['no_lesen'],
                'status_hak_milik'=> $keterangan->keterangan,
                'status_warganegara'=> $data['status_warganegara'],
                'sijil_ssm' => $sijil_ssm,
                'lesen_kilang' =>$lesen_kilang,
                'shuttle_type' => $data['shuttle_type'],

            ]);
        }
        else{
            $shuttle_id =Shuttle::create([
                'tahun' => $data['tahun'],
                'nama_kilang' => $data['nama_kilang'],
                'alamat_kilang_1' => $data['alamat_kilang_1'],
                'alamat_kilang_2'=> $data['alamat_kilang_2'],
                'alamat_kilang_poskod'=> $data['alamat_kilang_poskod'],
                'alamat_kilang_daerah'=> $data['alamat_kilang_daerah'],

                'alamat_surat_menyurat_1'=> $data['alamat_surat_menyurat_1'],
                'alamat_surat_menyurat_2'=> $data['alamat_surat_menyurat_2'],
                'alamat_surat_menyurat_poskod'=> $data['alamat_surat_menyurat_poskod'],
                'alamat_surat_menyurat_daerah'=> $data['alamat_surat_menyurat_daerah'],
                // 'longtitude_x'=> $data['longtitude_x'],
                // 'langtitude_y'=> $data['langtitude_y'],
                'no_telefon'=> $data['no_telefon'],
                'no_faks'=> $data['no_faks'],
                'no_ssm'=> $data['no_ssm'],
                'tarikh_tubuh'=> $data['tarikh_tubuh'],
                'tarikh_operasi'=> $data['tarikh_operasi'],
                'taraf_syarikat_catatan'=> $data['taraf_syarikat_catatan'],
                'nilai_harta'=> $data['nilai_harta'],
                'catatan_1'=> $data['catatan_1'] ?? null,
                'catatan_2'=> $data['catatan_2'] ?? null,
                'status'=> $data['status'] ?? null,
                'daerah_id'=> $data['daerah_id'],
                'negeri_id'=> $data['negeri_id'],
                'email'=> $data['email_kilang'],
                'website'=> $data['website'],
                'no_lesen'=> $data['no_lesen'],
                'status_hak_milik'=> $data['status_hak_milik'],
                'status_warganegara'=> $data['status_warganegara'],
                'sijil_ssm' => $sijil_ssm,
                'lesen_kilang' =>$lesen_kilang,
                'shuttle_type' => $data['shuttle_type'],

            ]);
        }


        // $formas = FormA::create([
        //     'shuttle_id' => $shuttle_id->id,
        //     'status' => 'Sedang Diproses',
        //     'tahun' => date("Y"),

        // ]);


        $pengguna_kilang_id=PenggunaKilang::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'jawatan' => $data['jawatan'],
            'jantina' => $data['jantina'],
            'warganegara' => $data['warganegara'],
            'kaum' => $data['kaum'],
            'no_kad_pengenalan' => $data['no_kad_pengenalan'],
            'gambar_ic_hadapan' => $gambar_ic_hadapan,
            'gambar_ic_belakang' => $gambar_ic_belakang,
            'gambar_passport' => $gambar_passport,
            'no_pekerja' => $data['no_pekerja'],
            'gambar_kad_pekerja' => $gambar_kad_pekerja,
            'shuttle_type' => $data['shuttle_type'],
            'shuttle_id' => $shuttle_id->id,


        ]);

        $kategori_pengguna = "IBK";
        // $hashed_random_password = Hash::make("1234567890");
        $password = Str::random(8);
        $hashed_random_password = Hash::make($password);

        //create KILANG
        User::create([
            'name' => $data['nama_kilang'],
            'email' => $data['email_kilang'],
            'password' => $hashed_random_password,
            'kategori_pengguna' => $kategori_pengguna,
            'login_id' => $data['no_ssm'],
            'shuttle_type' => $data['shuttle_type'],
            'is_approved' => 0,
            'shuttle_id' => $shuttle_id->id,

        ]);

        //create Pengguna Kilang
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashed_random_password,
            'kategori_pengguna' => $kategori_pengguna,
            'login_id' => $data['no_kad_pengenalan'],
            'shuttle_type' => $data['shuttle_type'],
            'is_approved' => 0,
            'pengguna_kilang_id' => $pengguna_kilang_id->id,
            'shuttle_id' => $shuttle_id->id,

        ]);
    }

    // protected function create(array $data)
    // {

    //     $kategori_pengguna = "IBK";
    //     // $hashed_random_password = Hash::make("1234567890");

    //     $password = Str::random(8);
    //     $hashed_random_password = Hash::make($password);

    //     User::create([
    //         'name' => $data['nama_kilang'],
    //         'email' => $data['email_kilang'],
    //         'password' => $hashed_random_password,
    //         'kategori_pengguna' => $kategori_pengguna,
    //         'login_id' => $data['no_ssm'],
    //         'shuttle_type' => $data['shuttle_type'],
    //         'is_approved' => 0,

    //     ]);

    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => $hashed_random_password,
    //         'kategori_pengguna' => $kategori_pengguna,
    //         'login_id' => $data['no_kad_pengenalan'],
    //         'shuttle_type' => $data['shuttle_type'],
    //         'is_approved' => 0,


    //     ]);
    // }

    public function register(Request $request)
    {
        // dd($request->all());

        $this->validator($request->all())->validate();

        // dd($request->all());
        $lesen_kilang = NULL;
        $sijil_ssm = NULL;
        $gambar_ic_hadapan = NULL;
        $gambar_ic_belakang = NULL;
        $gambar_passport = NULL;
        $gambar_kad_pekerja = NULL;

        // $no_kad_pengenalan = $request->no_kad_pengenalan;
        if($request->sijil_ssm){
            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads');
        }

        if($request->lesen_kilang){
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads');
        }

        if($request->gambar_ic_hadapan){
            $gambar_ic_hadapan = $request->file('gambar_ic_hadapan')->store('public/uploads');
        }

        if($request->gambar_ic_belakang){
            $gambar_ic_belakang = $request->file('gambar_ic_belakang')->store('public/uploads');
        }

        if($request->gambar_kad_pekerja){
            $gambar_kad_pekerja = $request->file('gambar_kad_pekerja')->store('public/uploads');
        }

        if($request->gambar_passport){
            $gambar_passport = $request->file('gambar_passport')->store('public/uploads');
        }

        $keterangan= HakMilik::where('id',$request->status_hak_milik)->first('keterangan');

        $negeri_name= Daerah::where('id',$request->negeri_id)->first('negeri');
        $daerah_name= Daerah::where('id',$request->daerah_id)->first('daerah_hutan');

        event(new Registered($kilang = $this->createKilang($request->all(),$keterangan,$daerah_name,$negeri_name,$sijil_ssm,$lesen_kilang,$gambar_ic_hadapan,$gambar_ic_belakang, $gambar_passport,$gambar_kad_pekerja)));
        // event(new Registered($kilang = $this->createKilang($request->all(),$sijil_ssm,$lesen_kilang)));
        // notification send pengesahan user
        $pegawais = User::where('kategori_pengguna', 'BPE')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new SahPenggunaNotification($kilang, $pegawai))->delay($delay));
        }

        // event(new Registered($user = $this->create($request->all())));
        // event(new Registered($user = $this->create($request->all())));

		return redirect('/login')->with('success','Pendaftaran Anda Telah Berjaya Dihantar.');
    }
}
