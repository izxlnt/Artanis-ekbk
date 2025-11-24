<?php

namespace App\Http\Controllers\ShuttleFour;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Form4D;
use App\Models\ProdukPengeluaran;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListDController extends Controller
{
    public $shuttle_listD;

    public function shuttle_4_listD($year)
    {
        $user = auth()->user();
        // $shuttle_listC = Shuttle::where('shuttle_type', '3')->paginate(10);
        $form4D_kilang = Form4D::select('shuttle_id')
            ->whereHas('shuttle', function ($q) {
                $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
            })
            ->distinct()->where('tahun', $year)->get();

        $form4D = Form4D::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })->where('tahun', $year)->get();

        $year_list = Form4D::whereHas('shuttle', function ($q) {
            $q->where('daerah_id', auth()->user()->daerah)->where('shuttle_type', '4');
        })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '4')->first();


        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Senarai Borang 4D"],

        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listD-phd', compact('form4D', 'user', 'year_list', 'year', 'buffer', 'form4D_kilang', 'returnArr'));
    }

    public function ibk_shuttle_4_form4D_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $kilang_info = Shuttle::where('id', $id)->first();
        // dd($kilang_info);
        $form4d = Form4D::where('id', $id)->first();
        $id = $form4d->id;

        // dd($form4d);
        $nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<=', '11.99')->get();
        $tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12.00')->get();

        $jumlah_kecil_nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<', '12')->first();
        $jumlah_kecil_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12')->first();

        // dd($tebal);



        // dd($tebal);

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "BORANG 4D"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-four.view-form4d-ibk', compact('returnArr', 'kilang_info', 'nipis', 'tebal', 'id', 'form4d', 'tebal', 'jumlah_kecil_nipis', 'jumlah_kecil_tebal'));
    }

    public function jpn_shuttle_4_form4D_view($id)
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $kilang_info = Shuttle::where('id', $id)->first();
        // dd($kilang_info);
        $form4d = Form4D::where('id', $id)->first();
        $id = $form4d->id;

        $nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<=', '11.99')->get();
        $tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12.00')->get();

        $jumlah_kecil_nipis = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '<', '12')->first();
        $jumlah_kecil_tebal = ProdukPengeluaran::where('form4ds_id', $form4d->id)->where('produk_ketebalan', '>=', '12')->first();


        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Senarai Borang 4D"],
            ['link' => route('phd.shuttle-4-listD', date('Y')), 'name' => "Borang 4D"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('admins.shuttle-four.view-form4d-jpn', compact('returnArr', 'kilang_info', 'nipis', 'tebal', 'id', 'form4d', 'tebal', 'jumlah_kecil_nipis', 'jumlah_kecil_tebal'));
    }

    public function shuttle_4_listD_ipjpsm($year)
    {
        $user = auth()->user();
        // dd($user );

        // $formD_kilang = FormD::select('shuttle_id')
        // ->whereHas('shuttle', function ($q) {
        //     $q->where('shuttle_type', '3');
        // })
        // ->distinct()->where('tahun', $year)->get();

        $form4D_kilang = DB::select(DB::raw("SELECT DISTINCT shuttles.* FROM form4_d_s
        INNER JOIN shuttles ON form4_d_s.shuttle_id = shuttles.id
        INNER JOIN batches ON shuttles.id = batches.shuttle_id
        WHERE batches.tahun = form4_d_s.tahun
        AND (form4_d_s.status = 'Dihantar ke IPJPSM' OR form4_d_s.status = 'Lulus')
        AND batches.shuttle_id = form4_d_s.shuttle_id
        AND batches.status = 'Dihantar ke IPJPSM'
        AND shuttles.shuttle_type = '4'
        AND form4_d_s.tahun = $year"));
        // $formD = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->where('tahun', $year)->get();
        // $formD = DB::select(DB::raw('SELECT form4_d_s.* FROM batches, form4_d_s WHERE batches.tahun = form4_d_s.tahun AND batches.bulan = form4_d_s.bulan AND batches.shuttle_id = form4_d_s.shuttle_id AND batches.status = "Dihantar ke IPJPSM"'));
        $form4D = Form4D::where('tahun', $year)->where('shuttle_type', '4')->get();

        // dd($formD);

        $year_list = DB::select(DB::raw("SELECT DISTINCT form4_d_s.tahun FROM form4_d_s
            INNER JOIN shuttles ON form4_d_s.shuttle_id = shuttles.id
            INNER JOIN batches ON shuttles.id = batches.shuttle_id
            WHERE batches.tahun = form4_d_s.tahun
            AND (form4_d_s.status = 'Dihantar ke IPJPSM' OR form4_d_s.status = 'Lulus')
            AND batches.shuttle_id = form4_d_s.shuttle_id
            AND batches.status = 'Dihantar ke IPJPSM'
            AND shuttles.shuttle_type = '4'"));

        //  $year_list = FormD::whereHas('shuttle', function($q){
        //     $q->where('shuttle_type', '3');
        //  })->distinct()->orderBy('tahun')->get('tahun');

        $buffer = Buffer::where('borang', 'd')->where('shuttle', '4')->first();
        $batch = Batch::get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Perakuan Maklumat"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('shuttle-4-listD', date('Y')), 'name' => "Senarai Borang 4D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listD-ipjpsm', compact('returnArr', 'form4D', 'user', 'year_list', 'year', 'buffer', 'form4D_kilang', 'batch'));
    }

    public function shuttle_4_listD_jpn($year)
    {
        $user = auth()->user();

        $formD_kilang = Form4D::select('shuttle_id')->whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        })->distinct()->where('tahun', $year)->get();

        $formD = Form4D::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '4');
        })->get();

        // dd($formD[10]->shuttle->id);

        $year_list = Form4D::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->distinct()->orderBy('tahun')->get('tahun');
        $buffer = Buffer::where('borang', 'd')->where('shuttle', '4')->first();


        $breadcrumbs    = [
            ['link' => route('home-jpn'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Shuttle 4 - Kilang Papan Lapis/Venir"],
            ['link' => route('jpn.shuttle-4-listD-jpn', date('Y')), 'name' => "Borang 4D"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-four.shuttle-4-listD-jpn', compact('returnArr', 'formD', 'user', 'year_list', 'year', 'buffer', 'formD_kilang'));
    }
}
