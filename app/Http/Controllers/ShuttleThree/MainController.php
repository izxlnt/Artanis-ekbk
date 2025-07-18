<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Http\Livewire\TarafSyarikat\TarafSyarikat;
use App\Mail\PHD\BorangTidakLengkapMail;
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
use App\Models\HakMilik;
use App\Models\KategoriGunaTenaga;
use Illuminate\Http\Request;
use App\Models\Negeri;
use App\Models\PenggunaKilang;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use App\Models\TarafSyarikat as ModelsTarafSyarikat;
use App\Models\UlasanIpjpsm;
use App\Models\UlasanPhd;
use App\Models\User;
use App\Models\Warganegara;
use App\Notifications\IBK\BorangDiHantar;
use App\Notifications\PHD\BorangTidakLengkapNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class MainController extends Controller
{
    public $shuttle_listA, $shuttle_listB;
    public function shuttle_3_listA_ipjpsm($year)
    {
        $user = auth()->user();

        // $formB_kilang = FormB::select('shuttle_id')->distinct()->where('tahun', $year)->get();
        // $formA = FormA::where('status', '=', 'Dihantar ke IPJPSM')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })->where('tahun', $year)->get();

        //list kilang
        $formA_kilang = DB::select(DB::raw("SELECT shuttles.*, batches.id as 'batch' FROM form_a_s
        INNER JOIN shuttles ON form_a_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form_a_s.tahun
        AND batches.status = 'Dihantar ke IPJPSM'
        AND (form_a_s.status = 'Dihantar ke IPJPSM' OR form_a_s.status = 'Lulus')
        AND batches.borang_a = '2'
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND shuttles.shuttle_type = '3'
        AND form_a_s.tahun = $year"));

        $formA = DB::select(DB::raw("SELECT form_a_s.* FROM batches, form_a_s
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = '2'
        AND batches.status = 'Dihantar ke IPJPSM'
        AND form_a_s.tahun = $year "));

        $year_list = DB::select(DB::raw('SELECT DISTINCT form_a_s.tahun FROM batches, form_a_s ,shuttles
        WHERE batches.tahun = form_a_s.tahun
        AND batches.shuttle_id = form_a_s.shuttle_id
        AND batches.borang_a = "2"
        AND shuttles.shuttle_type = 3
        AND batches.status = "Dihantar ke IPJPSM"'));

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Senarai Borang 3A"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        // $buffer = Buffer::where('borang', 'a')->where('shuttle', '3')->first();

        return view('admins.shuttle-three.shuttle-3-listA-ipjpsm', compact(
            'user',
            'formA',
            'formA_kilang',
            'year_list',
            'year',
            'returnArr'
        ));
    }

    public function shuttle_3_listA_bpm()
    {
        $user = auth()->user();
        $shuttle_listA = Shuttle::where('shuttle_type', '3')->paginate(10);
        return view('bpe.shuttle-three.shuttle-3-listA', compact('shuttle_listA', 'user'));
    }


    //Status Borang PHD shuttle 3
    public function senarai_tugasan_3A($year)
    {

        $formA = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->get();

        $year_list = FormA::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-3A', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-3A', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Status Borang 3A"],
        ];

        $kembali = route('home-user');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-3A', compact('formA', 'year_list', 'year', 'returnArr','batch'));
    }

    public function senarai_tugasan_3B($year)
    {

        $formB = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->get();

        $year_list = FormB::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-3B', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-3B', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.senarai-tugasan-3B', date('Y')), 'name' => "Status Borang 3B"],
        ];

        $kembali = route('home-user');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-3B', compact('formB', 'year_list', 'year', 'returnArr','batch'));
    }

    public function senarai_tugasan_3C($year)
    {
        $formC = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->get();

        $year_list = FormC::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-3C', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-3C', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.senarai-tugasan-3C', date('Y')), 'name' => "Status Borang 3C"],
        ];

        $kembali = route('home-user');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-3C', compact('formC', 'year_list', 'year', 'returnArr','batch'));
    }

    public function senarai_tugasan_3D($year)
    {

        $formD = FormD::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->get();

        $year_list = FormD::where('status', '!=', 'Tidak Diisi')->where('tahun', $year)
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '3');
            })
            ->distinct()->orderBy('tahun')->get('tahun');

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.senarai-tugasan-3D', date('Y')), 'name' => "Status Borang"],
            ['link' => route('phd.senarai-tugasan-3D', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.senarai-tugasan-3D', date('Y')), 'name' => "Status Borang 3D"],
        ];

        $kembali = route('home-user');
        $batch = Batch::get();


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.PHD.senarai-tugasan-3D', compact('formD', 'year_list', 'year', 'returnArr','batch'));
    }


    public function senarai_tugasan_phd()
    {
        $formB = FormB::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        $formC = FormC::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        $formD = FormD::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        $form4D = Form4D::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        $form4E = Form4E::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        $form5D = Form5D::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        $form5E = Form5E::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah);
            })->paginate(10);
        return view('admins.shuttle-three.senarai-tugasan-phd', compact('formB', 'formC', 'formD', 'form4D', 'form4E', 'form5D', 'form5E'));
    }

    public function senarai_tidak_lengkap_phd()
    {
        $formB = FormB::where('status', 'Tidak Lengkap')->paginate(10);
        $formC = FormC::where('status', 'Tidak Lengkap')->paginate(10);
        $formD = FormD::where('status', 'Tidak Lengkap')->paginate(10);
        $form4D = Form4D::where('status', 'Tidak Lengkap')->paginate(10);
        $form4E = Form4E::where('status', 'Tidak Lengkap')->paginate(10);
        $form5D = Form5D::where('status', 'Tidak Lengkap')->paginate(10);
        $form5E = Form5E::where('status', 'Tidak Lengkap')->paginate(10);
        return view('admins.shuttle-three.senarai-tidak-lengkap-phd', compact('formB', 'formC', 'formD', 'form4D', 'form4E', 'form5D', 'form5E'));
    }

    public function senarai_tugasan_ipjpsm()
    {
        $formB = FormB::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        $formC = FormC::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        $formD = FormD::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        $form4D = Form4D::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        $form4E = Form4E::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        $form5D = Form5D::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        $form5E = Form5E::where('status', 'Dihantar ke IPJPSM')->paginate(10);
        return view('admins.shuttle-three.senarai-tugasan-ipjpsm', compact('formB', 'formC', 'formD', 'form4D', 'form4E', 'form5D', 'form5E'));
    }

    public function senarai_tugasan_jpn()
    {
        $formB = FormB::where('status', 'Sedang Diproses')->paginate(10);
        $formC = FormC::where('status', 'Sedang Diproses')->paginate(10);
        $formD = FormD::where('status', 'Sedang Diproses')->paginate(10);
        $form4D = Form4D::where('status', 'Sedang Diproses')->paginate(10);
        $form4E = Form4E::where('status', 'Sedang Diproses')->paginate(10);
        $form5D = Form5D::where('status', 'Sedang Diproses')->paginate(10);
        $form5E = Form5E::where('status', 'Sedang Diproses')->paginate(10);
        return view('admins.shuttle-three.senarai-tugasan-jpn', compact('formB', 'formC', 'formD', 'form4D', 'form4E', 'form5D', 'form5E'));
    }
    // public function shuttle_3_listB()
    // {
    //     $shuttle_listB = Shuttle::where('shuttle_type', '3')->paginate(10);
    //     return view('admins.shuttle-three.shuttle-3-listB',compact('shuttle_listB'));
    // }

    public function shuttle_3_formA()
    {
        return view('admins.shuttle-three.shuttle-3-formA');
    }

    public function shuttle_3_formB($id)
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
            return view('admins.shuttle-three.shuttle-3-formB', compact('id'));
        }

        // if ($id != $early_buffer_date) {
        //     if ($form_b_checker == 0) {
        //         return redirect()->back()->with('error', 'Sila isi Borang B suku tahun sebelum ini terlebih dahulu.');
        //     }
        // }


        return view('admins.shuttle-three.shuttle-3-formB', compact('id'));
    }

    // SHUTTLE 3 FORM C

    public function shuttle_3_formCKKB($id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }
        
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

            // $form_b_checker = FormB::where('shuttle_id', auth()->user()->shuttle_id)
            // ->where('suku_tahun', $suku_tahun)
            // ->whereYear('created_at', $year)
            // ->where('status', '!=', 'Tidak Diisi')
            // ->count();


            if (auth()->user()->shuttle_type == "3"){
                $buffer = Buffer::where('shuttle', 3)->where('borang', 'C')->first();
            }else if(auth()->user()->shuttle_type == "4"){
                $buffer = Buffer::where('shuttle', 4)->where('borang', 'C')->first();
            }else{
                $buffer = Buffer::where('shuttle', 5)->where('borang', 'C')->first();
            }
            
            // Fix the buffer calculation - early_buffer_date should be the allowed earliest month
            $current_month = (int)date('m');
            $buffer_delay = $buffer ? (int)$buffer->delay : 0;
            $early_buffer_date = $current_month - $buffer_delay;
            
            // If early_buffer_date is negative, it means previous year months
            if ($early_buffer_date <= 0) {
                $early_buffer_date = 12 + $early_buffer_date; // Convert to previous year month
            }
            
            $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->whereYear('created_at', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($form_a_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
            }

            // Only check previous month if current month is NOT the first allowed month
            if ($id != 1 && $id > $early_buffer_date) {
                if ($form_c_checker == 0) {
                    return redirect()->back()->with('error', 'Sila isi Borang C bulan sebelum ini terlebih dahulu.');
                }
            }

            // if ($form_b_checker == 0) {
            //     return redirect()->back()->with('error', 'Sila isi Borang B bagi suku tahun yang dipilih terlebih dahulu.');
            // }

            if ($id == 1) {
                return redirect()->route('user.view.shuttle-3-formC.KKB', [$id, $year]);
            }


        }

        return redirect()->route('user.view.shuttle-3-formC.KKB', [$id, $year]);
    }

    public function shuttle_3_formCKKS($id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }
        
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
            if (auth()->user()->shuttle_type == "3"){
                $buffer = Buffer::where('shuttle', 3)->where('borang', 'C')->first();
            }else if(auth()->user()->shuttle_type == "4"){
                $buffer = Buffer::where('shuttle', 4)->where('borang', 'C')->first();
            }else{
                $buffer = Buffer::where('shuttle', 5)->where('borang', 'C')->first();
            }
            
            // Fix the buffer calculation - early_buffer_date should be the allowed earliest month
            $current_month = (int)date('m');
            $buffer_delay = $buffer ? (int)$buffer->delay : 0;
            $early_buffer_date = $current_month - $buffer_delay;
            
            // If early_buffer_date is negative, it means previous year months
            if ($early_buffer_date <= 0) {
                $early_buffer_date = 12 + $early_buffer_date; // Convert to previous year month
            }
            
            $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->whereYear('created_at', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($form_a_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
            }

            if ($id == 1) {
                return redirect()->route('user.view.shuttle-3-formC.KKS', [$id, $year]);
            }

            // Only check previous month if current month is NOT the first allowed month
            if ($id != 1 && $id > $early_buffer_date) {
                if ($form_c_checker == 0) {
                    return redirect()->back()->with('error', 'Sila isi Borang C bulan sebelum ini terlebih dahulu.');
                }
            }
        }

        return redirect()->route('user.view.shuttle-3-formC.KKS', [$id, $year]);

    }

    public function shuttle_3_formCKKR($id)
    {
        if (auth()->user()->kategori_pengguna == "IBK") {
            $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id', auth()->user()->shuttle->id)
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($id != 1) {
                $lastmonth = $id - 1;
            } else {
                $lastmonth = $id;
            }
            if (auth()->user()->shuttle_type == "3"){
                $buffer = Buffer::where('shuttle', 3)->where('borang', 'C')->first();
            }else if(auth()->user()->shuttle_type == "4"){
                $buffer = Buffer::where('shuttle', 4)->where('borang', 'C')->first();
            }else{
                $buffer = Buffer::where('shuttle', 5)->where('borang', 'C')->first();
            }


            $early_buffer_date = (int)date('m') - (int)$buffer->delay;
            $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->whereYear('created_at', date("Y"))
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($form_a_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
            }

            if ($id == 1) {
                return redirect()->route('user.view.shuttle-3-formC.KKR', $id);
            }

            if ($id != $early_buffer_date) {
                if ($form_c_checker == 0) {
                    return redirect()->back()->with('error', 'Sila isi Borang C bulan sebelum ini terlebih dahulu.');
                }
            }
        }

        return redirect()->route('user.view.shuttle-3-formC.KKR', $id);

    }

    public function shuttle_3_formCKayuLembut($id)
    {
        if (auth()->user()->kategori_pengguna == "IBK") {
            $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id', auth()->user()->shuttle->id)
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($id != 1) {
                $lastmonth = $id - 1;
            } else {
                $lastmonth = $id;
            }
            if (auth()->user()->shuttle_type == "3"){
                $buffer = Buffer::where('shuttle', 3)->where('borang', 'C')->first();
            }else if(auth()->user()->shuttle_type == "4"){
                $buffer = Buffer::where('shuttle', 4)->where('borang', 'C')->first();
            }else{
                $buffer = Buffer::where('shuttle', 5)->where('borang', 'C')->first();
            }


            $early_buffer_date = (int)date('m') - (int)$buffer->delay;
            $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->whereYear('created_at', date("Y"))
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($form_a_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
            }

            if ($id == 1) {
                return redirect()->route('user.view.shuttle-3-formC.KayuLembut', $id);
            }

            if ($id != $early_buffer_date) {
                if ($form_c_checker == 0) {
                    return redirect()->back()->with('error', 'Sila isi Borang C bulan sebelum ini terlebih dahulu.');
                }
            }
        }
        return redirect()->route('user.view.shuttle-3-formC.KayuLembut', $id);

    }

    public function shuttle_3_formCLainLain($id)
    {
        if (auth()->user()->kategori_pengguna == "IBK") {
            $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id', auth()->user()->shuttle->id)
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($id != 1) {
                $lastmonth = $id - 1;
            } else {
                $lastmonth = $id;
            }
            if (auth()->user()->shuttle_type == "3"){
                $buffer = Buffer::where('shuttle', 3)->where('borang', 'C')->first();
            }else if(auth()->user()->shuttle_type == "4"){
                $buffer = Buffer::where('shuttle', 4)->where('borang', 'C')->first();
            }else{
                $buffer = Buffer::where('shuttle', 5)->where('borang', 'C')->first();
            }


            $early_buffer_date = (int)date('m') - (int)$buffer->delay;
            $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->whereYear('created_at', date("Y"))
                ->where('status', '!=', 'Tidak Diisi')
                ->count();

            if ($form_a_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
            }

            if ($id == 1) {
                return redirect()->route('user.view.shuttle-3-formC.LainLain', $id);
            }

            if ($id != $early_buffer_date) {
                if ($form_c_checker == 0) {
                    return redirect()->back()->with('error', 'Sila isi Borang C bulan sebelum ini terlebih dahulu.');
                }
            }
        }

        return redirect()->route('user.view.shuttle-3-formC.LainLain', $id);
    }

    // END OF SHUTTLE 3 FORM C

    public function shuttle_3_formD($id)
    {

        $form_a_checker = FormA::where('tahun', date("Y"))
            ->where('shuttle_id', auth()->user()->shuttle->id)
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        if ($id != 1) {
            $lastmonth = $id - 1;
        } else {
            $lastmonth = $id;
        }

        $buffer = Buffer::where('shuttle', 3)->where('borang', 'C')->first();
        $early_buffer_date = (int)date('m') - (int)$buffer->delay;


        $form_c_checker = FormC::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $id)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $form_d_checker = FormD::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=', 'Tidak Diisi')
            ->count();

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Borang 3C - KKB"],
            ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Borang 3C - KKS"],


        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu.');
        }
        if ($form_c_checker == 0) {
            return redirect()->back()->with('error', 'Sila isi Borang C bagi bulan yang dipilih terlebih dahulu.');
        }
        if ($id == 1) {
            return view('admins.shuttle-three.shuttle-3-formD', compact('id', 'returnArr'));
        }
        if ($id != $early_buffer_date) {
            if ($form_d_checker == 0) {
                return redirect()->back()->with('error', 'Sila isi Borang D bulan sebelum ini terlebih dahulu.');
            }
        }

        return view('admins.shuttle-three.shuttle-3-formD', compact('id', 'returnArr'));
    }


    //update status borang for PHD


    protected function validatorulasan(array $data)
    {
        return Validator::make($data, [
            'longtitude_x' => ['required'],
            'langtitude_y' => ['required'],
        ]);
    }
    public function update_status_phd_form3A(Request $request, $id)
    {
        // dd($id);
        if ($request->has('tak_lengkap')) {
            $status = "Tidak Lengkap";
        } else {
            $status = "Dihantar ke IPJPSM";
        }

        $this->validatorulasan($request->all())->validate();
        $user = auth()->user();
        $formA = FormA::find($id);
        // dd($formA);
        $shuttle = Shuttle::where('id', $formA->shuttle_id)->first();
        $shuttle->longtitude_x = $request->longtitude_x;
        $shuttle->langtitude_y = $request->langtitude_y;
        $shuttle->save();

        $formA->status = $status;
        $formA->save();



        UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'formas_id' => $id,
        ]);

        $batch = Batch::where('tahun', $formA->tahun)->where('shuttle_id', $formA->shuttle_id)->where('borang_a',1)->first();
