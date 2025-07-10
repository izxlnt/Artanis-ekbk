<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Models\Form4E;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use Illuminate\Http\Request;

class ViewFormEController extends Controller
{
    public function shuttle_4_formE_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();

        $form4e = Form4E::where('id', $id)->first();
        $id = $form4e->id;

        $kilang_info = Shuttle::where('id', $form4e->shuttle_id)->first();

        if ($form4e->bulan != 1) {
            $lastmonth = $form4e->bulan - 1;
            $form_e_checker = Form4E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form4e->bulan;
            $form_e_checker = Form4E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $form4_e = PenjualanPembeli::where('form4es_id', $form4e->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Senarai Borang 4E"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('phd.shuttle-4-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_e_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang E bulan sebelum ini terlebih dahulu.');
        }

        return view('admins.shuttle-four.view-form4e', compact('returnArr', 'kilang_info', 'form4_e', 'id', 'jenis_pembeli', 'form4e'));
    }

    public function shuttle_4_formE_view_phd($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();

        $form4e = Form4E::where('id', $id)->first();
        $id = $form4e->id;

        $kilang_info = Shuttle::where('id', $form4e->shuttle_id)->first();

        if ($form4e->bulan != 1) {
            $lastmonth = $form4e->bulan - 1;
            $form_e_checker = Form4E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form4e->bulan;
            $form_e_checker = Form4E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $form4_e = PenjualanPembeli::where('form4es_id', $form4e->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Senarai Borang 4E"],
            ['link' => route('phd.shuttle-4-listE', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('phd.shuttle-4-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // if ($form_a_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        // }
        // if ($form_e_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang E bulan sebelum ini terlebih dahulu.');
        // }

        return view('admins.shuttle-four.view-form4e-phd', compact('returnArr', 'kilang_info', 'form4_e', 'id', 'jenis_pembeli', 'form4e'));
    }

    public function shuttle_5_formE_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $form5e = Form5E::findorfail($id);

        $kilang_info = Shuttle::where('id', $form5e->shuttle_id)->first();

        if ($form5e->bulan != 1) {
            $lastmonth = $form5e->bulan - 1;
            $form_e_checker = Form5E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form5e->bulan;
            $form_e_checker = Form5E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Senarai Borang 5E"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('phd.shuttle-5-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_e_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang E bulan sebelum ini terlebih dahulu.');
        }


        return view('admins.shuttle-five.view-form5e', compact('kilang_info', 'id', 'form5e', 'returnArr'));
    }

    public function shuttle_5_formE_view_phd($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $form5e = Form5E::findorfail($id);

        $kilang_info = Shuttle::where('id', $form5e->shuttle_id)->first();

        if ($form5e->bulan != 1) {
            $lastmonth = $form5e->bulan - 1;
            $form_e_checker = Form5E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form5e->bulan;
            $form_e_checker = Form5E::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Senarai Borang 5E"],
            ['link' => route('phd.shuttle-5-listE', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('phd.shuttle-5-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_e_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang E bulan sebelum ini terlebih dahulu.');
        }


        return view('admins.shuttle-five.view-form5e-phd', compact('kilang_info', 'id', 'form5e', 'returnArr'));
    }
}
