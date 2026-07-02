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
        $tahun = date('Y');

        $kilang_s3 = Shuttle::whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3')->get();

        $form_a = FormA::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap')->orWhere('status', 'Sedang Diisi');
        })
        ->get();

        $form_d = FormD::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $buffer_b = Buffer::where('shuttle', '3')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '3')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '3')->where('borang', 'D')->first();

        $breadcrumbs = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.notifikasi-kilang.s3'), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.notifikasi-kilang.s3'), 'name' => "Notifikasi Kilang"],
            ['link' => route('phd.notifikasi-kilang.s3'), 'name' => "Shuttle 3 - Kilang Papan"],
        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('notifikasiKilang.shuttle_3_phd', compact('returnArr', 'kilang_s3', 'form_a', 'form_b', 'form_c', 'form_d', 'buffer_b', 'buffer_c', 'buffer_d', 'tahun'));
    }

    public function shuttle_3_phd_send(Request $request){
        // dd("masuk");
        $form_list = [];
        $shuttle = Shuttle::findorfail($request->shuttle_id);

        $pengguna_kilangs = User::where('shuttle_id', $shuttle->id)->get();

        $pegawai = User::findorfail(auth()->user()->id);

        $tahun = date("Y");
        $bulan_names = [1=>'Januari',2=>'Februari',3=>'Mac',4=>'April',5=>'Mei',6=>'Jun',7=>'Julai',8=>'Ogos',9=>'September',10=>'Oktober',11=>'November',12=>'Disember'];
        $suku_names  = [1=>'Pertama (Mac)',2=>'Kedua (Jun)',3=>'Ketiga (September)',4=>'Keempat (Disember)'];

        //borang A
        $form_a_checker = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->count();
        if($form_a_checker > 0){
            $form_list[] = "Borang A $tahun";
        }

        //borang B
        $form_b_checker = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_b_checker as $formB){
            if(isset($suku_names[$formB->suku_tahun]) && date('Y-m-d') >= $formB->tarikh_buka_borang){
                $form_list[] = "Borang B - Suku Tahun " . $suku_names[$formB->suku_tahun] . " $tahun";
            }
        }

        //borang C
        $form_c_checker = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_c_checker as $formC){
            if(isset($bulan_names[$formC->bulan]) && date('Y-m-d') >= $formC->tarikh_buka_borang){
                $form_list[] = "Borang C - Bulan " . $bulan_names[$formC->bulan] . " $tahun";
            }
        }

        //borang D
        $form_d_checker = FormD::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_d_checker as $formD){
            if(isset($bulan_names[$formD->bulan]) && date('Y-m-d') >= $formD->tarikh_buka_borang){
                $form_list[] = "Borang D - Bulan " . $bulan_names[$formD->bulan] . " $tahun";
            }
        }

        // dd($form_list);

        if(empty($form_list)){
            return redirect()->back()->with('error', 'Tiada borang yang perlu diisi buat masa ini.');
        }

        //notification tidak diisi
        foreach($pengguna_kilangs as $pengguna_kilang){
            $pengguna_kilang->notify(new BorangTidakDiisiNotification($pengguna_kilang, $pegawai, $form_list));
        }

        return redirect()->back()->with('success', 'Notifikasi berjaya dihantar');
    }

    public function shuttle_4_phd(){
        $tahun = date('Y');

        $kilang_s4 = Shuttle::whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4')->get();

        $form_a = FormA::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap')->orWhere('status', 'Sedang Diisi');
        })
        ->get();

        $form_d = Form4D::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_e = Form4E::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '4');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $buffer_b = Buffer::where('shuttle', '4')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '4')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '4')->where('borang', 'D')->first();
        $buffer_e = Buffer::where('shuttle', '4')->where('borang', 'E')->first();

        $breadcrumbs = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.notifikasi-kilang.s4'), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.notifikasi-kilang.s4'), 'name' => "Notifikasi Kilang"],
            ['link' => route('phd.notifikasi-kilang.s4'), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('notifikasiKilang.shuttle_4_phd', compact('returnArr', 'kilang_s4', 'form_a', 'form_b', 'form_c', 'form_d', 'form_e', 'buffer_b', 'buffer_c', 'buffer_d', 'buffer_e', 'tahun'));
    }

    public function shuttle_4_phd_send(Request $request){
        // dd("masuk s4 send");
        $form_list = [];

        $shuttle = Shuttle::findorfail($request->shuttle_id);

        $pengguna_kilangs = User::where('shuttle_id', $shuttle->id)->get();

        $pegawai = User::findorfail(auth()->user()->id);

        $tahun = date("Y");
        $bulan_names = [1=>'Januari',2=>'Februari',3=>'Mac',4=>'April',5=>'Mei',6=>'Jun',7=>'Julai',8=>'Ogos',9=>'September',10=>'Oktober',11=>'November',12=>'Disember'];
        $suku_names  = [1=>'Pertama (Mac)',2=>'Kedua (Jun)',3=>'Ketiga (September)',4=>'Keempat (Disember)'];

        //borang A
        $form_a_checker = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->count();
        if($form_a_checker > 0){
            $form_list[] = "Borang A $tahun";
        }

        //borang B
        $form_b_checker = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_b_checker as $formB){
            if(isset($suku_names[$formB->suku_tahun]) && date('Y-m-d') >= $formB->tarikh_buka_borang){
                $form_list[] = "Borang B - Suku Tahun " . $suku_names[$formB->suku_tahun] . " $tahun";
            }
        }

        //borang C
        $form_c_checker = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_c_checker as $formC){
            if(isset($bulan_names[$formC->bulan]) && date('Y-m-d') >= $formC->tarikh_buka_borang){
                $form_list[] = "Borang C - Bulan " . $bulan_names[$formC->bulan] . " $tahun";
            }
        }

        //borang D
        $form_d_checker = Form4D::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_d_checker as $formD){
            if(isset($bulan_names[$formD->bulan]) && date('Y-m-d') >= $formD->tarikh_buka_borang){
                $form_list[] = "Borang D - Bulan " . $bulan_names[$formD->bulan] . " $tahun";
            }
        }

        //borang E
        $form_e_checker = Form4E::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_e_checker as $formE){
            if(isset($bulan_names[$formE->bulan]) && date('Y-m-d') >= $formE->tarikh_buka_borang){
                $form_list[] = "Borang E - Bulan " . $bulan_names[$formE->bulan] . " $tahun";
            }
        }

        // dd($form_list);

        if(empty($form_list)){
            return redirect()->back()->with('error', 'Tiada borang yang perlu diisi buat masa ini.');
        }

        //sent notification
        foreach($pengguna_kilangs as $pengguna_kilang){
            $pengguna_kilang->notify(new BorangTidakDiisiNotification($pengguna_kilang, $pegawai, $form_list));
        }

        return redirect()->back()->with('success', 'Notifikasi berjaya dihantar');
    }

    public function shuttle_5_phd(){
        $tahun = date('Y');

        $kilang_s5 = Shuttle::whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5')->get();

        $form_a = FormA::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap')->orWhere('status', 'Sedang Diisi');
        })
        ->get();

        $form_d = Form5D::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $form_e = Form5E::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '5');
        })
        ->where('tahun', $tahun)
        ->where(function ($query) {
            $query->where('status', 'Tidak Diisi')->orWhere('status', 'Tidak Lengkap');
        })
        ->get();

        $buffer_b = Buffer::where('shuttle', '5')->where('borang', 'B')->first();
        $buffer_c = Buffer::where('shuttle', '5')->where('borang', 'C')->first();
        $buffer_d = Buffer::where('shuttle', '5')->where('borang', 'D')->first();
        $buffer_e = Buffer::where('shuttle', '5')->where('borang', 'E')->first();

        $breadcrumbs = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.notifikasi-kilang.s5'), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.notifikasi-kilang.s5'), 'name' => "Notifikasi Kilang"],
            ['link' => route('phd.notifikasi-kilang.s5'), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('notifikasiKilang.shuttle_5_phd', compact('returnArr', 'kilang_s5', 'form_a', 'form_b', 'form_c', 'form_d', 'form_e', 'buffer_b', 'buffer_c', 'buffer_d', 'buffer_e', 'tahun'));
    }

    public function shuttle_5_phd_send(Request $request){
        $form_list = [];
        $shuttle = Shuttle::findorfail($request->shuttle_id);

        $pengguna_kilangs = User::where('shuttle_id', $shuttle->id)->get();

        $pegawai = User::findorfail(auth()->user()->id);

        $tahun = date("Y");
        $bulan_names = [1=>'Januari',2=>'Februari',3=>'Mac',4=>'April',5=>'Mei',6=>'Jun',7=>'Julai',8=>'Ogos',9=>'September',10=>'Oktober',11=>'November',12=>'Disember'];
        $suku_names  = [1=>'Pertama (Mac)',2=>'Kedua (Jun)',3=>'Ketiga (September)',4=>'Keempat (Disember)'];

        //borang A
        $form_a_checker = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->count();
        if($form_a_checker > 0){
            $form_list[] = "Borang A $tahun";
        }

        //borang B
        $form_b_checker = FormB::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_b_checker as $formB){
            if(isset($suku_names[$formB->suku_tahun]) && date('Y-m-d') >= $formB->tarikh_buka_borang){
                $form_list[] = "Borang B - Suku Tahun " . $suku_names[$formB->suku_tahun] . " $tahun";
            }
        }

        //borang C
        $form_c_checker = FormC::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_c_checker as $formC){
            if(isset($bulan_names[$formC->bulan]) && date('Y-m-d') >= $formC->tarikh_buka_borang){
                $form_list[] = "Borang C - Bulan " . $bulan_names[$formC->bulan] . " $tahun";
            }
        }

        //borang D
        $form_d_checker = Form5D::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_d_checker as $formD){
            if(isset($bulan_names[$formD->bulan]) && date('Y-m-d') >= $formD->tarikh_buka_borang){
                $form_list[] = "Borang D - Bulan " . $bulan_names[$formD->bulan] . " $tahun";
            }
        }

        //borang E
        $form_e_checker = Form5E::where('shuttle_id', $shuttle->id)->where('tahun', $tahun)->where('status', 'Tidak Diisi')->get();
        foreach($form_e_checker as $formE){
            if(isset($bulan_names[$formE->bulan]) && date('Y-m-d') >= $formE->tarikh_buka_borang){
                $form_list[] = "Borang E - Bulan " . $bulan_names[$formE->bulan] . " $tahun";
            }
        }

        // dd($form_list);

        if(empty($form_list)){
            return redirect()->back()->with('error', 'Tiada borang yang perlu diisi buat masa ini.');
        }

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