// dd( $batch);
        if ($status == "Tidak Lengkap") {
            $batch->borang_a = "0";
            $batch->save();

            //notification tidak lengkap
            $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $formA->shuttle->id)->first();
            $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();
            foreach ($pengguna_kilangs as $key => $pengguna_kilang) {
                $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $formA, $status, $request->ulasan_phd, $pengguna_kilang));
            }
        } elseif ($status == "Dihantar ke IPJPSM") {
            $batch->borang_a = "2";
            $batch->save();

        }

        if ($shuttle->shuttle_type == '3') {
            if ($status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-3-listA', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-3-listA', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        } elseif ($shuttle->shuttle_type == '4') {
            if ($status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-4-listA', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-4-listA', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        } elseif ($shuttle->shuttle_type == '5') {
            if ($status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-5-listA', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-5-listA', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        }


        // Session::flash('message', 'Borang Berjaya Disahkan.');

        // return redirect()->route('phd.shuttle-3-listA', date("Y"))->with('success','Borang Berjaya Disahkan.');
    }

    public function update_status_phd_form3B(Request $request, $id)
    {
        // dd($request->all());
        $user = auth()->user();
        $formB = FormB::findorfail($id);
        // dd($formB);

        $formB->status = $request->status;
        $formB->save();

        UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'formbs_id' => $id,
        ]);

        if ($formB->suku_tahun == 1) {
            $bulan = 3;
        } elseif ($formB->suku_tahun == 2) {
            $bulan = 6;
        } elseif ($formB->suku_tahun == 3) {
            $bulan = 9;
        } elseif ($formB->suku_tahun == 4) {
            $bulan = 12;
        }


        $batch = Batch::where('tahun', $formB->tahun)->where('bulan', $bulan)->where('shuttle_id', $formB->shuttle_id)->first();

        if ($request->status == "Tidak Lengkap") {

            $batch->borang_b = "0";

            $batch->save();

            //notification tidak lengkap
            // dd($formB->getTable());
            $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $formB->shuttle->id)->first();
            $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();

            foreach ($pengguna_kilangs as $pengguna_kilang) {
                $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $formB, $request->status, $request->ulasan_phd, $pengguna_kilang));
            }
        } elseif ($request->status == "Dihantar ke IPJPSM") {

            $batch->borang_b = "2";
            $batch->save();
        }



        // dd($formB);
        if ($formB->shuttle_type == '3') {

            if ($request->status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-3-listB', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($request->status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-3-listB', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        } elseif ($formB->shuttle_type == '4') {
            if ($request->status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-4-listB', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($request->status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-4-listB', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        }
        elseif ($formB->shuttle_type == '5') {
            if ($request->status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-5-listB', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($request->status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-5-listB', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        }
    }

    public function update_status_phd_form3C(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $formC = FormC::find($id);
        $formC->status = $request->status;
        $formC->save();

        UlasanPhd::create([                                 //tidak lengkap -> ibk -> list dengan status ->tidak lengkap
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'formcs_id' => $id,
        ]);


        $batch = Batch::where('tahun', $formC->tahun)->where('bulan', $formC->bulan)->where('shuttle_id', $formC->shuttle_id)->first();


        if ($request->status == "Tidak Lengkap") {

            $batch->borang_c = "0";
            $batch->save();

            //notification tidak lengkap
            $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $formC->shuttle->id)->first();
            $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();
            foreach ($pengguna_kilangs as $pengguna_kilang) {
                $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $formC, $request->status, $request->ulasan_phd, $pengguna_kilang));
            }
        } elseif ($request->status == "Dihantar ke IPJPSM") {


            $batch->borang_c = "2";
            $batch->save();
        }


        if ($formC->shuttle_type == '3') {
            if ($request->status == "Tidak Lengkap") {
                // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
                return redirect()->route('phd.shuttle-3-listC', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
            } elseif ($request->status == "Dihantar ke IPJPSM") {
                // Session::flash('message', 'Borang Berjaya Disahkan.');
                return redirect()->route('phd.shuttle-3-listC', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
            }
        } elseif ($formC->shuttle_type == '4') {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-4-listC', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
        elseif ($formC->shuttle_type == '5') {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-5-listC', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
    }

    public function update_status_phd_form3D(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $formD = FormD::find($id);
        $formD->status = $request->status;
        $formD->save();

        UlasanPhd::create([
            'ulasan' => $request->ulasan_phd,
            'user_id' => $user->id,
            'formds_id' => $id,
        ]);


        $batch = Batch::where('tahun', $formD->tahun)->where('bulan', $formD->bulan)->where('shuttle_id', $formD->shuttle_id)->first();

        if ($request->status == "Tidak Lengkap") {

            $batch->borang_d = "0";
            $batch->save();

            //notification tidak lengkap
            $pengguna_kilang_data = PenggunaKilang::where('shuttle_id', $formD->shuttle->id)->first();
            $pengguna_kilangs = User::where('pengguna_kilang_id', $pengguna_kilang_data->id)->get();

            foreach ($pengguna_kilangs as $pengguna_kilang) {
                $pengguna_kilang->notify(new BorangTidakLengkapNotification($user, $formD, $request->status, $request->ulasan_phd, $pengguna_kilang));
            }
        } elseif ($request->status == "Dihantar ke IPJPSM") {

            $batch->borang_d = "2";
            $batch->save();
        }




        // $batch = Batch::where('tahun',$formD->tahun)->where('borang_d','1')->first();

        // $batch->borang_d = 2;
        // $batch->save();
        if ($request->status == "Tidak Lengkap") {
            // Session::flash('message', 'Borang Berjaya Dihantar Semula ke IBK.');
            return redirect()->route('phd.shuttle-3-listD', date("Y"))->with('success', 'Borang Berjaya Dihantar Semula ke IBK.');
        } elseif ($request->status == "Dihantar ke IPJPSM") {
            // Session::flash('message', 'Borang Berjaya Disahkan.');
            return redirect()->route('phd.shuttle-3-listD', date("Y"))->with('success', 'Borang Berjaya Disahkan.');
        }
    }

    public function update_status_ipjpsm3A(Request $request, $id)
    {

        $user = auth()->user();
        $formB = FormA::where('shuttle_id',$id)->first();
        $formB->status = $request->status;
        $formB->save();

        $kilang_info = Shuttle::where('id', $id)->first();
        $kilang_info->nilai_harta = $request->nilai_harta;
        // dd($kilang_info->nilai_harta);
        $kilang_info->save();

        if ($kilang_info->shuttle_type == 3) {
            // Session::flash('message', 'Borang Berjaya Diperaku.');
            return redirect()->route('shuttle-3-listA', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
        } elseif ($kilang_info->shuttle_type == 4) {
            // Session::flash('message', 'Borang Berjaya Diperaku.');
            return redirect()->route('shuttle-4-listA', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
        } elseif ($kilang_info->shuttle_type == 5) {
            // Session::flash('message', 'Borang Berjaya Diperaku.');
            return redirect()->route('shuttle-5-listA', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
        }


    }

    public function update_status_ipjpsm3B(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $formB = FormB::find($id);
        $formB->status = $request->status;
        $formB->save();

        UlasanIpjpsm::create([
            'ulasan' => $request->ulasan_ipjpsm,
            'user_id' => $user->id,
            'formbs_id' => $id,
        ]);

        // Session::flash('message', 'Borang Berjaya Diperaku.');

        return redirect()->route('shuttle-3-listB', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }

    public function update_status_ipjpsm3C(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $formC = FormC::find($id);
        $formC->status = $request->status;
        $formC->save();

        UlasanIpjpsm::create([
            'ulasan' => $request->ulasan_ipjpsm,
            'user_id' => $user->id,
            'formcs_id' => $id,
        ]);

        // dd($formC);

        if ($formC->shuttle_type == 3) {
            return redirect()->route('shuttle-3-listC', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
        } elseif ($formC->shuttle_type == 4) {
            return redirect()->route('shuttle-4-listC', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
        } elseif ($formC->shuttle_type == 5) {
            return redirect()->route('shuttle-5-listC', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
        }
    }

    public function update_status_ipjpsm3D(Request $request, $id)
    {
        // dd($request->all());
        $user = auth()->user();
        $formD = FormD::find($id);
        $formD->status = $request->status;
        $formD->total_export_cleaning = $request->total_export_cleaning ?? 0;
        $formD->jumlah_pasaran_tempatan_cleaning = $request->jumlah_pasaran_tempatan_cleaning ?? 0;

        if(!$request->total_export_cleaning){
            // dd('xmasuk');
            $formD->total_export_laporan = $formD->total_export;
            $formD->save();
        }else{
            $formD->total_export_laporan = $request->total_export_cleaning;
            $formD->save();
            // dd($formD);
        }

        if($request->jumlah_pasaran_tempatan_cleaning == null ){
            $formD->jumlah_pasaran_tempatan_laporan = $formD->jumlah_pasaran_tempatan;
            $formD->save();
        }else{
            $formD->jumlah_pasaran_tempatan_laporan = $request->jumlah_pasaran_tempatan_cleaning;
            $formD->save();
        }

        $formD->save();

        $penjualan_pembeli = PenjualanPembeli::where('formds_id',$id)->get();

        foreach ($penjualan_pembeli as $key => $value) {

            if($request->jumlah_jualan_cleaning[$key] == null ){

                // dd($value->jumlah_jualan);
                $value->jumlah_jualan_laporan = $value->jumlah_jualan ?? 0;
            }else{
                $value->jumlah_jualan_laporan = $request->jumlah_jualan_cleaning;
            }

            if($request->total_jumlah_jualan_cleaning == null ){
                $value->total_jumlah_jualan_laporan = $value->total_jumlah_jualan;

            }else{
                $value->total_jumlah_jualan_laporan = $request->total_jumlah_jualan_cleaning;
            }
            $value->jumlah_jualan_cleaning = $request->jumlah_jualan_cleaning[$key] ?? 0;
            $value->total_jumlah_jualan_cleaning = $request->total_jumlah_jualan_cleaning ?? 0;
            $value->save();
        }

        UlasanIpjpsm::create([
            'ulasan' => $request->ulasan_ipjpsm,
            'user_id' => $user->id,
            'formds_id' => $id,
        ]);

        // Session::flash('message', 'Borang Berjaya Diperaku.');

        return redirect()->route('shuttle-3-listD', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }

    public function update_status_ipjpsm4D(Request $request, $id)
    {
        $user = auth()->user();
        $form4D = Form4D::find($id);
        $form4D->status = $request->status;
        $form4D->save();

        UlasanIpjpsm::create([
            'ulasan' => $request->ulasan_ipjpsm,
            'user_id' => $user->id,
            'form4ds_id' => $id,
        ]);

        // Session::flash('message', 'Borang Berjaya Diperaku.');

        return redirect()->route('shuttle-4-listD', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }

    public function update_status_ipjpsm4E(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $Form4E = Form4E::find($id);
        $Form4E->status = $request->status;
        $Form4E->total_export_cleaning = $request->total_export_cleaning ?? 0;
        $Form4E->jumlah_venier_eksport_cleaning = $request->jumlah_venier_eksport_cleaning ?? 0;
        $Form4E->jumlah_pasaran_tempatan_cleaning = $request->jumlah_pasaran_tempatan_cleaning ?? 0;
        $Form4E->jumlah_venier_tempatan_cleaning = $request->jumlah_venier_tempatan_cleaning ?? 0;
        $Form4E->status = $request->status;


        if(!$request->total_export_cleaning){
            // dd('xmasuk');
            $Form4E->total_export_laporan = $Form4E->total_export;
            $Form4E->save();
        }else{
            $Form4E->total_export_laporan = $request->total_export_cleaning;
            $Form4E->save();
            // dd($formD);
        }

        if($request->jumlah_venier_eksport_cleaning == null ){
            $Form4E->jumlah_venier_eksport_laporan = $Form4E->jumlah_venier_eksport;
            $Form4E->save();
        }else{
            $Form4E->jumlah_venier_eksport_laporan = $request->jumlah_venier_eksport_cleaning;
            $Form4E->save();
        }

        if($request->jumlah_pasaran_tempatan_cleaning == null ){
            $Form4E->jumlah_pasaran_tempatan_laporan = $Form4E->jumlah_pasaran_tempatan;
            $Form4E->save();
        }else{
            $Form4E->jumlah_pasaran_tempatan_laporan = $request->jumlah_pasaran_tempatan_cleaning;
            $Form4E->save();
        }

        if($request->jumlah_venier_tempatan_cleaning == null ){
            $Form4E->jumlah_venier_tempatan_laporan = $Form4E->jumlah_venier_tempatan;
            $Form4E->save();
        }else{
            $Form4E->jumlah_venier_tempatan_laporan = $request->jumlah_venier_tempatan_cleaning;
            $Form4E->save();
        }


        $penjualan_pembeli = PenjualanPembeli::where('form4es_id',$id)->get();

        foreach ($penjualan_pembeli as $key => $value) {

            if(!$request->jumlah_jualan_cleaning[$key]){
                $value->jumlah_jualan_laporan = $value->jumlah_jualan ?? 0;
            }else{
                $value->jumlah_jualan_laporan = $request->jumlah_jualan_cleaning[$key];
            }

            if(!$request->total_jumlah_jualan_cleaning){
                $value->total_jumlah_jualan_laporan = $value->total_jumlah_jualan;
            }else{
                $value->total_jumlah_jualan_laporan = $request->total_jumlah_jualan_cleaning;
            }

            $value->jumlah_jualan_cleaning = $request->jumlah_jualan_cleaning[$key] ?? 0;
            $value->total_jumlah_jualan_cleaning = $request->total_jumlah_jualan_cleaning ?? 0;
            $value->save();
        }

        // dd($value);

        $Form4E->save();



        return redirect()->route('shuttle-4-listE', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }

    public function editFormA()
    {
        //form a back button checker
        $form_a_checker = FormA::where('shuttle_id', auth()->user()->shuttle->id)->where('tahun', date("Y"))->first();
        if ($form_a_checker->status == "Sedang Diproses") {
            return redirect()->back()->with('success', 'Borang A telah dihantar semula');
        }

        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();

        $forma_count = FormA::where('status', 'Tidak Lengkap')->where('tahun', date('Y'))->where('shuttle_id', $shuttle->id)->count();
        $form_a = NULL;
        if ($forma_count > 0) {
            $form_a = FormA::where('status', 'Tidak Lengkap')->where('tahun', date('Y'))->first();
        }

        else{
            $form_a = FormA::where('status','Tidak Diisi')->where('tahun',date('Y'))->first();
        }


        // dd($form_a);
        $taraf_sah_syarikat = ModelsTarafSyarikat::get();
        $hak_milik = HakMilik::get();
        $warganegara = Warganegara::get();

        $user = auth()->user();

        $kilang_info = Shuttle::where('id', $user->shuttle_id)->first();

        $ulasan = UlasanPhd::where('formas_id', $form_a->id)->latest('created_at')->first();

        // dd($ulasan);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-3-formA'), 'name' => "Borang 3A"],
        ];

        $kembali = route('user.shuttle-3-senaraiA', date('Y'));


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('ibk.formA', compact('returnArr', 'kilang_info', 'ulasan', 'form_a', 'forma_count'));
    }

    public function updateFormA(Request $request, $id)
    {
        // dd($request->all());
        //form a back button checker

        $keterangan= HakMilik::where('id',$request->status_hak_milik)->first('keterangan');

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

        $batcha = Batch::where('tahun', $formA_update->tahun)->where('bulan', date("n"))->where('borang_a', '0')->where('shuttle_id',$shuttle->id)->first();
        $batcha->status = "Sedang Diproses";
        $batcha->borang_a = 1;
        $batcha->save();

        // dd($formA_checker);
        if ($request->has('lesen_kilang') && $request->has('sijil_ssm')) {
            // dd('masuk lsen ssm');
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
            $shuttle->lesen_kilang  = $lesen_kilang;

            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
            // dd($sijil_ssm);
            $shuttle->sijil_ssm  = $sijil_ssm;
        }
        else if ($request->has('sijil_ssm')) {
            // dd('masuk ssm only');
            $sijil_ssm = $request->file('sijil_ssm')->store('public/uploads/');
            // dd($sijil_ssm);
            $shuttle->sijil_ssm  = $sijil_ssm;
        } else if ($request->has('lesen_kilang')) {
            // dd('masuk lsen only');
            $lesen_kilang = $request->file('lesen_kilang')->store('public/uploads/');
            $shuttle->lesen_kilang  = $lesen_kilang;
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
            $shuttle->status_hak_milik  = $keterangan->keterangan;
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
            $shuttle->status_hak_milik  = $keterangan->keterangan;
            $shuttle->status_warganegara  = request()->status_warganegara;
            $shuttle->nilai_harta  = request()->nilai_harta;
            $shuttle->save();
        }
        // Session::flash('message', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $user_shuttle = $pengguna_kilang->shuttle;
        $daerah_id = $user_shuttle ? $user_shuttle->daerah_id : null;

        if ($daerah_id) {
            $pegawais = User::where('daerah', $daerah_id)->where('kategori_pengguna', 'PHD')->get();

            $delay = now()->addMinutes(1);

            foreach ($pegawais as $pegawai) {
                $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formA_update))->delay($delay));
            }
        }

        return redirect()->route('home-user')->with('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
    }
    public function validator(array $data)
    {
        if (isset($data['alamat_sama'])) {
            return Validator::make($data, [

                'no_telefon' => ['required', 'string','min:9', 'max:255'],
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
                'no_telefon' => ['required','min:9', 'string', 'max:255'],
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
    
    public function update_status_formB(Request $request, $id)
    {
        // Get the form based on ID
        $formB = FormB::find($id);
        
        if (!$formB) {
            return redirect()->back()->with('error', 'Form not found');
        }
        
        // Determine status based on request
        if ($request->has('tak_lengkap')) {
            $status = "Tidak Lengkap";
        } else {
            $status = "Dihantar ke IPJPSM";
        }
        
        // Update the form status
        $formB->status = $status;
        $formB->save();
        
        // Add ulasan if provided
        if ($request->has('ulasan') && !empty($request->ulasan)) {
            UlasanPhd::create([
                'form_id' => $id,
                'form_type' => 'FormB',
                'ulasan' => $request->ulasan,
                'user_id' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
