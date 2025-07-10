<?php

namespace App\Http\Controllers\ShuttleFive;

use App\Http\Controllers\Controller;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\JenisKayu;
use App\Models\PengeluaranForm5D;
use App\Models\Shuttle;
use App\Models\UlasanIpjpsm;
use App\Models\UlasanPhd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ViewFormController extends Controller
{
    public function shuttle_5_form_view_form5D_ipjpsm($id)
    {
        $jenis_kumai = JenisKayu::get();

        $form5d = Form5D::findorfail($id);


        $kilang_info = Shuttle::where('id', $form5d->shuttle_id)->first();

        // dd($kilang_info);

        // $form5d = Form5D::where('shuttle_id',$kilang_info->id)->first();

        // $id =$form5d->id;

        $ulasan_phd = UlasanPhd::where('form5ds_id', $id)->get();

        $form_5d = PengeluaranForm5D::where('form5ds_id', $form5d->id)->get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listD', date('Y')), 'name' => "Senarai Borang 5D"],
            ['link' => route('ipjpsm.shuttle-5-view-formD', date('Y')), 'name' => "Borang 5D"],
        ];

        if($form5d->status == 'Lulus'){
            $kembali = route('ipjpsm.borang-keseluruhan.shuttle5.borangD', date('Y'));

        }
        else
        $kembali = route('shuttle-5-listD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        // dd($form_5d);
        return view('admins.shuttle-five.view-form5d-ipjpsm', compact('returnArr', 'kilang_info', 'id', 'form5d', 'jenis_kumai', 'form_5d', 'ulasan_phd'));
    }

    public function shuttle_5_form_view_form5E_ipjpsm($id)
    {

        $form5e = Form5E::findorfail($id);
        // dd($form5e);
        $kilang_info = Shuttle::where('id', $form5e->shuttle_id)->first();
        // $form5e = Form5E::where('shuttle_id',$kilang_info->id)->first();
        // $id =$form5d->id;
        $ulasan_phd = UlasanPhd::where('form5es_id', $form5e->id)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Senarai Borang 5E"],
            ['link' => route('ipjpsm.shuttle-5-view-formE', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('shuttle-5-listE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-five.view-form5e-ipjpsm', compact('returnArr', 'kilang_info', 'id', 'form5e', 'ulasan_phd'));
    }

    public function view_form5E_ipjpsm($id)
    {

        $form5e = Form5E::findorfail($id);
        // dd($form5e);
        $kilang_info = Shuttle::where('id', $form5e->shuttle_id)->first();
        // $form5e = Form5E::where('shuttle_id',$kilang_info->id)->first();
        // $id =$form5d->id;
        $ulasan_phd = UlasanPhd::where('form5es_id', $form5e->id)->get();


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Shuttle 5 - Kilang Kayu Kumai"],
            ['link' => route('shuttle-5-listE', date('Y')), 'name' => "Senarai Borang 5E"],
            ['link' => route('ipjpsm.shuttle-5-view-formE', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('bpe.view-form5e-ipjpsm', compact('returnArr', 'kilang_info', 'id', 'form5e', 'ulasan_phd'));
    }

    public function update_status_ipjpsm5D(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $form5D = Form5D::where('id', $id)->first();
        // dd($form5D);
        $form5D->status = $request->status;
        $form5D->save();

        // Session::flash('message', 'Borang Berjaya Diperaku.');



        return redirect()->route('shuttle-5-listD', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }

    public function update_status_ipjpsm5E(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $user = auth()->user();
        $form5E = Form5E::where('id', $id)->first();
        $form5E->status = $request->status;


        $form5E->jumlah_jualan_pasaran_tempatan_cleaning = $request->jumlah_jualan_pasaran_tempatan_cleaning;
        $form5E->jumlah_jualan_eksport_cleaning = $request->jumlah_jualan_eksport_cleaning;

        if(!$request->jumlah_jualan_pasaran_tempatan_cleaning){
            // dd('xmasuk');
            $form5E->jumlah_jualan_pasaran_tempatan_laporan = $form5E->jumlah_jualan_pasaran_tempatan;
            $form5E->save();
        }else{
            $form5E->jumlah_jualan_pasaran_tempatan_laporan = $request->jumlah_jualan_pasaran_tempatan_cleaning;
            $form5E->save();
            // dd($formD);
        }

        if(!$request->jumlah_jualan_eksport_cleaning){
            // dd('xmasuk');
            $form5E->jumlah_jualan_eksport_laporan = $form5E->jumlah_jualan_eksport;
            $form5E->save();
        }else{
            $form5E->jumlah_jualan_eksport_laporan = $request->jumlah_jualan_eksport_cleaning;
            $form5E->save();
            // dd($formD);
        }

        $form5E->save();

        // Session::flash('message', 'Borang Berjaya Diperaku.');

        return redirect()->route('shuttle-5-listE', date('Y'))->with('success', 'Borang Berjaya Diperaku.');
    }
}
