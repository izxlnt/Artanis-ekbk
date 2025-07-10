<?php

namespace App\Http\Controllers\StatusPermohonanPengguna;

use App\Http\Controllers\Controller;
use App\Mail\Registration\SendRegistrationMail;
use App\Models\Batch;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class PermohonanPenggunaController extends Controller
{

    public function status_permohonan_pengguna()
    {

        $users = User::get();

        foreach ($users as $data) {
            $shuttles[] = Shuttle::where('no_ssm', $data->login_id)->get();
        }

        // dd($shuttles);

        return view('admins.status-permohonan-pengguna.status-permohonan-pengguna', compact('users', 'shuttles'));
    }


    public function lampiran_permohonan($id)
    {
        $id = User::find($id);
        $kilang = Shuttle::where('id', $id->shuttle_id)->first();


        $breadcrumbs    = [
            ['link' => route('home-bpm'), 'name' => "Laman Utama"],
            ['link' => route('bpm.lampiran-permohonan-pengguna', date('Y')), 'name' => "Maklumat Pengguna Modul"],
        ];

        $kembali = route('home-bpm');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];




        $users = PenggunaKilang::where('id', $id->pengguna_kilang_id)->first();
        if ($users) {
            $nama_kilang = Shuttle::where('id', $users->shuttle_id)->first();
            return view('admins.status-permohonan-pengguna.lampiran-permohonan-pengguna', compact('returnArr','users', 'kilang', 'nama_kilang'));
        } else {
            return view('admins.status-permohonan-pengguna.lampiran-permohonan-pengguna', compact('returnArr','users', 'kilang'));
        }
    }

    public function status_permohonan_pengguna_jpn()
    {

        $users = User::get();

        foreach ($users as $data) {
            $shuttles[] = Shuttle::where('no_ssm', $data->login_id)->get();
        }


        return view('admins.JPN.status-permohonan-pengguna', compact('users', 'shuttles'));
    }

    public function lampiran_permohonan_jpn($id)
    {
        $id = User::find($id);
        $kilang = Shuttle::where('id', $id->shuttle_id)->first();
        $user = User::where('id',$id->id)->first();
        $nama_kilang =null;

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.lampiran-permohonan-jpn', date('Y')), 'name' => "Lampiran Permohonan Jabatan Perhutanan Negeri (JPN)"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengesahan-permohonan.pengesahan-permohonan-jpn', compact('returnArr','user', 'kilang', 'nama_kilang','layout'));
    }

    public function status_permohonan_shuttle_3_ipjpsm($id)
    {
        // dd($id);
        $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',3)->where('is_approved',0)->where('pengguna_kilang_id','!=',NULL)->
        where('shuttle_id',$id)->get();

        // dd($users);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengesahan Permohonan ID Pengguna"],
        ];

        $kembali = route('ipjpsm.status-permohonan-shuttle-3-kilang');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.PHD.status-permohonan-pengguna-shuttle-3', compact('users', 'returnArr'));

    }

    public function status_permohonan_shuttle_3_ipjpsm_kilang()
    {

        // $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',3)->where('is_approved',0)->where('pengguna_kilang_id',NULL)->get(); //tarik kilang
        $user_check=[];

        $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',3)->where('pengguna_kilang_id',NULL)->get(); //tarik kilang

        foreach ($users as $key => $value) {
            $user_check[] = User::where('kategori_pengguna','IBK')->where('shuttle_type',3)->where('is_approved',0)
            ->where('pengguna_kilang_id','!=',NULL)->where('shuttle_id',$value->shuttle_id)->count(); // userd
        }

        // dd($user_check);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-3-kilang', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-3-kilang', date('Y')), 'name' => "Pengesahan Permohonan ID Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


            return view('admins.PHD.status-permohonan-pengguna-shuttle-3-kilang', compact('users', 'returnArr','user_check'));

    }

    public function status_permohonan_shuttle_4_ipjpsm_kilang()
    {


        $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',4)->where('pengguna_kilang_id',NULL)->get();
        $user_check=[];

        foreach ($users as $key => $value) {
            $user_check[] = User::where('kategori_pengguna','IBK')->where('shuttle_type',4)->where('is_approved',0)
            ->where('pengguna_kilang_id','!=',NULL)->where('shuttle_id',$value->shuttle_id)->count();
        }
        // dd($user_check);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4-kilang', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4-kilang', date('Y')), 'name' => "Pengesahan Permohonan ID Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


            return view('admins.PHD.status-permohonan-pengguna-shuttle-4-kilang', compact('users', 'returnArr','user_check'));

    }

    public function status_permohonan_shuttle_5_ipjpsm_kilang()
    {

        $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',5)->where('pengguna_kilang_id',NULL)->get();
        $user_check=[];
        foreach ($users as $key => $value) {
            $user_check[] = User::where('kategori_pengguna','IBK')->where('shuttle_type',5)->where('is_approved',0)
            ->where('pengguna_kilang_id','!=',NULL)->where('shuttle_id',$value->shuttle_id)->count();
        }

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-5-kilang', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-5-kilang', date('Y')), 'name' => "Pengesahan Permohonan ID Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.PHD.status-permohonan-pengguna-shuttle-5-kilang', compact('users', 'returnArr','user_check'));

    }

    public function status_permohonan_shuttle_4_ipjpsm($id)
    {

        $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',4)->where('is_approved',0)->where('pengguna_kilang_id','!=',NULL)->where('shuttle_id',$id)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-4', date('Y')), 'name' => "Pengesahan Permohonan ID Pengguna"],
        ];

        $kembali = route('ipjpsm.status-permohonan-shuttle-4-kilang');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.PHD.status-permohonan-pengguna-shuttle-4', compact('users', 'returnArr'));

    }

    public function status_permohonan_shuttle_5_ipjpsm($id)
    {

        $users = User::where('kategori_pengguna','IBK')->where('shuttle_type',5)->where('is_approved',0)->where('pengguna_kilang_id','!=',NULL)->where('shuttle_id',$id)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.senaraiphd', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('ipjpsm.senaraiphd', date('Y')), 'name' => "Pengesahan Permohonan ID Pengguna"],
        ];

        $kembali = route('ipjpsm.status-permohonan-shuttle-5-kilang');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.PHD.status-permohonan-pengguna-shuttle-5', compact('users', 'returnArr'));

    }

    public function status_permohonan_bpe_ipjpsm()
    {

        $users = User::where('kategori_pengguna','BPE')->where('is_approved_ipjpsm',0)->get();
        // dd($users);


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-phd', date('Y')), 'name' => "Status Permohonan Pegawai IPJPSM (IPJPSM)"],
        ];

        $kembali = route('home');


        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
            return view('admins.PHD.status-permohonan-bpe', compact('users', 'returnArr','layout'));

    }

    public function status_permohonan_phd_ipjpsm()
    {

        $users = User::where('kategori_pengguna','PHD')->where('is_approved_ipjpsm',0)->get();
        // dd($users);


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-phd', date('Y')), 'name' => "Status Permohonan Pegawai Hutan Daerah (PHD)"],
        ];

        $kembali = route('home');


        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
            return view('admins.PHD.status-permohonan-phd', compact('users', 'returnArr','layout'));

    }

    public function status_permohonan_jpn_ipjpsm()
    {

        $users = User::where('kategori_pengguna','JPN')->where('is_approved_ipjpsm',0)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-jpn', date('Y')), 'name' => "Status Permohonan Jabatan Perhutanan Negeri (JPN)"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.PHD.status-permohonan-jpn', compact('users', 'returnArr','layout'));

    }

    public function lampiran_permohonan_ipjpsm($id)
    {

        $id = User::find($id);
        // dd($id);
        $kilang = Shuttle::where('id', $id->shuttle_id)->first();

        $users = PenggunaKilang::where('id', $id->pengguna_kilang_id)->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.status-permohonan-shuttle-3', date('Y')), 'name' => " Pengesahan Permohonan ID Pengguna"],
            ['link' => route('ipjpsm.lampiran-permohonan-pengguna', date('Y')), 'name' => "Maklumat Pengguna Kilang"],
        ];

        $kembali = route('ipjpsm.status-permohonan-shuttle-3', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($users) {
            $nama_kilang = Shuttle::where('id', $users->shuttle_id)->first();
            return view('admins.PHD.lampiran-permohonan-pengguna', compact('returnArr','users', 'kilang', 'nama_kilang'));
        } else {
            return view('admins.PHD.lampiran-permohonan-pengguna', compact('returnArr','users', 'kilang'));
        }

    }

    public function lampiran_permohonan_bpe($id)
    {
        // dd($id);
        $id = User::find($id);
        $kilang = Shuttle::where('id', $id->shuttle_id)->first();
        $user = User::where('id',$id->id)->first();
        $nama_kilang = null;


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.lampiran-permohonan-phd', date('Y')), 'name' => "Lampiran Permohonan Pegawai IPJPSM (IPJPSM)"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.pengesahan-permohonan.pengesahan-permohonan-phd', compact('returnArr','user', 'kilang', 'nama_kilang','layout'));
    }

    public function lampiran_permohonan_phd($id)
    {
        // dd($id);
        $id = User::find($id);
        $kilang = Shuttle::where('id', $id->shuttle_id)->first();
        $user = User::where('id',$id->id)->first();
        $nama_kilang = null;


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.lampiran-permohonan-phd', date('Y')), 'name' => "Lampiran Permohonan Pegawai Daerah Hutan (PHD)"],
        ];

        $kembali = route('home');

        if(auth()->user()->kategori_pengguna == "BPE"){
            $layout = 'layouts.layout-ipjpsm-nicepage';
        }else if(auth()->user()->kategori_pengguna == "BPM"){
            $layout = 'layouts.layout-bpm-nicepage';
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

            return view('admins.pengesahan-permohonan.pengesahan-permohonan-phd', compact('returnArr','user', 'kilang', 'nama_kilang','layout'));
    }

    //sahkan phd

    public function sahkan_permohonan_phd_ipjpsm($id)
    {
        $id = User::find($id);
        $random = Str::random(8);
        // $random = "1234567890";

        $user = User::where('id',$id->id)->first();

        $user->is_approved_ipjpsm = '1';
        $user->password =  Hash::make($random);

        $user->save();

        //notification registration
        Mail::to($user)->send(new SendRegistrationMail($user, $random));

        Session::flash('message', 'Permohonan PHD telah disahkan.');

        if($user->kategori_pengguna == 'PHD'){
        return redirect()->route('ipjpsm.status-permohonan-phd')->with('success', 'Permohonan PHD telah disahkan.');

        }else{
        return redirect()->route('ipjpsm.status-permohonan-jpn')->with('success', 'Permohonan JPN telah disahkan.');

        }
    }

    public function delete_user_application($id){
        $user = User::findorfail($id);
        $shuttle = Shuttle::where('id',$user->shuttle_id)->first();
        // dd($shuttle);

        $user->delete();
        $shuttle->delete();

        // Session::flash('message', 'Permohonan Pengguna Telah Berjaya Dipadam');

        if($user->shuttle_type == 3){
            return redirect()->back()->with('success','Permohonan Pengguna Telah Berjaya Dipadam');
        }
        elseif($user->shuttle_type == 4)
        {
            return redirect()->back()->with('success','Permohonan Pengguna Telah Berjaya Dipadam');
        }
        elseif($user->shuttle_type == 5)
        {
            return redirect()->back()->with('success','Permohonan Pengguna Telah Berjaya Dipadam');
        }

        else{
            return redirect()->back()->with('success','Permohonan Pengguna Telah Berjaya Dipadam');
        }
    }
    public function sahkan_permohonan_pengguna_ipjpsm($id)
    {

        $pengguna = PenggunaKilang::find($id);
        $user = User::where('login_id',$pengguna->no_kad_pengenalan)->first();
        $random = Str::random(8);
        // $random_2 = mt_rand();

        // $random_pass = $random.''.$random_2;
        // dd($random_pass);
        // $random = "1234567890";

        // dd($user);
        $user->is_approved = true;
        $user->password =  Hash::make($random);
        $user->save();



$batch_checker = Batch::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();
        if ($batch_checker == '0') {
            //check firstime or not
            // $is_firstime_checker = Batch::where('shuttle_id', $user->shuttle_id)->count();
            for ($i = 1; $i < 13; $i++) {

                // if($is_firstime_checker == 0 && date("m") == $i){
                //     $batch = Batch::create([
                //         'shuttle_id' => $user->shuttle_id,
                //         'status' => 'Sedang Diproses',
                //         'tahun' => date("Y"),
                //         'bulan' => $i,
                //         'borang_a' => "1",
                //         'borang_b' => "0",
                //         'borang_c' => "0",
                //         'borang_d' => "0",
                //         'borang_e' => "0",
                //     ]);
                // }else{
                $batch = Batch::create([
                    'shuttle_id' => $user->shuttle_id,
                    'status' => 'Tidak Diisi',
                    'tahun' => date("Y"),
                    'bulan' => $i,
                    'borang_a' => "0",
                    'borang_b' => "0",
                    'borang_c' => "0",
                    'borang_d' => "0",
                    'borang_e' => "0",
                ]);
                // }


            }
        }



        //=========================== checker A (Shuttle 3,4,5) ===============================================
        $formA_checker = FormA::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();
        if ($formA_checker == '0') {
            $formas = FormA::create([
                'shuttle_id' => $user->shuttle_id,
                'status' => 'Tidak Diisi',
                'tahun' => date("Y"),
            ]);
        }



        //=========================== checker B (Shuttle 3,4,5) ===============================================
        $list = FormB::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();

        $status = 'Tidak Diisi';

        if ($list == '0') {
            for ($i = 1; $i < 5; $i++) {

                if ($i == 1) {
                    $formbs = FormB::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'suku_tahun' => $i,
                        'tarikh_buka_borang' => date("Y-03-01"),
                        'tarikh_tutup_borang' => date("Y-04-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 2) {
                    $formbs = FormB::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'suku_tahun' => $i,
                        'tarikh_buka_borang' => date("Y-06-01"),
                        'tarikh_tutup_borang' => date("Y-07-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 3) {
                    $formbs = FormB::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'suku_tahun' => $i,
                        'tarikh_buka_borang' => date("Y-09-01"),
                        'tarikh_tutup_borang' => date("Y-10-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 4) {
                    $formbs = FormB::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'suku_tahun' => $i,
                        'tarikh_buka_borang' => date("Y-12-01"),
                        'tarikh_tutup_borang' => date("Y-12-31"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                }
            }
        }



        //=========================== checker C (Shuttle 3,4,5) ===============================================
        $formC_checker = FormC::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();
        // dd($formC_checker);
        $status = 'Tidak Diisi';

        if ($formC_checker == '0') {
            for ($i = 1; $i < 13; $i++) {

                if ($i == 1) {

                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-01-01"),
                        'tarikh_tutup_borang' => date("Y-02-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 2) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-02-01"),
                        'tarikh_tutup_borang' => date("Y-03-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 3) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-03-01"),
                        'tarikh_tutup_borang' => date("Y-04-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 4) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-04-01"),
                        'tarikh_tutup_borang' => date("Y-05-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 5) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-05-01"),
                        'tarikh_tutup_borang' => date("Y-06-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 6) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-06-01"),
                        'tarikh_tutup_borang' => date("Y-07-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 7) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-07-01"),
                        'tarikh_tutup_borang' => date("Y-08-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 8) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-08-01"),
                        'tarikh_tutup_borang' => date("Y-09-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 9) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-09-01"),
                        'tarikh_tutup_borang' => date("Y-10-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 10) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-10-01"),
                        'tarikh_tutup_borang' => date("Y-11-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 11) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-11-01"),
                        'tarikh_tutup_borang' => date("Y-12-01"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                } elseif ($i == 12) {
                    $formcs = FormC::create([
                        'shuttle_id' => $user->shuttle_id,
                        'shuttle_type' => $user->shuttle_type,
                        'status' => $status,
                        'tahun' => date("Y"),
                        'bulan' => $i,
                        'tarikh_buka_borang' => date("Y-12-01"),
                        'tarikh_tutup_borang' => date("Y-12-31"),
                        'nama_kilang' => $user->shuttle->nama_kilang,
                        'no_ssm' => $user->shuttle->no_ssm,
                        'no_lesen' => $user->shuttle->no_lesen,
                    ]);
                }
            }
            //
        }

        //=========================== checker D ==============================================
        $shuttle_type = $user->shuttle->shuttle_type;


        if ($shuttle_type == 3) {  //=========================== checker D (Shuttle 3) ===============================================

            $formD_checker = FormD::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();

            if ($formD_checker == '0') {
                for ($i = 1; $i < 13; $i++) {

                    if ($i == 1) {

                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-01-01"),
                            'tarikh_tutup_borang' => date("Y-02-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 2) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-02-01"),
                            'tarikh_tutup_borang' => date("Y-03-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 3) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-03-01"),
                            'tarikh_tutup_borang' => date("Y-04-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 4) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-04-01"),
                            'tarikh_tutup_borang' => date("Y-05-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 5) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-05-01"),
                            'tarikh_tutup_borang' => date("Y-06-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 6) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-06-01"),
                            'tarikh_tutup_borang' => date("Y-07-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 7) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-07-01"),
                            'tarikh_tutup_borang' => date("Y-08-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 8) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-08-01"),
                            'tarikh_tutup_borang' => date("Y-09-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 9) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-09-01"),
                            'tarikh_tutup_borang' => date("Y-10-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 10) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-10-01"),
                            'tarikh_tutup_borang' => date("Y-11-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 11) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-11-01"),
                            'tarikh_tutup_borang' => date("Y-12-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 12) {
                        $formds = FormD::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-12-01"),
                            'tarikh_tutup_borang' => date("Y-12-31"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    }
                }
            }
        } elseif ($shuttle_type == 4) { //=========================== checker D (Shuttle 4) ===============================================

            $formD_checker = Form4D::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();

            if ($formD_checker == '0') {
                for ($i = 1; $i < 13; $i++) {

                    if ($i == 1) {

                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-01-01"),
                            'tarikh_tutup_borang' => date("Y-02-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 2) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-02-01"),
                            'tarikh_tutup_borang' => date("Y-03-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 3) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-03-01"),
                            'tarikh_tutup_borang' => date("Y-04-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 4) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-04-01"),
                            'tarikh_tutup_borang' => date("Y-05-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 5) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-05-01"),
                            'tarikh_tutup_borang' => date("Y-06-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 6) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-06-01"),
                            'tarikh_tutup_borang' => date("Y-07-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 7) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-07-01"),
                            'tarikh_tutup_borang' => date("Y-08-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 8) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-08-01"),
                            'tarikh_tutup_borang' => date("Y-09-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 9) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-09-01"),
                            'tarikh_tutup_borang' => date("Y-10-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 10) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-10-01"),
                            'tarikh_tutup_borang' => date("Y-11-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 11) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-11-01"),
                            'tarikh_tutup_borang' => date("Y-12-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 12) {
                        $formds = Form4D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-12-01"),
                            'tarikh_tutup_borang' => date("Y-12-31"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    }
                }
            }
        } elseif ($shuttle_type == 5) {

            $formD_checker = Form5D::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();

            if ($formD_checker == '0') {
                for ($i = 1; $i < 13; $i++) {

                    if ($i == 1) {

                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-01-01"),
                            'tarikh_tutup_borang' => date("Y-02-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 2) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-02-01"),
                            'tarikh_tutup_borang' => date("Y-03-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 3) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-03-01"),
                            'tarikh_tutup_borang' => date("Y-04-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 4) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-04-01"),
                            'tarikh_tutup_borang' => date("Y-05-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 5) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-05-01"),
                            'tarikh_tutup_borang' => date("Y-06-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 6) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-06-01"),
                            'tarikh_tutup_borang' => date("Y-07-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 7) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-07-01"),
                            'tarikh_tutup_borang' => date("Y-08-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 8) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-08-01"),
                            'tarikh_tutup_borang' => date("Y-09-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 9) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-09-01"),
                            'tarikh_tutup_borang' => date("Y-10-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 10) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-10-01"),
                            'tarikh_tutup_borang' => date("Y-11-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 11) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-11-01"),
                            'tarikh_tutup_borang' => date("Y-12-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 12) {
                        $formds = Form5D::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-12-01"),
                            'tarikh_tutup_borang' => date("Y-12-31"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    }
                }
            }
        }

        if ($shuttle_type == 4) { //=========================== checker E (Shuttle 4 )==============================================
            $formE_checker = Form4E::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();

            if ($formE_checker == '0') {
                for ($i = 1; $i < 13; $i++) {

                    if ($i == 1) {

                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-01-01"),
                            'tarikh_tutup_borang' => date("Y-02-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 2) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-02-01"),
                            'tarikh_tutup_borang' => date("Y-03-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 3) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-03-01"),
                            'tarikh_tutup_borang' => date("Y-04-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 4) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-04-01"),
                            'tarikh_tutup_borang' => date("Y-05-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 5) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-05-01"),
                            'tarikh_tutup_borang' => date("Y-06-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 6) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-06-01"),
                            'tarikh_tutup_borang' => date("Y-07-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 7) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-07-01"),
                            'tarikh_tutup_borang' => date("Y-08-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 8) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-08-01"),
                            'tarikh_tutup_borang' => date("Y-09-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 9) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-09-01"),
                            'tarikh_tutup_borang' => date("Y-10-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 10) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-10-01"),
                            'tarikh_tutup_borang' => date("Y-11-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 11) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-11-01"),
                            'tarikh_tutup_borang' => date("Y-12-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 12) {
                        $formes = Form4E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-12-01"),
                            'tarikh_tutup_borang' => date("Y-12-31"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    }
                }
            }
        } elseif ($shuttle_type == 5) { //=========================== checker E (Shuttle 5 )==============================================
            $formE_checker = Form5E::where('shuttle_id', $user->shuttle_id)->whereYear('created_at', date("Y"))->count();

            if ($formE_checker == '0') {
                for ($i = 1; $i < 13; $i++) {

                    if ($i == 1) {

                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-01-01"),
                            'tarikh_tutup_borang' => date("Y-02-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 2) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-02-01"),
                            'tarikh_tutup_borang' => date("Y-03-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 3) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-03-01"),
                            'tarikh_tutup_borang' => date("Y-04-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 4) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-04-01"),
                            'tarikh_tutup_borang' => date("Y-05-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 5) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-05-01"),
                            'tarikh_tutup_borang' => date("Y-06-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 6) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-06-01"),
                            'tarikh_tutup_borang' => date("Y-07-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 7) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-07-01"),
                            'tarikh_tutup_borang' => date("Y-08-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 8) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-08-01"),
                            'tarikh_tutup_borang' => date("Y-09-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 9) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-09-01"),
                            'tarikh_tutup_borang' => date("Y-10-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 10) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-10-01"),
                            'tarikh_tutup_borang' => date("Y-11-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 11) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-11-01"),
                            'tarikh_tutup_borang' => date("Y-12-01"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    } elseif ($i == 12) {
                        $formes = Form5E::create([
                            'shuttle_id' => $user->shuttle_id,
                            'shuttle_type' => $user->shuttle_type,
                            'status' => $status,
                            'tahun' => date("Y"),
                            'bulan' => $i,
                            'tarikh_buka_borang' => date("Y-12-01"),
                            'tarikh_tutup_borang' => date("Y-12-31"),
                            'nama_kilang' => $user->shuttle->nama_kilang,
                            'no_ssm' => $user->shuttle->no_ssm,
                            'no_lesen' => $user->shuttle->no_lesen,
                        ]);
                    }
                }
            }
        }



        // Session::flash('message', 'Permohonan Pengguna Telah Berjaya Disahkan.');

        //notification registration
        Mail::to($user)->send(new SendRegistrationMail($user, $random));

        if($pengguna->shuttle_type == 3){
            return redirect()->route('ipjpsm.status-permohonan-shuttle-3',$user->shuttle_id)->with('success','Permohonan Pengguna Telah Berjaya Disahkan.');
        }
        elseif($pengguna->shuttle_type == 4)
        {
            return redirect()->route('ipjpsm.status-permohonan-shuttle-4',$user->shuttle_id)->with('success','Permohonan Pengguna Telah Berjaya Disahkan.');
        }
        elseif($pengguna->shuttle_type == 5)
        {
            return redirect()->route('ipjpsm.status-permohonan-shuttle-5',$user->shuttle_id)->with('success','Permohonan Pengguna Telah Berjaya Disahkan.');
        }

    }

    public function sahkan_permohonan_kilang_ipjpsm($id)
    {
        $kilang = Shuttle::find($id);

        $user = User::where('login_id', $kilang->no_ssm)->first();
        $random = Str::random(8);
        // $random = "1234567890";

        // $user = User::find($id);


        // dd($random);
        $user->is_approved = true;
        $user->password =  Hash::make($random);

        $user->save();
        // Session::flash('message', 'Permohonan Kilang Telah Berjaya Disahkan.');

        //notification registration
        Mail::to($user)->send(new SendRegistrationMail($user, $random));

        if($kilang->shuttle_type == 3){
            return redirect()->route('ipjpsm.status-permohonan-shuttle-3-kilang')->with('success','Permohonan Kilang Telah Berjaya Disahkan.');;
        }
        elseif($kilang->shuttle_type == 4)
        {
            return redirect()->route('ipjpsm.status-permohonan-shuttle-4-kilang')->with('success','Permohonan Kilang Telah Berjaya Disahkan.');;
        }
        elseif($kilang->shuttle_type == 5)
        {
            return redirect()->route('ipjpsm.status-permohonan-shuttle-5-kilang')->with('success','Permohonan Kilang Telah Berjaya Disahkan.');;
        }

    }


    public function lampiran_permohonan_bpm($id)
    {
        $users =User::find($id);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('bpm.pengesahan-permohonan', date('Y')), 'name' => "Status Pengurusan Pengguna"],
            ['link' => route('bpm.lampiran-pengurusan-pengguna', date('Y')), 'name' => "Maklumat Penguna Modul"],
        ];

        $kembali = route('bpm.pengesahan-permohonan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];






        return view('admins.pengesahan-permohonan.lampiran-pengurusan-pengguna-ipjpsm',compact('users','returnArr'));

    }

    public function sahkan_permohonan_bpm($id)
    {
        $user = User::find($id);
        $user->is_approved_ipjpsm = true;

        if($user->status == '1'){
            $user->status = false;
        }
        else{
            $user->status = true;
        }
        $user->save();

        // Session::flash('message', 'Permohonan pengguna telah disahkan.');

        return redirect()->route('bpm.pengesahan-permohonan')->with('success', 'Permohonan pengguna telah disahkan.');

    }
}
