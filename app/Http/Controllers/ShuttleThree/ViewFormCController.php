<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Models\FormC;
use App\Models\FormA;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Shuttle;
use App\Models\Spesis;
use Illuminate\Http\Request;

class ViewFormCController extends Controller
{
    public function shuttle_3_formC_view($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();


        if ($formc->bulan != 1) {
            $lastmonth = $formc->bulan - 1;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            // ->orwhere('status','!=', 'Tidak')
            ->count();

            // dd( $form_c_checker);
        } else {
            $lastmonth = $formc->bulan;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
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




        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 3C"],
            ];

            $kembali = route('phd.shuttle-3-listC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Senarai Borang 4C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 4C"],
            ];

            $kembali = route('phd.shuttle-4-listC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 5C"],
            ];

            $kembali = route('phd.shuttle-5-listC', date('Y'));
        }




        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_c_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang C bulan sebelum ini terlebih dahulu.');
        }
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form3c',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain'
            )
        );
    }

    public function shuttle_3_formC_view_phd($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();


        if ($formc->bulan != 1) {
            $lastmonth = $formc->bulan - 1;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            // ->orwhere('status','!=', 'Tidak')
            ->count();

            // dd( $form_c_checker);
        } else {
            $lastmonth = $formc->bulan;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
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




        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 3C"],
            ];

            $kembali = route('phd.shuttle-3-listC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Senarai Borang 4C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 4C"],
            ];

            $kembali = route('phd.shuttle-4-listC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 5C"],
            ];

            $kembali = route('phd.shuttle-5-listC', date('Y'));
        }




        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        // if ($form_a_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        // }
        // if ($form_c_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang C bulan sebelum ini terlebih dahulu.');
        // }
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form3c-phd',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain'
            )
        );
    }


    public function shuttle_4_formC_view($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();

        if ($formc->bulan != 1) {
            $lastmonth = $formc->bulan - 1;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            // ->orwhere('status','!=', 'Tidak')
            ->count();

            // dd( $form_c_checker);
        } else {
            $lastmonth = $formc->bulan;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 3C"],
            ];
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Senarai Borang 4C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 4C"],
            ];
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 5C"],
            ];
        }


        $kembali = route('phd.shuttle-3-listC', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($form_a_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        }
        if ($form_c_checker == 0) {
            return redirect()->back()->with('error', 'Sila sahkan Borang C bulan sebelum ini terlebih dahulu.');
        }
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form4c',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain'
            )
        );
    }

    public function shuttle_4_formC_view_phd($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();

        if ($formc->bulan != 1) {
            $lastmonth = $formc->bulan - 1;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where(function ($query) {
                $query->where('status', 'Dihantar ke IPJPSM')
                      ->orWhere('status', 'Tidak Diisi')->orWhere('status', 'Lulus');
            })
            // ->orwhere('status','!=', 'Tidak')
            ->count();

            // dd( $form_c_checker);
        } else {
            $lastmonth = $formc->bulan;
            $form_c_checker = FormC::where('shuttle_id', $kilang_info->id)
            ->where('bulan', $lastmonth)
            ->whereYear('created_at', date("Y"))
            ->where('status', '!=','Dihantar ke IPJPSM')
            ->count();
        }

        $form_a_checker = FormA::where('tahun', date("Y"))
                ->where('shuttle_id',$kilang_info->id)
                ->where('status', 'Dihantar ke IPJPSM')->orWhere('status', 'Lulus')
                ->count();

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('phd.shuttle-3-listC', date('Y')), 'name' => "Senarai Borang 3C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 3C"],
            ];
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('phd.shuttle-4-listC', date('Y')), 'name' => "Senarai Borang 4C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 4C"],
            ];
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Maklumat"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Pengesahan Borang"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('phd.shuttle-5-listC', date('Y')), 'name' => "Senarai Borang 5C"],
                ['link' => route('phd.shuttle-3-view-formC', date('Y')), 'name' => "Borang 5C"],
            ];
        }


        $kembali = route('phd.shuttle-3-listC', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // if ($form_a_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang A terlebih dahulu.');
        // }
        // if ($form_c_checker == 0) {
        //     return redirect()->back()->with('error', 'Sila sahkan Borang C bulan sebelum ini terlebih dahulu.');
        // }
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form4c-phd',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain'
            )
        );
    }

    public function ibk_shuttle_3_formC_view($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();

        $layout = 'layouts.layout-ibk-nicepage';

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();
        // dd($form_c);

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "BORANG 3C"],
            ];
            $kembali = route('user.shuttle-3-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "BORANG 4C"],
            ];
            $kembali = route('user.shuttle-4-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "BORANG 5C"],
            ];
            $kembali = route('user.shuttle-5-senaraiC', date('Y'));
        }

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        // dd($form_c);
        return view(
            'admins.shuttle-three.view-form3c-ibk',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain',
                'layout'
            )
        );
    }

    public function jpn_shuttle_3_formC_view($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        // $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();

        $layout = 'layouts.layout-jpn-nicepage';

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Senarai Borang 3C"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Borang 3C"],
            ];
            $kembali = route('jpn.shuttle-3-listC-jpn', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Senarai Borang 4C"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Borang 4C"],
            ];
            $kembali = route('jpn.shuttle-4-listC-jpn', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Senarai Borang 5C"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Borang 5C"],
            ];
            $kembali = route('jpn.shuttle-5-listC-jpn', date('Y'));
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form3c-ibk',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain',
                'layout'
            )
        );
    }

    public function ibk_shuttle_4_formC_view($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();

        $layout = 'layouts.layout-ibk-nicepage';

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "BORANG 3C"],
            ];
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "BORANG 4C"],
            ];
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "BORANG 5C"],
            ];
        }


        $kembali = route('user.shuttle-4-senaraiC', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form4c-ibk',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain',
                'layout'
            )
        );
    }

    public function jpn_shuttle_4_formC_view($id)
    {
        $formc = FormC::where('id', $id)->first();
        // $id =$formc->id;
        // dd($id);
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('nama_tempatan')->get();
        // dd($species);
        $kumpulan_kayu = KumpulanKayu::get();

        $kilang_info = Shuttle::where('id', $formc->shuttle_id)->first();

        $layout = 'layouts.layout-jpn-nicepage';

        $form_c = KemasukanBahan::where('formcs_id', $formc->id)->get();

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


        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Senarai Borang 3C"],
                ['link' => route('jpn.shuttle-3-listC-jpn', date('Y')), 'name' => "Borang 3C"],
            ];
            $kembali = route('jpn.shuttle-3-listC-jpn', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Senarai Borang 4C"],
                ['link' => route('jpn.shuttle-4-listC-jpn', date('Y')), 'name' => "Borang 4C"],
            ];
            $kembali = route('jpn.shuttle-4-listC-jpn', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Status Borang"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Senarai Borang 5C"],
                ['link' => route('jpn.shuttle-5-listC-jpn', date('Y')), 'name' => "Borang 5C"],
            ];
            $kembali = route('jpn.shuttle-5-listC-jpn', date('Y'));
        }


        $kembali = route('jpn.shuttle-4-listC-jpn', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        // dd($kemasukan_bahan_calc_lain_lain);
        return view(
            'admins.shuttle-three.view-form4c-ibk',
            compact(
                'returnArr',
                'kilang_info',
                'form_c',
                'id',
                'species',
                'kumpulan_kayu',
                'formc',
                'kemasukan_bahan_calc_kkb',
                'kemasukan_bahan_calc_kkr',
                'kemasukan_bahan_calc_kks',
                'kemasukan_bahan_calc_kayu_lembut',
                'kemasukan_bahan_calc_lain_lain',
                'layout'
            )
        );
    }
}
