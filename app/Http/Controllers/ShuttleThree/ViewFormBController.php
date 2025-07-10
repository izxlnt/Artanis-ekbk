<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\ProdukPengeluaran;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\UlasanPhd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewFormBController extends Controller
{
    public function shuttle_3_form_view($id)
    {
        // dd($id);
        $formb = FormB::where('id',$id)->first();
        $id =$formb->id;

        $kilang_info = Shuttle::where('id',$formb->shuttle_id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();
        // dd($kilang_info);

        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();


        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''));
        // dd(auth()->user()->kategori_pengguna);

        $array = [
            'kilang_info' => $kilang_info,
            'kategori_pekerja' => $kategori_pekerja,
            'formb' => $formb,
            'id' => $id,
            'form_b' => $form_b,
            'layout' => $layout
        ];

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orwhere('status', 'Lulus')
                ->count();

        // dd($form_a_checker);

        if ($formb->suku_tahun != 1) {
            $lastmonth = $formb->suku_tahun - 1;

            $form_b_checker = FormB::where('shuttle_id', $kilang_info->id)
            ->where('suku_tahun', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '==' ,'Dihantar ke IPJPSM')->orwhere('status', 'Lulus')
            ->count();
        } else {
            $lastmonth = $formb->suku_tahun;

            $form_b_checker = FormB::where('shuttle_id', $kilang_info->id)
            ->where('suku_tahun', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=' ,'Dihantar ke IPJPSM')->orwhere('status', 'Lulus')
            ->count();
        }


        if($formb->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3B"],
            ];

            $kembali = route('phd.shuttle-3-listB', date('Y'));
        }
        elseif($formb->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Senarai Borang 4B"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 4B"],
            ];

            $kembali = route('phd.shuttle-4-listB', date('Y'));
        }
        elseif($formb->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Senarai Borang 5B"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 5B"],
            ];

            $kembali = route('phd.shuttle-5-listB', date('Y'));
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }

        // if ($form_b_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang B suku tahun sebelum ini terlebih dahulu.');
        // }


        return view('admins.shuttle-three.view-form3b', $array, compact('returnArr'));



    }

    public function shuttle_3_form_view_phd($id)
    {
        // dd($id);
        $formb = FormB::where('id',$id)->first();
        $id =$formb->id;

        $kilang_info = Shuttle::where('id',$formb->shuttle_id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();
        // dd($kilang_info);

        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();


        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''));
        // dd(auth()->user()->kategori_pengguna);

        $array = [
            'kilang_info' => $kilang_info,
            'kategori_pekerja' => $kategori_pekerja,
            'formb' => $formb,
            'id' => $id,
            'form_b' => $form_b,
            'layout' => $layout
        ];

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orwhere('status', 'Lulus')
                ->count();

        // dd($form_a_checker);

        //form b checker
        if ($formb->suku_tahun != 1) {
            $lastmonth = $formb->suku_tahun - 1;

            $form_b_checker = FormB::where('shuttle_id', $kilang_info->id)
            ->where('suku_tahun', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '==' ,'Dihantar ke IPJPSM')->orwhere('status', 'Lulus')
            ->count();
        } else {
            $lastmonth = $formb->suku_tahun;

            $form_b_checker = FormB::where('shuttle_id', $kilang_info->id)
            ->where('suku_tahun', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=' ,'Dihantar ke IPJPSM')->orwhere('status', 'Lulus')
            ->count();
        }


        if($formb->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3B"],
            ];

            $kembali = route('phd.shuttle-3-listB', date('Y'));
        }
        elseif($formb->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listB', date('Y')), 'name' => "Senarai Borang 4B"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 4B"],
            ];

            $kembali = route('phd.shuttle-4-listB', date('Y'));
        }
        elseif($formb->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listB', date('Y')), 'name' => "Senarai Borang 5B"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 5B"],
            ];

            $kembali = route('phd.shuttle-5-listB', date('Y'));
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        // if ($form_a_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        // }

        // if ($form_b_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang B suku tahun sebelum ini terlebih dahulu.');
        // }


        return view('admins.shuttle-three.view-form3b-phd', $array, compact('returnArr'));



    }

    public function shuttle_3_formA_view($id)
    {

        $forma = FormA::where('id',$id)->with('shuttle')->first();
        $kilang_info = Shuttle::where('id',$forma->shuttle_id)->first();
        // dd($kilang_info);



        // dd($forma);
        // $id =$forma->id;


        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''));

        $array = [
            'kilang_info' => $kilang_info,
            'forma' => $forma,
            'id' => $id,
            'layout' => $layout
        ];

        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Senarai Borang 3A"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3A"],
            ];

            $kembali = route('phd.shuttle-3-listA', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Senarai Borang 4A"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 4A"],
            ];

            $kembali = route('phd.shuttle-4-listA', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Senarai Borang 5A"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 5A"],
            ];

            $kembali = route('phd.shuttle-5-listA', date('Y'));
        }



        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.shuttle-three.view-form3a', $array, compact('returnArr'));
    }

    public function shuttle_3_formA_view_phd($id)
    {

        $forma = FormA::where('id',$id)->with('shuttle')->first();
        $kilang_info = Shuttle::where('id',$forma->shuttle_id)->first();
        // dd($kilang_info);



        // dd($forma);
        // $id =$forma->id;


        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''));

        $array = [
            'kilang_info' => $kilang_info,
            'forma' => $forma,
            'id' => $id,
            'layout' => $layout
        ];

        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Senarai Borang 3A"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3A"],
            ];

            $kembali = route('phd.shuttle-3-listA', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listA', date('Y')), 'name' => "Senarai Borang 4A"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 4A"],
            ];

            $kembali = route('phd.shuttle-4-listA', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listA', date('Y')), 'name' => "Senarai Borang 5A"],
                ['link' => route('phd.shuttle-3-view-formB', date('Y')), 'name' => "Borang 5A"],
            ];

            $kembali = route('phd.shuttle-5-listA', date('Y'));
        }



        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.shuttle-three.view-form3a-phd', $array, compact('returnArr'));
    }

    public function shuttle_3_form_view_form3B($id)
    {
        $kilang_info = Shuttle::where('id',$id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();

        $formb = FormB::where('shuttle_id',$kilang_info->id)->first();
        $id =$formb->id;

        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();

        $layout = auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''));
        // dd(auth()->user()->kategori_pengguna);
        $ulasan_phd=UlasanPhd::where('formbs_id',$id)->get();
        // dd($ulasan_phd);

        $array = [
            'kilang_info' => $kilang_info,
            'kategori_pekerja' => $kategori_pekerja,
            'formb' => $formb,
            'id' => $id,
            'form_b' => $form_b,
            'layout' => $layout,
            'ulasan_phd' =>$ulasan_phd
        ];

        return view('admins.shuttle-three.view-form3b', $array);

    }

    public function ibk_shuttle_3_formA_view($id)
    {
        $forma = FormA::where('id',$id)->with('shuttle')->first();
        $kilang_info = Shuttle::where('id',$forma->shuttle_id)->first();


        $layout = 'layouts.layout-ibk-nicepage';

        $array = [
            'kilang_info' => $kilang_info,
            'forma' => $forma,
            'id' => $id,
            'layout' => $layout
        ];

        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-listA', date('Y')), 'name' => "BORANG 3A"],
            ];
            $kembali = route('user.shuttle-4-senaraiA', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-listA', date('Y')), 'name' => "BORANG 4A"],
            ];
            $kembali = route('user.shuttle-4-senaraiA', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "BORANG 5A"],
            ];
            $kembali = route('user.shuttle-5-senaraiA', date('Y'));
        }



        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.view-form3a-ibk', $array, compact('returnArr'));
    }

    public function jpn_shuttle_3_formA_view($id)
    {
        $forma = FormA::where('id',$id)->with('shuttle')->first();
        $kilang_info = Shuttle::where('id',$forma->shuttle_id)->first();


        $layout = 'layouts.layout-jpn-nicepage';

        $array = [
            'kilang_info' => $kilang_info,
            'forma' => $forma,
            'id' => $id,
            'layout' => $layout
        ];

        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Senarai Borang 3A"],
                ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Borang 3A"],
            ];
            $kembali = route('jpn.shuttle-3-listA-jpn', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Senarai Borang 4A"],
                ['link' => route('jpn.shuttle-4-listA-jpn', date('Y')), 'name' => "Borang 4A"],
            ];
            $kembali = route('jpn.shuttle-4-listA-jpn', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Senarai Borang 5A"],
                ['link' => route('jpn.shuttle-5-listA-jpn', date('Y')), 'name' => "Borang 5A"],
            ];
            $kembali = route('jpn.shuttle-5-listA-jpn', date('Y'));
        }



        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.view-form3a-ibk', $array, compact('returnArr'));
    }

    public function ibk_shuttle_3_form_view_form3B($id)
    {
        $formb = FormB::where('id',$id)->first();
        $kilang_info = Shuttle::where('id',$formb->shuttle_id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();



        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();

        $layout = 'layouts.layout-ibk-nicepage';
        $ulasan_phd=UlasanPhd::where('formbs_id',$id)->get();
        // dd($ulasan_phd);

        $array = [
            'kilang_info' => $kilang_info,
            'kategori_pekerja' => $kategori_pekerja,
            'formb' => $formb,
            'id' => $id,
            'form_b' => $form_b,
            'layout' => $layout,
            'ulasan_phd' =>$ulasan_phd
        ];

        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-listA', date('Y')), 'name' => "BORANG 3B"],
            ];
            $kembali = route('user.shuttle-3-senaraiB', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-listA', date('Y')), 'name' => "BORANG 4B"],
            ];
            $kembali = route('user.shuttle-4-senaraiB', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "BORANG 5B"],
            ];
            $kembali = route('user.shuttle-5-senaraiB', date('Y'));
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.view-form3b-ibk', $array, compact('returnArr'));

    }

    public function jpn_shuttle_3_form_view_form3B($id)
    {
        $formb = FormB::where('id',$id)->first();
        $kilang_info = Shuttle::where('id',$formb->shuttle_id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();



        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();

        $layout = 'layouts.layout-jpn-nicepage';
        $ulasan_phd=UlasanPhd::where('formbs_id',$id)->get();
        // dd($ulasan_phd);

        $array = [
            'kilang_info' => $kilang_info,
            'kategori_pekerja' => $kategori_pekerja,
            'formb' => $formb,
            'id' => $id,
            'form_b' => $form_b,
            'layout' => $layout,
            'ulasan_phd' =>$ulasan_phd
        ];

        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Senarai Borang 3B"],
                ['link' => route('jpn.shuttle-3-listB-jpn', date('Y')), 'name' => "Borang 3B"],
            ];
            $kembali = route('jpn.shuttle-3-listB-jpn', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Senarai Borang 4B"],
                ['link' => route('jpn.shuttle-4-listB-jpn', date('Y')), 'name' => "Borang 4B"],
            ];
            $kembali = route('jpn.shuttle-4-listB-jpn', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Senarai Borang 5B"],
                ['link' => route('jpn.shuttle-5-listB-jpn', date('Y')), 'name' => "Borang 5B"],
            ];
            $kembali = route('jpn.shuttle-5-listB-jpn', date('Y'));
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.view-form3b-ibk', $array, compact('returnArr'));

    }

    public function shuttle_3_form_view_form3A_ipjpsm($id)
    {
        // dd($id);
        $kilang_info = Shuttle::where('id',$id)->first();

        $forma = FormA::where('shuttle_id',$id)->with('shuttle')->first();
        $id =$forma->id;


        // $breadcrumbs    = [
        //     ['link' => route('home'), 'name' => "Laman Utama"],
        //     ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Perakuan Maklumat"],
        //     ['link' => route('ipjpsm.shuttle-3-view-formA', date('Y')), 'name' => "Borang 3A - Maklumat Kilang Papan"],
        // ];

        // $kembali = route('shuttle-3-listA', date('Y'));


        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Perakuan Maklumat"],
                ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('shuttle-3-listA', date('Y')), 'name' => "Senarai Borang 3A"],
                ['link' => route('ipjpsm.shuttle-3-view-formA', date('Y')), 'name' => "Borang 3A"],
            ];

            if($forma->status == 'Lulus'){
                $kembali = route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y'));

            }
            else{
                $kembali = route('shuttle-3-listA', date('Y'));

            }
        }

        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Perakuan Maklumat"],
                ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('shuttle-4-listA', date('Y')), 'name' => "Senarai Borang 4A"],
                ['link' => route('ipjpsm.shuttle-3-view-formA', date('Y')), 'name' => "Borang 4A"],
            ];

            if($forma->status == 'Lulus'){
                $kembali = route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y'));

            }
            else{
                $kembali = route('shuttle-4-listA', date('Y'));

            }
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Perakuan Maklumat"],
                ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('shuttle-5-listA', date('Y')), 'name' => "Senarai Borang 5A"],
                ['link' => route('ipjpsm.shuttle-3-view-formA', date('Y')), 'name' => "Borang 5A"],
            ];

            if($forma->status == 'Lulus'){
                $kembali = route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y'));

            }
            else{
                $kembali = route('shuttle-5-listA', date('Y'));

            }
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('livewire.view-form3a-Ipjpsm',compact('kilang_info','forma','returnArr'));
    }


    public function shuttle_3_form_view_form3B_ipjpsm($id)
    {
        // dd($id);

        $kilang_info = FormB::where('id',$id)->first();
        // $kilang_info = Shuttle::where('id',$formb->shuttle_id)->first();
        // dd($kilang_info);
        // $kategori_pekerja = KategoriGunaTenaga::get();


        // $formb = FormB::where('shuttle_id',$kilang_info->id)->where('status','Dihantar ke IPJPSM')->first();
        // $id =$formb->shuttle_id;

        // $ulasan_phd=UlasanPhd::where('formbs_id',$id)->get();
        // // dd($ulasan_phd);

        // $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();

        // dd($form_b);
        // return view('livewire.view-form3b-Ipjpsm',compact('kilang_info','kategori_pekerja','form_b','id','ulasan_phd'));

        // $breadcrumbs    = [
        //     ['link' => route('home'), 'name' => "Laman Utama"],
        //     ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Perakuan Maklumat"],
        //     ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3B - Jumlah Guna Tenaga"],
        // ];

        // $kembali = route('shuttle-3-listB', date('Y'));


        if($kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Perakuan Maklumat"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],
                ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3B"],
            ];

            $kembali = route('shuttle-3-listB', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Perakuan Maklumat"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Senarai Borang 4B"],
                ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 4B"],
            ];

            $kembali = route('shuttle-4-listB', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Perakuan Maklumat"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Senarai Borang 5B"],
                ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 5B"],
            ];

            $kembali = route('shuttle-5-listB', date('Y'));
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('livewire.view-form3b-Ipjpsm',compact('returnArr','kilang_info'));
    }

    public function view_form3B_ipjpsm($id)
    {
        // dd($id);
        $kilang_info = FormB::where('id',$id)->first();
        // dd($kilang_info);

        // $kilang_info = Shuttle::where('id',$formb->shuttle_id)->first();
        // dd($kilang_info);
        // $kategori_pekerja = KategoriGunaTenaga::get();


        $formb = FormB::where('id',$id)->where('status','Lulus')->first();
        $kategori_pekerja = KategoriGunaTenaga::get();

        // $ulasan_phd = UlasanPhd::where('formbs_id', $formb->id)->get();
        // dd($ulasan_phd);

        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();

        if($kilang_info->shuttle_type == '3' && $formb->status == 'Lulus'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('shuttle-3-listB', date('Y')), 'name' => "Senarai Borang 3B"],
                ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 3B"],
            ];

            $kembali = route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y'));
        }

        elseif($kilang_info->shuttle_type == '4' && $formb->status == 'Lulus'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('shuttle-4-listB', date('Y')), 'name' => "Senarai Borang 4B"],
                ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 4B"],
            ];

            $kembali = route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '5' && $formb->status == 'Lulus'){
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('shuttle-5-listB', date('Y')), 'name' => "Senarai Borang 5B"],
                ['link' => route('ipjpsm.shuttle-3-view-formB', date('Y')), 'name' => "Borang 5B"],
            ];

            $kembali = route('ipjpsm.borang-keseluruhan.shuttle5.borangB', date('Y'));
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('bpe.view-data-cleaning-b',compact('returnArr','kilang_info','formb','form_b'));
    }


    public function shuttle_3_form_view_form3C_ipjpsm($id)
    {

        // $kilang_info = Shuttle::where('id',$id)->first();
        // dd($kilang_info);
        $kategori_pekerja = KategoriGunaTenaga::get();


        // $formc = FormC::where('shuttle_id',$kilang_info->id)->where('status','Dihantar ke IPJPSM')->first();
        $formc = FormC::findorfail($id);
        // dd($formc);
        $kilang_info = Shuttle::findorfail($formc->shuttle->id);

        // $id =$formc->id;
        // dd($formc);

        $ulasan_phd=UlasanPhd::where('formcs_id',$formc->id)->get();


        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        $kumpulan_kayu = KumpulanKayu::get();

        $form_c = KemasukanBahan::where('formcs_id',$formc->id)->get();
        // $form_c = $form;

        // dd($form_c[2]);

        $kemasukan_bahan_calc_kkb = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '1');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kks = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '2');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kkr = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '3');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kayu_lembut = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '4');
        })->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_lain_lain = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '5');
        })->where('formcs_id', $formc->id)->first();

        $breadcrumbs3c    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
            ['link' => route('ipjpsm.shuttle-3-view-formC', date('Y')), 'name' => "Borang 3C"],
        ];

        $breadcrumbs4c    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listC', date('Y')), 'name' => "Senarai Borang 4C"],
            ['link' => route('ipjpsm.shuttle-3-view-formC', date('Y')), 'name' => "Borang 4C"],
        ];

        $breadcrumbs5c    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
            ['link' => route('ipjpsm.shuttle-3-view-formC', date('Y')), 'name' => "Borang 5C"],
        ];

        $kembali4c = route('shuttle-4-listC', date('Y'));

        if($formc->status == 'Lulus'){
            $kembali3c = route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y'));

        }
        else
        $kembali3c = route('shuttle-3-listC', date('Y'));




        if($formc->status == 'Lulus'){
            $kembali5c = route('ipjpsm.borang-keseluruhan.shuttle5.borangC', date('Y'));

        }
        else
        $kembali5c = route('shuttle-5-listC', date('Y'));

        if($formc->shuttle_type == 3){
            $returnArr = [
                'breadcrumbs' => $breadcrumbs3c,
                'kembali'     => $kembali3c,
            ];
        }

        elseif($formc->shuttle_type ==4){
            $returnArr = [
                'breadcrumbs' => $breadcrumbs4c,
                'kembali'     => $kembali4c,
            ];
        }

        elseif($formc->shuttle_type ==5){
            $returnArr = [
                'breadcrumbs' => $breadcrumbs5c,
                'kembali'     => $kembali5c,
            ];
        }


        return view('livewire.view-form3c-Ipjpsm',compact('returnArr','kilang_info','kategori_pekerja',
        'form_c','id','ulasan_phd','formc','species','kumpulan_kayu',
        'kemasukan_bahan_calc_kkb', 'kemasukan_bahan_calc_kkr',
        'kemasukan_bahan_calc_kks', 'kemasukan_bahan_calc_kayu_lembut', 'kemasukan_bahan_calc_lain_lain'));
    }

    public function shuttle_3_form_view_form3D_ipjpsm($id)
    {

        // $kilang_info = Shuttle::where('id',$id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();


        // $formd = FormD::where('shuttle_id',$kilang_info->id)->where('status','Dihantar ke IPJPSM')->first();
        $formd = FormD::findorfail($id);

        $kilang_info = Shuttle::findorfail($formd->shuttle->id);
        // dd($formd);

        $id =$formd->id;

        $ulasan_phd=UlasanPhd::where('formds_id',$id)->get();
        // dd($ulasan_phd);
        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $form_d = PenjualanPembeli::where('formds_id',$formd->id)->get();

        $form_d_count = PenjualanPembeli::where('formds_id',$formd->id)->count();
        // dd($form_d_count);
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],
            ['link' => route('ipjpsm.shuttle-3-view-formD', date('Y')), 'name' => "Borang 3D"],
        ];

        $kembali = route('shuttle-3-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('livewire.view-form3d-Ipjpsm',compact('returnArr','kilang_info','kategori_pekerja','form_d','id','ulasan_phd','formd','jenis_pembeli','form_d_count'));
    }

    public function view_form3D_ipjpsm($id)
    {

        // $kilang_info = Shuttle::where('id',$id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();


        // $formd = FormD::where('shuttle_id',$kilang_info->id)->where('status','Dihantar ke IPJPSM')->first();
        $formd = FormD::findorfail($id);

        $kilang_info = Shuttle::findorfail($formd->shuttle->id);
        // dd($formd);

        $id =$formd->id;

        $ulasan_phd=UlasanPhd::where('formds_id',$id)->get();
        // dd($ulasan_phd);
        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $form_d = PenjualanPembeli::where('formds_id',$formd->id)->get();

        $form_d_count = PenjualanPembeli::where('formds_id',$formd->id)->count();
        // dd($form_d_count);
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('shuttle-3-listD', date('Y')), 'name' => "Senarai Borang 3D"],
            ['link' => route('ipjpsm.shuttle-3-view-formD', date('Y')), 'name' => "Borang 3D"],
        ];

        $kembali = route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y'));


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('bpe.view-form3d-Ipjpsm',compact('returnArr','kilang_info','kategori_pekerja','form_d','id','ulasan_phd','formd','jenis_pembeli','form_d_count'));
    }

    public function shuttle_4_form_view_form4D_ipjpsm($id)
    {
        $kilang_info = Shuttle::where('id',$id)->first();

        // $form4d = Form4D::where('shuttle_id',$kilang_info->id)->first();
        $form4d = Form4D::findorfail($id);

        $id =$form4d->id;

        // dd($form4d);
        $nipis = ProdukPengeluaran::where('form4ds_id',$form4d->id)->where('produk_ketebalan','<','12')->get();
        $kayu_tebal = ProdukPengeluaran::where('form4ds_id',$form4d->id)->where('produk_ketebalan','>=','12')->get();

        if($kayu_tebal->isEmpty()){
            $tebal = null;
        }else{
            $tebal = $kayu_tebal;
        }

        $jumlah_kecil_nipis =ProdukPengeluaran::where('form4ds_id',$form4d->id)->where('produk_ketebalan','<','12')->first();
        $jumlah_kecil_tebal =ProdukPengeluaran::where('form4ds_id',$form4d->id)->where('produk_ketebalan','>=','12')->first();

        $form4_d = PenjualanPembeli::where('formds_id',$form4d->id)->get();
        // dd($form4_d);
        $form_d_count = PenjualanPembeli::where('formds_id',$form4d->id)->count();

        $ulasan_phd=UlasanPhd::where('form4ds_id',$id)->get();

        $breadcrumbs    = [
            // ['link' => route('home'), 'name' => "Laman Utama"],                 //belum lengkapppppppp
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Senarai Borang 4D"],
            ['link' => route('ipjpsm.shuttle-4-view-formD', date('Y')), 'name' => "Borang 4D"],
        ];

        if($form4d->status== 'Lulus'){
            $kembali = route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y'));
        }

        else
        $kembali = route('shuttle-4-listD', date('Y'));


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('livewire.view-form4d-Ipjpsm',compact('returnArr','form_d_count','kilang_info','form4_d','id','ulasan_phd','form4d','nipis','tebal','jumlah_kecil_nipis','jumlah_kecil_tebal'));
    }


    public function shuttle_4_form_view_form4E_ipjpsm($id)
    {
        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();


        $kilang_info = Shuttle::where('id',$id)->first();

        // $form4e = Form4E::where('shuttle_id',$kilang_info->id)->first();
        $form4e = Form4E::findorfail($id);

        // dd($form4e);

        $id =$form4e->id;

        $form4_e = PenjualanPembeli::where('form4es_id',$form4e->id)->get();

        $form_d_count = PenjualanPembeli::where('form4es_id',$form4e->id)->count();

        $ulasan_phd=UlasanPhd::where('form4es_id',$id)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],                 //belum lengkapppppppp
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Senarai Borang 4E"],
            ['link' => route('ipjpsm.shuttle-4-view-formE', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('shuttle-4-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('livewire.view-form4e-Ipjpsm',compact('returnArr','form_d_count','kilang_info','id','ulasan_phd','form4e','form4_e','jenis_pembeli'));
    }

    public function view_form4E_ipjpsm($id)
    {
        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();


        $kilang_info = Shuttle::where('id',$id)->first();

        // $form4e = Form4E::where('shuttle_id',$kilang_info->id)->first();
        $form4e = Form4E::findorfail($id);

        $id =$form4e->id;

        $form4_e = PenjualanPembeli::where('form4es_id',$form4e->id)->get();

        $form_d_count = PenjualanPembeli::where('form4es_id',$form4e->id)->count();

        $ulasan_phd=UlasanPhd::where('form4es_id',$id)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Senarai Penuh Maklumat Borang"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listE', date('Y')), 'name' => "Senarai Penuh Borang 4E"],
            ['link' => route('ipjpsm.shuttle-4-view-formE', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('bpe.view-form4e-Ipjpsm',compact('returnArr','form_d_count','kilang_info','id','ulasan_phd','form4e','form4_e','jenis_pembeli'));
    }
}
