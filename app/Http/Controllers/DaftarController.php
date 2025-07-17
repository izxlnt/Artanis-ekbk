<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\User;
use App\Notifications\IPJPSM\SahPenggunaNotification;
use App\Rules\UniqueEmailAcrossAllTables;
use App\Rules\MalaysianIC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DaftarController extends Controller
{
    public function daftar_pilih(){
        return view('auth/pilih-daftar');
    }

    public function daftar_phd(){
        return view('auth/register-phd');
    }

    public function daftar_jpn()
    {
        return view('auth/register-jpn');
    }

    public function create_phd_user(Request $request){

        $this->validatorAddUserPhd($request->all())->validate();
        // dd('test');

        //ic checker
        $no_kad_pengenalan_counter = User::where('login_id', $request->login_id)->count();
        if ($no_kad_pengenalan_counter != 0) {
            return redirect()->back()->withInput($request->input())->with("error", "Kad pengenalan telah berdaftar di dalam sistem.");
        }

        $hashed_random_password = Hash::make("1234567890");

        if($request->jenis_pengguna == "JPN"){
            $kategori_pengguna = "JPN";
        }else{
            $kategori_pengguna = "PHD";
        }

        $negeri_name= Daerah::where('id',$request->negeri_id)->first('negeri');
        $daerah_name= Daerah::where('id',$request->daerah_id)->first('daerah_hutan');

        if($request->jenis_pengguna == "PHD"){
            $user_counter_phd = User::where('kategori_pengguna', 'PHD')->where('daerah',$daerah_name->daerah_hutan)->where('status', '1')->count();
            // dd($request->daerah_id);
            if ($user_counter_phd >= 2) {
                return redirect()->back()->with("error", "Setiap Pejabat Hutan Daerah hanya boleh mendaftar terhad kepada dua pengguna aktif sahaja.");
            }
        }
        else{
            $user_counter_jpn = User::where('kategori_pengguna', 'JPN')->where('negeri',$negeri_name->negeri)->where('status', '1')->count();
            // dd($user_counter_jpn);
            if ($user_counter_jpn >= 2) {
                return redirect()->back()->with("error", "Setiap Jabatan Perhutanan Negeri hanya boleh mendaftar terhad kepada dua pengguna aktif sahaja.");
            }
        }


// dd($request->all());
        $negeri_name= Daerah::where('id',$request->negeri_id)->first('negeri');
        $daerah_name= Daerah::where('id',$request->daerah_id)->first('daerah_hutan');
// dd ($negeri_name);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashed_random_password,
            'kategori_pengguna' => $kategori_pengguna,
            'login_id' => $request->login_id,
            'is_approved_ipjpsm' => 0,
            'jawatan' => $request->jawatan,
            'negeri' => $negeri_name->negeri,
            'daerah' => $daerah_name->daerah_hutan ?? null,
            'no_telefon' => $request->no_telefon,
        ]);

        // notification send pengesahan user
        $pegawais = User::where('kategori_pengguna', 'BPE')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new SahPenggunaNotification($user, $pegawai))->delay($delay));
        }
        return redirect('/')->with('success', 'Pendaftaran Anda Telah Berjaya Dihantar.');
    }

    protected function validatorAddUserPhd(array $data)
    {

        // dd($data);

        if($data['jenis_pengguna']== "PHD"){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'login_id' => ['required','string','max:12', new MalaysianIC, 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', new UniqueEmailAcrossAllTables()],
                'no_telefon' => ['required', 'string', 'max:11', 'min:9'],
                'jawatan' => ['required', 'string', 'max:255'],
                'negeri_id' => ['required', 'string', 'max:255'],
                'daerah_id' => ['required', 'string', 'max:255'],
            ]);
        }
        else{
        // dd($data);

            return Validator::make($data, [
                'negeri_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'login_id' => ['required','string','max:12', new MalaysianIC, 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', new UniqueEmailAcrossAllTables()],
                'no_telefon' => ['required', 'string', 'max:11', 'min:9'],
                'jawatan' => ['required', 'string', 'max:255'],

            ]);
        }


    }

}
