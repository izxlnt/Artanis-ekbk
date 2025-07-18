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

        //=========================== checker Batch ===============================================

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

        // Count Display home page
        //count shuttle 3 home page ibk

        $count_formA = FormA::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $formA_count = $count_formA->count();

        $count_formB = FormB::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $formB_count = $count_formB->count();

        $count_formC = FormC::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap')
                ->where('status', '!=', 'Sedang Diisi');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $formC_count = $count_formC->count();

        $count_formD = FormD::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $formD_count = $count_formD->count();


        //count shuttle 4 home page ibk

        $count_form4A = FormA::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form4A_count = $count_form4A->count();

        $count_form4B = FormB::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form4B_count = $count_form4B->count();

        $count_form4C = FormC::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap')
                ->where('status', '!=', 'Sedang Diisi');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form4C_count = $count_form4C->count();

        $count_form4D = Form4D::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form4D_count = $count_form4D->count();

        $count_form4E = Form4E::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form4E_count = $count_form4E->count();

        //count shuttle 5 home page ibk

        $count_form5A = FormA::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form5A_count = $count_form5A->count();

        $count_form5B = FormB::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form5B_count = $count_form5B->count();

        $count_form5C = FormC::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap')
                ->where('status', '!=', 'Sedang Diisi');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form5C_count = $count_form5C->count();

        $count_form5D = Form5D::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form5D_count = $count_form5D->count();

        $count_form5E = Form5E::where(function ($query) {
            $query
                ->where('status', '!=', 'Tidak Diisi')
                ->where('status', '!=', 'Tidak Lengkap');
        })
            ->where('tahun', date("Y"))->where('shuttle_id', auth()->user()->shuttle_id)->get();
        $form5E_count = $count_form5E->count();

        $user_daerah= Auth::user()->shuttle->daerah_id;
        // dd($user);

        $pengumumantest=Pengumuman::where('daerah_hutan',$user_daerah)->first();

        if(empty($pengumumantest))
        $pengumuman = null;
        else
        $pengumuman=Pengumuman::where('daerah_hutan',$user_daerah)->orderBy('created_at', 'DESC')->get();

        // dd($pengumumantest);

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
            'pengumuman'
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

            'gambar_ic_hadapan' => 'required|image|mimes:jpg,png,jpeg',
            'gambar_ic_belakang' => 'required|image|mimes:jpg,png,jpeg',
            'gambar_passport' => 'required|image|mimes:jpg,png,jpeg',


            'jawatan' => ['required', 'string', 'max:255'],
            'gambar_kad_pekerja' => 'image|mimes:jpg,png,jpeg',

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


        $count_form4A = FormA::where('status', 'Tidak Diisi')->whereYear('created_at', date("Y"))
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', 4)->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form4A_count = $count_form4A->count();


        // $count_form4B = FormB::where('status','Tidak Diisi')->where('created_at', '>=')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', 4)->where('daerah_id', auth()->user()->daerah);
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
        $count_form3A = FormA::where('status', 'Sedang Diproses')->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', 3)->where('daerah_id', auth()->user()->daerah);
        })->get();
        $form3A_count = $count_form3A->count();

        // $count_form3B = FormB::where('status','Sedang Diproses')->where('shuttle_type','3')->get();
        // $form3B_count = $count_form3B->count();

        $count_form3B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '3')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form3B_count = $count_form3B->count();

        // $count_form3C = FormC::where('status','Sedang Diproses')->where('shuttle_type','3')->get();
        // $form3C_count = $count_form3C->count();

        $count_form3C = FormC::where(function ($query) {
            $query
                ->where('status', 'Sedang Diproses')
                ->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '3')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form3C_count = $count_form3C->count();

        // $count_form3D = FormD::where('status','Sedang Diproses')->where('shuttle_type','3')->get();
        // $form3D_count = $count_form3D->count();

        $count_form3D = FormD::where('status', 'Sedang Diproses')->where('shuttle_type', '3')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form3D_count = $count_form3D->count();

        $shuttle3_count = $form3B_count + $form3C_count + $form3D_count + $form3A_count;

        return response()->json($shuttle3_count, 200);
    }



    public function ajax_count_tugasan_phd_shuttle4()
    {


        $count_form4A = FormA::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->get();
        $form4A_count = $count_form4A->count();

        // $count_form4B = FormB::where('status','Sedang Diproses')->where('shuttle_type','4')->get();
        // $form4B_count = $count_form4B->count();

        $count_form4B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form4B_count = $count_form4B->count();

        // $count_form4C = FormC::where('status','Sedang Diproses')->where('shuttle_type','4')->get();
        // $form4C_count = $count_form4C->count();

        $count_form4C = FormC::where(function ($query) {
            $query
                ->where('status', 'Sedang Diproses')
                ->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form4C_count = $count_form4C->count();
        // dd($count_form4C);

        // $count_form4D = Form4D::where('status','Sedang Diproses')->get();
        // $form4D_count = $count_form4D->count();

        $count_form4D = Form4D::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form4D_count = $count_form4D->count();

        // $count_form4D = Form4E::where('status','Sedang Diproses')->get();
        // $form4D_count = $count_form4D->count();

        $count_form4E = Form4E::where('status', 'Sedang Diproses')->where('shuttle_type', '4')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();

        $form4E_count = $count_form4E->count();

        $shuttle4_count = $form4B_count + $form4C_count + $form4D_count + $form4A_count + $form4E_count;

        return response()->json($shuttle4_count, 200);
    }

    public function ajax_count_tugasan_phd_shuttle5()
    {

        $count_form5A = FormA::where('status', 'Sedang Diproses')->whereHas('shuttle', function ($q) {
            $q->where('shuttle_type', 5);
        })->get();
        $form5A_count = $count_form5A->count();

        $count_form5B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '5')->get();
        $form5B_count = $count_form5B->count();


        $count_form5C = FormC::where(function ($query) {
            $query
                ->where('status', 'Sedang Diproses')
                ->orwhere('status', 'Tiada Pengeluaran');
        })->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        // dd($count_form5C);


        $form5C_count = $count_form5C->count();


        $count_form5D = Form5D::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();

        $form5D_count = $count_form5D->count();

        $count_form5E = Form5E::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })
            ->get();
        $form5E_count = $count_form5E->count();

        $shuttle5_count = $form5B_count + $form5C_count + $form5D_count + $form5A_count + $form5E_count;

        return response()->json($shuttle5_count, 200);
    }


    public function ajax_count_tugasan_jpn_shuttle3()
    {
        $count_form3A = FormA::where('status', 'Sedang Diproses')->where('shuttle_type','4')
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

        $count_form3C = FormC::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '3')
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

        $count_form4C = FormC::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '4')
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
                $q->where('daerah_id', auth()->user()->daerah);
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

        $count_form5B = FormB::where('status', 'Sedang Diproses')->where('shuttle_type', '5')->get();
        $form5B_count = $count_form5B->count();

        $count_form5C = FormC::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '5')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->get();
        $form5C_count = $count_form5C->count();

        $count_form5D = Form5D::where('status', 'Sedang Diproses')->orWhere('status', 'Tiada Pengeluaran')->where('shuttle_type', '5')
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

    public function index_phd()
    {



        $users = User::get();



        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah);
        })->get();
        $count_shuttle3 = $user3->count();

        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah);
        })->get();
        $count_shuttle4 = $user4->count();

        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah);
        })->get();

        $count_shuttle5 = $user5->count();
        // dd($count_shuttle5);


        $daerah= auth()->user()->daerah;

        $s3 = DB::select("SELECT COUNT(shuttles.daerah_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = '3'
        AND shuttles.daerah_id = '$daerah'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.daerah_id");

        // dd($s3);

        $s4 = DB::select("SELECT COUNT(shuttles.daerah_id) as total_kilang
        FROM form_a_s
        INNER JOIN shuttles
        ON form_a_s.shuttle_id = shuttles.id
        WHERE shuttles.shuttle_type = '4'
        AND shuttles.daerah_id = '$daerah'
        AND YEAR(date(form_a_s.created_at)) = YEAR(now())
        GROUP BY shuttles.daerah_id");

// dd($s4);

        $s5 = DB::select("SELECT COUNT(shuttles.daerah_id) as total_kilang
                FROM form_a_s
                INNER JOIN shuttles
                ON form_a_s.shuttle_id = shuttles.id
                WHERE shuttles.shuttle_type = '5'
                AND shuttles.daerah_id = '$daerah'
                AND YEAR(date(form_a_s.created_at)) = YEAR(now())
                GROUP BY shuttles.daerah_id");

// dd($s5[0]);

$user_pengumuman = auth()->user();
// dd($user);
$pengumumantest=PengumumanJpn::where('negeri',$user_pengumuman->negeri)->first();

        if(empty($pengumumantest))
        $pengumuman_jpn = null;
        else
        $pengumuman_jpn=PengumumanJpn::where('negeri',$user_pengumuman->negeri)->orderBy('created_at', 'DESC')->get();

        return view('home-phd', compact(

            'users',
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
            $q->where('daerah_id', auth()->user()->daerah);
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
            $q->where('daerah_id', auth()->user()->daerah);
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
            $q->where('daerah_id', auth()->user()->daerah);
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
        $spesis_aktif = Spesis::get();
        // dd(auth()->user()->daerah);
        // $shuttle = FormB::where('status','Sedang Diproses')->where('daerah',auth()->user()->daerah)->get();

        $formB = FormB::where('status', 'Sedang Diproses')->whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah);
        })->get();

        // dd($formB);

        $formc = FormC::where('status', 'Sedang Diproses')->get();
        $formd = FormD::where('status', 'Sedang Diproses')->get();
        $form4d = Form4D::where('status', 'Sedang Diproses')->get();
        $form4e = Form4E::where('status', 'Sedang Diproses')->get();
        $form5d = Form5D::where('status', 'Sedang Diproses')->get();
        $form5e = Form5E::where('status', 'Sedang Diproses')->get();

        $users = User::get();



        $user3 = User::where('shuttle_type', 3)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();
        $count_shuttle3 = $user3->count();

        $user4 = User::where('shuttle_type', 4)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();
        $count_shuttle4 = $user4->count();

        $user5 = User::where('shuttle_type', 5)->where('is_approved', 1)->where('pengguna_kilang_id', null)->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->get();

        $count_shuttle5 = $user5->count();

        foreach ($formB as $data) {
            $shuttles[] = Shuttle::where('no_ssm', $data->login_id)->get();
        }

        $user_pengumuman = auth()->user();
// dd($user_pengumuman);
$pengumumantest=PengumumanIpjpsm::where('negeri',$user_pengumuman->negeri)->first();
// dd($pengumumantest);

        if(empty($pengumumantest))
        $pengumuman_ipjpsm = null;
        else
        $pengumuman_ipjpsm=PengumumanIpjpsm::where('negeri',$user_pengumuman->negeri)->orderBy('created_at', 'DESC')->get();



        return view('home-jpn', compact('spesis_aktif', 'users', 'count_shuttle3', 'count_shuttle4', 'count_shuttle5', 'formc', 'formd', 'form4d', 'form4e', 'form5d', 'form5e', 'formB','pengumuman_ipjpsm'));
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

        // Update email in all related tables only if email was provided and changed
        if ($request->has('email') && $request->email !== $oldEmail) {
            $pengguna->email = $request->email;
            
            // Update the user's email
            $user->email = $request->email;
            $user->updated_at = now();

            // Update related Shuttle email if it exists
            if ($user->shuttle_id) {
                $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
                if ($shuttle) {
                    $shuttle->email = $request->email;
                    $shuttle->updated_at = now();
                    $shuttle->save();
                }
            }
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
        $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->first();

        $year_list = FormA::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-senaraiA-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list'));
    }

    public function shuttle_3_senaraiB_ibk($year)
    {

        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        $year_list = FormB::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'b')->where('shuttle', '3')->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-senaraiB-ibk', compact('returnArr', 'list', 'shuttle', 'buffer', 'year', 'year_list'));
    }

    public function shuttle_3_senaraiC_ibk($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Get years where data exists, but filter by registration date
        $year_list = FormC::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');
        
        // Filter out years before registration if shuttle has registration date
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $year_list = $year_list->filter(function($item) use ($registrationYear) {
                return $item->tahun >= $registrationYear;
            });
        }
        
        // If no data exists but shuttle is registered, show current year
        if ($year_list->isEmpty()) {
            $currentYear = date('Y');
            $year_list = collect();
            $year_list->push((object)['tahun' => $currentYear]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'C')->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-3-senaraiC-ibk', compact('returnArr', 'list', 'shuttle', 'buffer', 'year', 'year_list'));
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
            $year_list = $year_list->filter(function($item) use ($registrationYear) {
                return $item->tahun >= $registrationYear;
            });
        }
        
        // If no data exists but shuttle is registered, show current year
        if ($year_list->isEmpty()) {
            $currentYear = date('Y');
            $year_list = collect();
            $year_list->push((object)['tahun' => $currentYear]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'D')->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // dd($list);
        return view('ibk.shuttle-3-senaraiD-ibk', compact('returnArr', 'list', 'shuttle', 'buffer', 'year', 'year_list'));
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
        $year_list = FormA::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

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
        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        $year_list = FormB::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'b')->where('shuttle', '4')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-senaraiB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
    }

    public function shuttle_4_senaraiC_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Generate year list from 1 year before current year and consider registration date
        $currentYear = date('Y');
        $startYear = $currentYear - 1; // 1 year before current year
        
        // If shuttle has registration date, use that year if it's earlier
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $startYear = min($startYear, $registrationYear);
        }
        
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'c')->where('shuttle', '4')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-senaraiC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
    }

    public function shuttle_4_senaraiD_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Generate year list from 1 year before current year and consider registration date
        $currentYear = date('Y');
        $startYear = $currentYear - 1; // 1 year before current year
        
        // If shuttle has registration date, use that year if it's earlier
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $startYear = min($startYear, $registrationYear);
        }
        
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'd')->where('shuttle', '4')->first();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-senaraiD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
    }

    public function shuttle_4_senaraiE_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Generate year list from 1 year before current year and consider registration date
        $currentYear = date('Y');
        $startYear = $currentYear - 1; // 1 year before current year
        
        // If shuttle has registration date, use that year if it's earlier
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $startYear = min($startYear, $registrationYear);
        }
        
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'e')->where('shuttle', '4')->first();
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-4-senaraiE-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
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
        $year_list = FormA::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');


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
        $list = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        $year_list = FormB::where('shuttle_id', $shuttle->id)->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'b')->where('shuttle', '5')->first();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-senaraiB-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
    }

    public function shuttle_5_senaraiC_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Generate year list from 1 year before current year and consider registration date
        $currentYear = date('Y');
        $startYear = $currentYear - 1; // 1 year before current year
        
        // If shuttle has registration date, use that year if it's earlier
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $startYear = min($startYear, $registrationYear);
        }
        
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'c')->where('shuttle', '5')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-senaraiC-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
    }

    public function shuttle_5_senaraiD_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Generate year list from 1 year before current year and consider registration date
        $currentYear = date('Y');
        $startYear = $currentYear - 1; // 1 year before current year
        
        // If shuttle has registration date, use that year if it's earlier
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $startYear = min($startYear, $registrationYear);
        }
        
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'd')->where('shuttle', '5')->first();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-senaraiD-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
    }

    public function shuttle_5_senaraiE_ibk($year)
    {
        $user = auth()->user();

        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        $list = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', $year)->get();
        
        // Generate year list from 1 year before current year and consider registration date
        $currentYear = date('Y');
        $startYear = $currentYear - 1; // 1 year before current year
        
        // If shuttle has registration date, use that year if it's earlier
        if ($shuttle && $shuttle->created_at) {
            $registrationYear = date('Y', strtotime($shuttle->created_at));
            $startYear = min($startYear, $registrationYear);
        }
        
        $year_list = collect();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $year_list->push((object)['tahun' => $i]);
        }

        $buffer = Buffer::where('shuttle', auth()->user()->shuttle->shuttle_type)->where('borang', 'e')->where('shuttle', '5')->first();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiE', date('Y')), 'name' => "Kemasukan Maklumat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.shuttle-5-senaraiE-ibk', compact('returnArr', 'list', 'shuttle', 'year', 'year_list', 'buffer'));
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
