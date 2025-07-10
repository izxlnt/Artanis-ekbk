<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Models\Form4D;
use App\Models\Form5D;
use App\Models\FormA;
use App\Models\FormD;
use App\Models\JenisKayu;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\PengeluaranForm5D;
use App\Models\PenjualanPembeli;
use App\Models\ProdukPengeluaran;
use App\Models\Shuttle;
use App\Models\Spesis;
use Illuminate\Http\Request;

class ViewFormDController extends Controller
{
    public function shuttle_3_formD_view($id)
    {
        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();



        $formd = FormD::where('id', $id)->first();
        $id = $formd->id;
        $kilang_info = Shuttle::where('id', $formd->shuttle_id)->first();


        if ($formd->bulan != 1) {
            $lastmonth = $formd->bulan - 1;
            $form_d_checker = FormD::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $formd->bulan;
            $form_d_checker = FormD::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();
                // dd($form_a_checker);

        $form_d = PenjualanPembeli::where('formds_id', $formd->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Borang 3D "],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_d_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang D bulan sebelum ini terlebih dahulu.');
        }

        return view('admins.shuttle-three.view-form3d', compact('kilang_info', 'form_d', 'id', 'jenis_pembeli', 'formd', 'returnArr'));
    }

    public function shuttle_3_formD_view_phd($id)
    {
        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();



        $formd = FormD::where('id', $id)->first();
        // $id = $formd->id;
        // dd($formd);
        $kilang_info = Shuttle::where('id', $formd->shuttle_id)->first();


        if ($formd->bulan != 1) {
            $lastmonth = $formd->bulan - 1;
            $form_d_checker = FormD::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $formd->bulan;
            $form_d_checker = FormD::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();
                // dd($form_a_checker);

        $form_d = PenjualanPembeli::where('formds_id', $formd->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],
            ['link' => route('phd.shuttle-3-listD', date('Y')), 'name' => "Borang 3D "],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // if ($form_a_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        // }
        // if ($form_d_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang D bulan sebelum ini terlebih dahulu.');
        // }

        return view('admins.shuttle-three.view-form3d-phd', compact('kilang_info', 'form_d', 'id', 'jenis_pembeli', 'formd', 'returnArr'));
    }

    public function ibk_shuttle_3_formD_view($id)
    {

        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $kilang_info = Shuttle::where('id', $id)->first();

        $formd = FormD::where('id', $id)->first();
        $id = $formd->id;

        $form_d = PenjualanPembeli::where('formds_id', $formd->id)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-3-senaraiD', date('Y')), 'name' => "BORANG 3D"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $layout = 'layouts.layout-ibk-nicepage';


        return view('admins.shuttle-three.view-form3d-ibk', compact('kilang_info', 'form_d', 'id', 'jenis_pembeli', 'formd', 'returnArr','layout'));
    }

    public function jpn_shuttle_3_formD_view($id)
    {

        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $kilang_info = Shuttle::where('id', $id)->first();

        $formd = FormD::where('id', $id)->first();
        $id = $formd->id;

        $form_d = PenjualanPembeli::where('formds_id', $formd->id)->get();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('jpn.shuttle-3-listD-jpn', date('Y')), 'name' => "Senarai Borang 3D"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Borang 3D"],
        ];

        $kembali = route('jpn.shuttle-3-listD-jpn', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $layout = 'layouts.layout-jpn-nicepage';

        return view('admins.shuttle-three.view-form3d-ibk', compact('kilang_info', 'form_d', 'id', 'jenis_pembeli', 'formd', 'returnArr','layout'));
    }


    public function shuttle_4_formD_view($id)
    {
        $form4d = Form4D::where('id', $id)->first();
        $id = $form4d->id;

        $kilang_info = Shuttle::where('id', $form4d->shuttle_id)->first();

        if ($form4d->bulan != 1) {
            $lastmonth = $form4d->bulan - 1;
            $form_d_checker = Form4D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form4d->bulan;
            $form_d_checker = Form4D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();
        $nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<=', '11.99')->get();
        $kayu_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12.00')->get();

        if($kayu_tebal->isEmpty()){
            $tebal = null;
        }else{
            $tebal = $kayu_tebal;
        }

        // dd($tebal);
        $jumlah_kecil_nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<', '12')->first();
        $jumlah_kecil_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12')->first();

        // dd($tebal);



        // dd($tebal);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Senarai Borang 4D"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Borang 4D"],
        ];

        $kembali = route('phd.shuttle-4-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_d_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang D bulan sebelum ini terlebih dahulu.');
        }


        return view('admins.shuttle-four.view-form4d', compact('returnArr', 'kilang_info', 'nipis', 'tebal', 'id', 'form4d', 'tebal', 'jumlah_kecil_nipis', 'jumlah_kecil_tebal'));
    }
    public function shuttle_4_formD_view_phd($id)
    {
        $form4d = Form4D::where('id', $id)->first();
        $id = $form4d->id;

        $kilang_info = Shuttle::where('id', $form4d->shuttle_id)->first();

        if ($form4d->bulan != 1) {
            $lastmonth = $form4d->bulan - 1;
            $form_d_checker = Form4D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form4d->bulan;
            $form_d_checker = Form4D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();
        $nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<=', '11.99')->get();
        $kayu_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12.00')->get();

        if($kayu_tebal->isEmpty()){
            $tebal = null;
        }else{
            $tebal = $kayu_tebal;
        }

        // dd($tebal);
        $jumlah_kecil_nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<', '12')->first();
        $jumlah_kecil_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12')->first();

        // dd($tebal);



        // dd($tebal);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Senarai Borang 4D"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Borang 4D"],
        ];

        $kembali = route('phd.shuttle-4-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // if ($form_a_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        // }
        // if ($form_d_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang D bulan sebelum ini terlebih dahulu.');
        // }


        return view('admins.shuttle-four.view-form4d-phd', compact('returnArr', 'kilang_info', 'nipis', 'tebal', 'id', 'form4d', 'tebal', 'jumlah_kecil_nipis', 'jumlah_kecil_tebal'));
    }


    public function shuttle_5_formD_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_kumai = JenisKayu::get();

        $form5d = Form5D::findorfail($id);

        $kilang_info = Shuttle::findorfail($form5d->shuttle_id);

        // $form5d = Form5D::where('shuttle_id',$kilang_info->id)->first();
        $id = $form5d->id;

        if ($form5d->bulan != 1) {
            $lastmonth = $form5d->bulan - 1;
            $form_d_checker = Form5D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form5d->bulan;
            $form_d_checker = Form5D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $form_5d = PengeluaranForm5D::where('form5ds_id', $form5d->id)->get();
        // dd($form_5d);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Senarai Borang 5D"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Borang 5D"],
        ];

        $kembali = route('phd.shuttle-5-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_d_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang D bulan sebelum ini terlebih dahulu.');
        }

        return view('admins.shuttle-five.view-form5d', compact('kilang_info', 'id', 'form5d', 'jenis_kumai', 'form_5d', 'returnArr'));
    }

    public function shuttle_5_formD_view_phd($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        $jenis_kumai = JenisKayu::get();

        $form5d = Form5D::findorfail($id);

        $kilang_info = Shuttle::findorfail($form5d->shuttle_id);

        // $form5d = Form5D::where('shuttle_id',$kilang_info->id)->first();
        $id = $form5d->id;

        if ($form5d->bulan != 1) {
            $lastmonth = $form5d->bulan - 1;
            $form_d_checker = Form5D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            ->count();
        } else {
            $lastmonth = $form5d->bulan;
            $form_d_checker = Form5D::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $form_5d = PengeluaranForm5D::where('form5ds_id', $form5d->id)->get();
        // dd($form_5d);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Senarai Borang 5D"],
            ['link' => route('phd.shuttle-5-listD', date('Y')), 'name' => "Borang 5D"],
        ];

        $kembali = route('phd.shuttle-5-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_d_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang D bulan sebelum ini terlebih dahulu.');
        }

        return view('admins.shuttle-five.view-form5d-phd', compact('kilang_info', 'id', 'form5d', 'jenis_kumai', 'form_5d', 'returnArr'));
    }
}
