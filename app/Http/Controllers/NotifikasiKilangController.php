<?php

namespace App\Http\Controllers;

use App\Models\Buffer;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\Shuttle;
use App\Models\User;
use App\Notifications\PHD\BorangTidakDiisiNotification;
use Illuminate\Http\Request;

class NotifikasiKilangController extends Controller
{
    public function shuttle_3_phd(){

        $kilang_s3 = Shuttle::where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3')->get();

        $form_a = FormA::
        whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        // dd($form_a);

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap')
                ->orWhere('status', 'Sedang Diisi');
        })
        ->get();

        $form_d = FormD::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $buffer_b = Buffer::where('shuttle', '3')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '3')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '3')->where('borang', 'D')->first();

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.notifikasi-kilang.s3', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.notifikasi-kilang.s3', date('Y')), 'name' => "Notifikasi Kilang"],
            ['link' => route('phd.notifikasi-kilang.s3', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('notifikasiKilang.shuttle_3_phd', compact('returnArr','kilang_s3', 'form_a','form_b', 'form_c', 'form_d','buffer_b', 'buffer_c', 'buffer_d'));
    }

    public function shuttle_3_phd_send(Request $request){
        // dd("masuk");
        $shuttle = Shuttle::findorfail($request->shuttle_id);

        $pengguna_kilangs = User::where('shuttle_id', $shuttle->id)->get();

        $pegawai = User::findorfail(auth()->user()->id);

        //checking borang yang perlu diisi
        $buffer_b = Buffer::where('shuttle', '3')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '3')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '3')->where('borang', 'D')->first();

        //borang A
        $form_a_checker = FormA::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->count();

        if($form_a_checker > 0){
            $form_list[] = "Borang A";
        }

        //borang B
        $form_b_checker = FormB::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_b_checker->count() > 0 ){
            foreach($form_b_checker as $formB){
                $time = strtotime($formB->tarikh_tutup_borang);
                $delay = '+' . $buffer_b->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formB->suku_tahun == 1 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                $form_list[] = "Borang B - Suku Tahun Pertama (Mac)";

                }elseif($formB->suku_tahun == 2 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Kedua (Jun)";

                }elseif($formB->suku_tahun == 3 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Ketiga (September)";

                }elseif($formB->suku_tahun == 4 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Keempat (Disember)";

                }
            }
        }

        //borang C
        $form_c_checker = FormC::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_c_checker->count() > 0 ){
            foreach($form_c_checker as $formC){
                $time = strtotime($formC->tarikh_tutup_borang);
                $delay = '+' . $buffer_c->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formC->bulan == 1 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Januari";
                }elseif($formC->bulan == 2 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Februari";
                }elseif($formC->bulan == 3 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Mac";
                }elseif($formC->bulan == 4 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan April";
                }elseif($formC->bulan == 5 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Mei";
                }elseif($formC->bulan == 6 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Jun";
                }elseif($formC->bulan == 7 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Julai";
                }elseif($formC->bulan == 8 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Ogos";
                }elseif($formC->bulan == 9 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan September";
                }elseif($formC->bulan == 10 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Oktober";
                }elseif($formC->bulan == 11 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan November";
                }elseif($formC->bulan == 12 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Disember";
                }
            }
        }

        //borang C
        $form_d_checker = FormD::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_d_checker->count() > 0 ){
            foreach($form_d_checker as $formD){
                $time = strtotime($formD->tarikh_tutup_borang);
                $delay = '+' . $buffer_d->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formD->bulan == 1 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Januari";
                }elseif($formD->bulan == 2 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Februari";
                }elseif($formD->bulan == 3 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Mac";
                }elseif($formD->bulan == 4 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan April";
                }elseif($formD->bulan == 5 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Mei";
                }elseif($formD->bulan == 6 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Jun";
                }elseif($formD->bulan == 7 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Julai";
                }elseif($formD->bulan == 8 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Ogos";
                }elseif($formD->bulan == 9 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan September";
                }elseif($formD->bulan == 10 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Oktober";
                }elseif($formD->bulan == 11 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan November";
                }elseif($formD->bulan == 12 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Disember";
                }
            }
        }

        // dd($form_list);

        //notification tidak diisi
        foreach($pengguna_kilangs as $pengguna_kilang){
            $pengguna_kilang->notify(new BorangTidakDiisiNotification($pengguna_kilang, $pegawai, $form_list));
        }

        return redirect()->back()->with('success', 'Notifikasi berjaya dihantar');
    }

    public function shuttle_4_phd(){

        $kilang_s4 = Shuttle::where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4')->get();

        $form_a = FormA::
        whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap')
                ->orWhere('status', 'Sedang Diisi');
        })
        ->get();

        $form_d = Form4D::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_e = Form4E::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $buffer_b = Buffer::where('shuttle', '4')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '4')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '4')->where('borang', 'D')->first();
        $buffer_e = Buffer::where('shuttle', '4')->where('borang', 'E')->first();

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.notifikasi-kilang.s4', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.notifikasi-kilang.s4', date('Y')), 'name' => "Notifikasi Kilang"],
            ['link' => route('phd.notifikasi-kilang.s4', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('notifikasiKilang.shuttle_4_phd', compact('returnArr', 'kilang_s4', 'form_a','form_b', 'form_c', 'form_d', 'form_e','buffer_b', 'buffer_c', 'buffer_d', 'buffer_e'));
    }

    public function shuttle_4_phd_send(Request $request){
        // dd("masuk s4 send");


        $shuttle = Shuttle::findorfail($request->shuttle_id);

        $pengguna_kilangs = User::where('shuttle_id', $shuttle->id)->get();

        $pegawai = User::findorfail(auth()->user()->id);

        //checking borang yang perlu diisi
        $buffer_b = Buffer::where('shuttle', '4')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '4')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '4')->where('borang', 'D')->first();
        $buffer_e = Buffer::where('shuttle', '4')->where('borang', 'E')->first();

        //borang A
        $form_a_checker = FormA::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->count();

        if($form_a_checker > 0){
            $form_list[] = "Borang A";
        }

        //borang B
        $form_b_checker = FormB::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_b_checker->count() > 0 ){
            foreach($form_b_checker as $formB){
                $time = strtotime($formB->tarikh_tutup_borang);
                $delay = '+' . $buffer_b->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formB->suku_tahun == 1 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                $form_list[] = "Borang B - Suku Tahun Pertama (Mac)";

                }elseif($formB->suku_tahun == 2 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Kedua (Jun)";

                }elseif($formB->suku_tahun == 3 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Ketiga (September)";

                }elseif($formB->suku_tahun == 4 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Keempat (Disember)";

                }
            }
        }

        //borang C
        $form_c_checker = FormC::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_c_checker->count() > 0 ){
            foreach($form_c_checker as $formC){
                $time = strtotime($formC->tarikh_tutup_borang);
                $delay = '+' . $buffer_c->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formC->bulan == 1 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Januari";
                }elseif($formC->bulan == 2 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Februari";
                }elseif($formC->bulan == 3 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Mac";
                }elseif($formC->bulan == 4 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan April";
                }elseif($formC->bulan == 5 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Mei";
                }elseif($formC->bulan == 6 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Jun";
                }elseif($formC->bulan == 7 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Julai";
                }elseif($formC->bulan == 8 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Ogos";
                }elseif($formC->bulan == 9 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan September";
                }elseif($formC->bulan == 10 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Oktober";
                }elseif($formC->bulan == 11 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan November";
                }elseif($formC->bulan == 12 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Disember";
                }
            }
        }

        //borang D
        $form_d_checker = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_d_checker->count() > 0 ){
            foreach($form_d_checker as $formD){
                $time = strtotime($formD->tarikh_tutup_borang);
                $delay = '+' . $buffer_d->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formD->bulan == 1 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Januari";
                }elseif($formD->bulan == 2 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Februari";
                }elseif($formD->bulan == 3 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Mac";
                }elseif($formD->bulan == 4 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan April";
                }elseif($formD->bulan == 5 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Mei";
                }elseif($formD->bulan == 6 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Jun";
                }elseif($formD->bulan == 7 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Julai";
                }elseif($formD->bulan == 8 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Ogos";
                }elseif($formD->bulan == 9 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan September";
                }elseif($formD->bulan == 10 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Oktober";
                }elseif($formD->bulan == 11 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan November";
                }elseif($formD->bulan == 12 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Disember";
                }
            }
        }

        //borang E
        $form_e_checker = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_e_checker->count() > 0 ){
            foreach($form_e_checker as $formE){
                $time = strtotime($formE->tarikh_tutup_borang);
                $delay = '+' . $buffer_d->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formE->bulan == 1 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Januari";
                }elseif($formE->bulan == 2 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Februari";
                }elseif($formE->bulan == 3 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Mac";
                }elseif($formE->bulan == 4 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan April";
                }elseif($formE->bulan == 5 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Mei";
                }elseif($formE->bulan == 6 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Jun";
                }elseif($formE->bulan == 7 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Julai";
                }elseif($formE->bulan == 8 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Ogos";
                }elseif($formE->bulan == 9 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan September";
                }elseif($formE->bulan == 10 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Oktober";
                }elseif($formE->bulan == 11 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan November";
                }elseif($formE->bulan == 12 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Disember";
                }
            }
        }
        // dd($form_list);

        //sent notification
        foreach($pengguna_kilangs as $pengguna_kilang){
            $pengguna_kilang->notify(new BorangTidakDiisiNotification($pengguna_kilang, $pegawai, $form_list));
        }

        return redirect()->back()->with('success', 'Notifikasi berjaya dihantar');
    }

    public function shuttle_5_phd(){

        $kilang_s5 = Shuttle::where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5')->get();
        $form_a = FormA::
        whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap')
                ->orWhere('status', 'Sedang Diisi');
        })
        ->get();

        $form_d = Form5D::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_e = Form5E::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '5');
        })
        ->where(function ($query) {
            $query
                ->where('status', 'Tidak Diisi')
                ->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $buffer_b = Buffer::where('shuttle', '5')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '5')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '5')->where('borang', 'D')->first();
        $buffer_e = Buffer::where('shuttle', '5')->where('borang', 'E')->first();

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.notifikasi-kilang.s5', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.notifikasi-kilang.s5', date('Y')), 'name' => "Notifikasi Kilang"],
            ['link' => route('phd.notifikasi-kilang.s5', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('notifikasiKilang.shuttle_5_phd', compact('returnArr','kilang_s5', 'form_a','form_b', 'form_c', 'form_d', 'form_e','buffer_b', 'buffer_c', 'buffer_d', 'buffer_e'));
    }

    public function shuttle_5_phd_send(Request $request){
        $shuttle = Shuttle::findorfail($request->shuttle_id);

        $pengguna_kilangs = User::where('shuttle_id', $shuttle->id)->get();

        $pegawai = User::findorfail(auth()->user()->id);

        //checking borang yang perlu diisi
        $buffer_b = Buffer::where('shuttle', '5')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '5')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '5')->where('borang', 'D')->first();
        $buffer_e = Buffer::where('shuttle', '5')->where('borang', 'E')->first();

        //borang A
        $form_a_checker = FormA::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->count();

        if($form_a_checker > 0){
            $form_list[] = "Borang A";
        }

        //borang B
        $form_b_checker = FormB::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_b_checker->count() > 0 ){
            foreach($form_b_checker as $formB){
                $time = strtotime($formB->tarikh_tutup_borang);
                $delay = '+' . $buffer_b->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formB->suku_tahun == 1 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                $form_list[] = "Borang B - Suku Tahun Pertama (Mac)";

                }elseif($formB->suku_tahun == 2 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Kedua (Jun)";

                }elseif($formB->suku_tahun == 3 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Ketiga (September)";

                }elseif($formB->suku_tahun == 4 && date('Y-m-d') >= $formB->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang B - Suku Tahun Keempat (Disember)";

                }
            }
        }

        //borang C
        $form_c_checker = FormC::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_c_checker->count() > 0 ){
            foreach($form_c_checker as $formC){
                $time = strtotime($formC->tarikh_tutup_borang);
                $delay = '+' . $buffer_c->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formC->bulan == 1 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Januari";
                }elseif($formC->bulan == 2 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Februari";
                }elseif($formC->bulan == 3 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Mac";
                }elseif($formC->bulan == 4 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan April";
                }elseif($formC->bulan == 5 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Mei";
                }elseif($formC->bulan == 6 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Jun";
                }elseif($formC->bulan == 7 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Julai";
                }elseif($formC->bulan == 8 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Ogos";
                }elseif($formC->bulan == 9 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan September";
                }elseif($formC->bulan == 10 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Oktober";
                }elseif($formC->bulan == 11 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan November";
                }elseif($formC->bulan == 12 && date('Y-m-d') >= $formC->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang C - Bulan Disember";
                }
            }
        }

        //borang D
        $form_d_checker = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_d_checker->count() > 0 ){
            foreach($form_d_checker as $formD){
                $time = strtotime($formD->tarikh_tutup_borang);
                $delay = '+' . $buffer_d->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formD->bulan == 1 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Januari";
                }elseif($formD->bulan == 2 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Februari";
                }elseif($formD->bulan == 3 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Mac";
                }elseif($formD->bulan == 4 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan April";
                }elseif($formD->bulan == 5 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Mei";
                }elseif($formD->bulan == 6 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Jun";
                }elseif($formD->bulan == 7 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Julai";
                }elseif($formD->bulan == 8 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Ogos";
                }elseif($formD->bulan == 9 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan September";
                }elseif($formD->bulan == 10 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Oktober";
                }elseif($formD->bulan == 11 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan November";
                }elseif($formD->bulan == 12 && date('Y-m-d') >= $formD->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang D - Bulan Disember";
                }
            }
        }

        //borang E
        $form_e_checker = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', date("Y"))->where('status', 'Tidak Diisi')->get();
        if($form_e_checker->count() > 0 ){
            foreach($form_e_checker as $formE){
                $time = strtotime($formE->tarikh_tutup_borang);
                $delay = '+' . $buffer_d->delay . ' month';
                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                if($formE->bulan == 1 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Januari";
                }elseif($formE->bulan == 2 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Februari";
                }elseif($formE->bulan == 3 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Mac";
                }elseif($formE->bulan == 4 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan April";
                }elseif($formE->bulan == 5 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Mei";
                }elseif($formE->bulan == 6 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Jun";
                }elseif($formE->bulan == 7 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Julai";
                }elseif($formE->bulan == 8 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Ogos";
                }elseif($formE->bulan == 9 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan September";
                }elseif($formE->bulan == 10 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Oktober";
                }elseif($formE->bulan == 11 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan November";
                }elseif($formE->bulan == 12 && date('Y-m-d') >= $formE->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini){
                    $form_list[] = "Borang E - Bulan Disember";
                }
            }
        }

        // dd($form_list);

        //sent notification
        foreach($pengguna_kilangs as $pengguna_kilang){
            $pengguna_kilang->notify(new BorangTidakDiisiNotification($pengguna_kilang, $pegawai, $form_list));
        }

        return redirect()->back()->with('success', 'Notifikasi berjaya dihantar');
    }

    public function redirect_notification($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['route']);
        }
    }
}
