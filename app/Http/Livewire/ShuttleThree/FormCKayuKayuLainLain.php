<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Batch;
use App\Models\FormC as ModelsFormC;
use App\Models\Kemasukan;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\RecoveryRate;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormCKayuKayuLainLain extends Component
{
    public $bulan_id, $kayu_id, $max_rate, $min_rate, $sebelumnya = false;
    public $kilang_info, $kumpulan_kayu, $species, $species_count, $kemasukan_bahan_calc_kkb, $kemasukan_bahan_calc_kks, $kemasukan_bahan_calc_kkr, $kemasukan_bahan_calc_kayu_lembut, $kemasukan_bahan_calc_lain_lain;
    public $baki_stok, $jumlah_baki_stok, $kayu_masuk, $proses_masuk, $proses_keluar, $jumlah_kayu_masuk, $jumlah_stok_kayu_balak, $baki_stok_kehadapan, $jumlah, $total_stok_kayu_balak,
        $total_kayu_masuk_jentera, $total_kayu_keluar_jentera, $total_kayu_dibawa_bulan_hadapan, $jumlah_besar_baki_stok_bulan_lepas, $jumlah_besar_kemasukan_kayu_ke_kilang,
        $jumlah_besar_stok_kayu_balak, $jumlah_besar_kayu_ke_dalam_jentera, $jumlah_besar_pengeluaran_kayu_daripada_jentera, $jumlah_besar_baki_stok_bulan_depan, $bulan;

    protected $listeners = ['sebelumnya' => 'sebelumnyaFunction'];

    public function updated()
    {

        $min_recovery_rate = 0;
        $max_recovery_rate = 0;
        $this->min_rate[] = 0;
        $this->max_rate[] = 0;

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        // dd($recovery_rate);
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        for ($i = 0; $i < $this->species_count; $i++) {
            if (!isset($this->jumlah_stok_kayu_balak[$i])) {
                $this->jumlah_stok_kayu_balak[$i] = 0;
                $this->proses_masuk[$i] = 0;
                $this->proses_keluar[$i] = 0;
            }
            $this->min_rate[$i] = ((float)$this->proses_masuk[$i] ?? 0) * $min_recovery_rate;
            $this->max_rate[$i] = ((float)$this->proses_masuk[$i] ?? 0) * $max_recovery_rate;
            // dd($this->min_rate[$i]);
            $this->validate([
                'proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i],
                'proses_keluar.' . $i => 'numeric|min:' . $this->min_rate[$i] . '|max:' . $this->max_rate[$i],
            ]);
            // dd('test');
        }
    }

    public function render()
    {
        $this->kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if($this->kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-formC.KKB', $this->bulan_id), 'name' => "Borang 3C - KKB"],
                ['link' => route('user.shuttle-3-formC.KKS', $this->bulan_id), 'name' => "Borang 3C - KKS"],
                ['link' => route('user.shuttle-3-formC.KKR', $this->bulan_id), 'name' => "Borang 3C - KKR"],
                ['link' => route('user.shuttle-3-formC.KayuLembut', $this->bulan_id), 'name' => "Borang 3C - Kayu Lembut"],
                ['link' => route('user.shuttle-3-formC.LainLain', $this->bulan_id), 'name' => "Borang 3C - Kayu Lain-lain"],
            ];

            $kembali = route('user.shuttle-3-formC.KayuLembut', $this->bulan_id);
        }
        elseif($this->kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-formC.KKB', $this->bulan_id), 'name' => "Borang 4C - KKB"],
                ['link' => route('user.shuttle-3-formC.KKS', $this->bulan_id), 'name' => "Borang 4C - KKS"],
                ['link' => route('user.shuttle-3-formC.KKR', $this->bulan_id), 'name' => "Borang 4C - KKR"],
                ['link' => route('user.shuttle-3-formC.KayuLembut', $this->bulan_id), 'name' => "Borang 4C - Kayu Lembut"],
                ['link' => route('user.shuttle-3-formC.LainLain', $this->bulan_id), 'name' => "Borang 4C - Kayu Lain-lain"],
            ];

            $kembali = route('user.shuttle-3-formC.KayuLembut', $this->bulan_id);
        }
        elseif($this->kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-formC.KKB', $this->bulan_id), 'name' => "Borang 5C - KKB"],
                ['link' => route('user.shuttle-3-formC.KKS', $this->bulan_id), 'name' => "Borang 5C - KKS"],
                ['link' => route('user.shuttle-3-formC.KKR', $this->bulan_id), 'name' => "Borang 5C - KKR"],
                ['link' => route('user.shuttle-3-formC.KayuLembut', $this->bulan_id), 'name' => "Borang 5C - Kayu Lembut"],
                ['link' => route('user.shuttle-3-formC.LainLain', $this->bulan_id), 'name' => "Borang 5C - Kayu Lain-lain"],
            ];

            $kembali = route('user.shuttle-3-formC.KayuLembut', $this->bulan_id);
        }


        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('livewire.shuttle-three.form-c-kayu-kayu-lain-lain', compact('returnArr'));
    }

    public function mount()
    {
        $this->kayu_id = '5';
        $this->species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $this->kayu_id)->count();
        $this->species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $this->kayu_id)->get();
        $this->kumpulan_kayu = KumpulanKayu::where('id', $this->kayu_id)->get();

        // $this->species_count = Spesis::orderBy('kumpulan_kayu_id')->count();
        // $this->species = Spesis::orderBy('kumpulan_kayu_id')->get();
        // $this->kumpulan_kayu = KumpulanKayu::get();

        $this->kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $this->bulan_id)->whereYear('created_at', date("Y"))->first();

        if ($this->bulan_id != 1) {
            $lastmonth = $this->bulan_id - 1;
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $lastmonth)->whereYear('created_at', date("Y"))->first();

            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
                $q->where('kumpulan_kayu_id', $this->kayu_id);
            })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->get();
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', $this->kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        $this->kemasukan_bahan_calc_kkb = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '1');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $this->kemasukan_bahan_calc_kks = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '2');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $this->kemasukan_bahan_calc_kkr = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '3');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $this->kemasukan_bahan_calc_kayu_lembut = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '4');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $this->kemasukan_bahan_calc_lain_lain = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '5');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        // dd($this->kemasukan_bahan_calc_kkb);

        $kkb = $this->kemasukan_bahan_calc_kkb->jumlah_baki_stok ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->jumlah_baki_stok ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->jumlah_baki_stok ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->jumlah_baki_stok ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->jumlah_baki_stok ?? 0;

        $besar_jumlah_baki_stok = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;

        $kkb = $this->kemasukan_bahan_calc_kkb->jumlah_kayu_masuk ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->jumlah_kayu_masuk ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->jumlah_kayu_masuk ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->jumlah_kayu_masuk ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->jumlah_kayu_masuk ?? 0;

        $besar_jumlah_kayu_masuk = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;

        $kkb = $this->kemasukan_bahan_calc_kkb->total_stok_kayu_balak ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_stok_kayu_balak ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_stok_kayu_balak ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_stok_kayu_balak ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_stok_kayu_balak ?? 0;

        $besar_total_stok_kayu_balak = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;

        $kkb = $this->kemasukan_bahan_calc_kkb->total_kayu_masuk_jentera ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_kayu_masuk_jentera ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_kayu_masuk_jentera ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_kayu_masuk_jentera ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_kayu_masuk_jentera ?? 0;

        $besar_total_kayu_masuk_jentera = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;

        $kkb = $this->kemasukan_bahan_calc_kkb->total_kayu_keluar_jentera ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_kayu_keluar_jentera ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_kayu_keluar_jentera ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_kayu_keluar_jentera ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_kayu_keluar_jentera ?? 0;

        $besar_total_kayu_keluar_jentera = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;

        $kkb = $this->kemasukan_bahan_calc_kkb->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_kayu_dibawa_bulan_hadapan ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_kayu_dibawa_bulan_hadapan ?? 0;

        $besar_total_kayu_dibawa_bulan_hadapan = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;

        // foreach ($this->kemasukan_bahan_calc as $key => $data) {
        //     $jumlah_besar_baki_stok_bulan_depan = $data->total_kayu_dibawa_bulan_hadapan ?? 0;
        // }
        if ($kemasukan_bahans->isEmpty()) {
            foreach ($this->species as $key => $value) {
                $baki_stok = 0;
                if (!isset($kemasukan_bahans_lastmonth)) {
                    $baki_stok = 0;
                } else {
                    foreach ($kemasukan_bahans_lastmonth as $key2 => $data2) {
                        // dd($data2);
                        $baki_stok = $data2->baki_stok_kehadapan;
                        $this->jumlah_besar_baki_stok_bulan_lepas = $data2-> jumlah_besar_baki_stok_bulan_depan ?? 0;
                        $this->jumlah_baki_stok[$key] = $data2-> total_kayu_dibawa_bulan_hadapan ?? 0;
                        $this->total_stok_kayu_balak[$key] = $data2-> total_kayu_dibawa_bulan_hadapan ?? 0;
                        $this->total_kayu_dibawa_bulan_hadapan[$key] = $data2-> total_kayu_dibawa_bulan_hadapan ?? 0;
                        if ($key2 == $key)
                            break;
                    }
                }
                // $this->calcJumlahKayuMasuk($key, $key2, $value->singkatan);
                $this->baki_stok[$key] = $baki_stok;
                $this->jumlah_stok_kayu_balak[$key] = $baki_stok;
                $this->kayu_masuk[$key] = 0;
                $this->proses_masuk[$key] = 0;
                $this->proses_keluar[$key] = 0;
                $this->jumlah_kayu_masuk[$key] = 0;
                $this->total_kayu_masuk_jentera[$key] = 0;
                $this->total_kayu_keluar_jentera[$key] = 0;
                $this->baki_stok_kehadapan[$key] = $baki_stok;

                (float)$this->jumlah_besar_baki_stok_bulan_lepas = number_format((float)$besar_jumlah_baki_stok, 2, '.', '');
                (float)$this->jumlah_besar_kemasukan_kayu_ke_kilang = number_format((float)$besar_jumlah_kayu_masuk, 2, '.', '');
                (float)$this->jumlah_besar_stok_kayu_balak = number_format((float)$besar_total_stok_kayu_balak, 2, '.', '');
                (float)$this->jumlah_besar_kayu_ke_dalam_jentera = number_format((float)$besar_total_kayu_masuk_jentera, 2, '.', '');
                (float)$this->jumlah_besar_pengeluaran_kayu_daripada_jentera = number_format((float)$besar_total_kayu_keluar_jentera, 2, '.', '');
                (float)$this->jumlah_besar_baki_stok_bulan_depan = number_format((float)$besar_total_kayu_dibawa_bulan_hadapan, 2, '.', '');
            }
        } else {
            foreach ($kemasukan_bahans as $key => $data) {

                $baki_stok = 0;

                if (!isset($kemasukan_bahans_lastmonth)) {
                    $baki_stok = 0;
                } else {
                    foreach ($kemasukan_bahans_lastmonth as $key2 => $data2) {
                        // dd($data2);
                        $baki_stok = $data2->baki_stok_kehadapan;
                        $this->jumlah_besar_baki_stok_bulan_lepas = $data2->jumlah_besar_baki_stok_bulan_depan;
                        $this->jumlah_baki_stok[$key] = $data2->total_kayu_dibawa_bulan_hadapan;

                        // dd($data2);
                        if ($key2 == $key)
                            break;
                    }
                }

                $this->baki_stok[$key] = $baki_stok;
                $this->kayu_masuk[$key] = $data->kayu_masuk;
                $this->jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $this->proses_masuk[$key] = $data->proses_masuk;
                $this->proses_keluar[$key] = $data->proses_keluar;

                $this->jumlah_baki_stok[$key] = $data->jumlah_baki_stok ?? 0;
                $this->jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $this->total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $this->total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $this->total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $this->total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $this->baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                // (float)$this->jumlah_besar_baki_stok_bulan_lepas = $besar_jumlah_baki_stok;
                // (float)$this->jumlah_besar_kemasukan_kayu_ke_kilang = $besar_jumlah_kayu_masuk;
                // (float)$this->jumlah_besar_stok_kayu_balak = $besar_total_stok_kayu_balak;
                // (float)$this->jumlah_besar_kayu_ke_dalam_jentera = $besar_total_kayu_masuk_jentera;
                // (float)$this->jumlah_besar_pengeluaran_kayu_daripada_jentera = $besar_total_kayu_keluar_jentera;
                // (float)$this->jumlah_besar_baki_stok_bulan_depan = $besar_total_kayu_dibawa_bulan_hadapan;

                (float)$this->jumlah_besar_baki_stok_bulan_lepas = number_format((float)$besar_jumlah_baki_stok, 2, '.', '');
                (float)$this->jumlah_besar_kemasukan_kayu_ke_kilang = number_format((float)$besar_jumlah_kayu_masuk, 2, '.', '');
                (float)$this->jumlah_besar_stok_kayu_balak = number_format((float)$besar_total_stok_kayu_balak, 2, '.', '');
                (float)$this->jumlah_besar_kayu_ke_dalam_jentera = number_format((float)$besar_total_kayu_masuk_jentera, 2, '.', '');
                (float)$this->jumlah_besar_pengeluaran_kayu_daripada_jentera = number_format((float)$besar_total_kayu_keluar_jentera, 2, '.', '');
                (float)$this->jumlah_besar_baki_stok_bulan_depan = number_format((float)$besar_total_kayu_dibawa_bulan_hadapan, 2, '.', '');
            }
        }
        if ($this->bulan_id ==  '1') {
            $this->bulan = "Januari";
        } else if ($this->bulan_id ==  '2') {
            $this->bulan = "Februari";
        } else if ($this->bulan_id ==  '3') {
            $this->bulan = "Mac";
        } else if ($this->bulan_id ==  '4') {
            $this->bulan = "April";
        } else if ($this->bulan_id ==  '5') {
            $this->bulan = "Mei";
        } else if ($this->bulan_id ==  '6') {
            $this->bulan = "Jun";
        } else if ($this->bulan_id ==  '7') {
            $this->bulan = "Julai";
        } else if ($this->bulan_id ==  '8') {
            $this->bulan = "Ogos";
        } else if ($this->bulan_id ==  '9') {
            $this->bulan = "September";
        } else if ($this->bulan_id ==  '10') {
            $this->bulan = "Oktober";
        } else if ($this->bulan_id ==  '11') {
            $this->bulan = "November";
        } else if ($this->bulan_id ==  '12') {
            $this->bulan = "Disember";
        }
    }

    public function sebelumnyaFunction()
    {
        $this->sebelumnya = true;
        // dd($this->sebelumnya);

        $this->store();
    }

    public function tiadaPengeluaran()
    {

        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        // $shuttle_id = Shuttle::first();

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        // dd($kilang_info);
        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();

        if ($this->bulan_id != 1) {
            $lastmonth = $this->bulan_id - 1; //create
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $lastmonth)->whereYear('created_at', date("Y"))->first();

            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) {
                    $q->where('kumpulan_kayu_id', '5');
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->first();
        }

        // dd($kemasukan_bahans_lastmonth);
        if(isset($kemasukan_bahans_lastmonth)){
            $jumlah_besar_baki_stok_bulan_lepas = $kemasukan_bahans_lastmonth->jumlah_besar_baki_stok_bulan_lepas;
            $jumlah_besar_kemasukan_kayu_ke_kilang = $kemasukan_bahans_lastmonth->jumlah_besar_kemasukan_kayu_ke_kilang;
            $jumlah_besar_stok_kayu_balak = $kemasukan_bahans_lastmonth->jumlah_besar_stok_kayu_balak;
            $jumlah_besar_kayu_ke_dalam_jentera = $kemasukan_bahans_lastmonth->jumlah_besar_kayu_ke_dalam_jentera;
            $jumlah_besar_pengeluaran_kayu_daripada_jentera = $kemasukan_bahans_lastmonth->jumlah_besar_pengeluaran_kayu_daripada_jentera;
            $jumlah_besar_baki_stok_bulan_depan = $kemasukan_bahans_lastmonth->jumlah_besar_baki_stok_bulan_depan;
        } else {
            $jumlah_besar_baki_stok_bulan_lepas = 0;
            $jumlah_besar_kemasukan_kayu_ke_kilang = 0;
            $jumlah_besar_stok_kayu_balak = 0;
            $jumlah_besar_kayu_ke_dalam_jentera = 0;
            $jumlah_besar_pengeluaran_kayu_daripada_jentera = 0;
            $jumlah_besar_baki_stok_bulan_depan = 0;
        }

        if ($this->bulan ==  'Januari') {
            $this->bulan_id = "1";
        } else if ($this->bulan ==  'Februari') {
            $this->bulan_id = "2";
        } else if ($this->bulan ==  'Mac') {
            $this->bulan_id = "3";
        } else if ($this->bulan ==  'April') {
            $this->bulan_id = "4";
        } else if ($this->bulan ==  'Mei') {
            $this->bulan_id = "5";
        } else if ($this->bulan ==  'Jun') {
            $this->bulan_id = "6";
        } else if ($this->bulan ==  'Julai') {
            $this->bulan_id = "7";
        } else if ($this->bulan ==  'Ogos') {
            $this->bulan_id = "8";
        } else if ($this->bulan ==  'September') {
            $this->bulan_id = "9";
        } else if ($this->bulan ==  'Oktober') {
            $this->bulan_id = "10";
        } else if ($this->bulan ==  'November') {
            $this->bulan_id = "11";
        } else if ($this->bulan ==  'Disember') {
            $this->bulan_id = "12";
        }


        $user = auth()->user();
        // dd($this->suku_id);

        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $this->bulan_id)->whereYear('created_at', date("Y"))->first();
        $status_terkini = $formc->status;
        $formc->status = 'Tiada Pengeluaran';
        $formc->tiada_pengeluaran = 1;
        // $formc->status = 'Sedang Diisi';
        $formc->save();

        $batch = Batch::where('tahun', $formc->tahun)->where('shuttle_id',$formc->shuttle->id)->where('bulan', $formc->bulan)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_c = 1;
        $batch->save();

        if($status_terkini == 'Sedang Diisi'){
            $kemasukan_bahans = KemasukanBahan::with('spesis_id')
                ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();
            foreach ($kemasukan_bahans as $key => $data) {
                $data->delete();
            }
        }else{
            $kemasukan_bahans = KemasukanBahan::with('spesis_id')
                ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();
        }

        if ($this->bulan_id != 1) {
            $lastmonth = $this->bulan_id - 1; //create
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $lastmonth)->whereYear('created_at', date("Y"))->first();

            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
            ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->get();
        }

        // dd($kemasukan_bahans_lastmonth);

        $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {
                $baki_stok = 0;
                $jumlah_baki_stok = 0;
                if (!isset($kemasukan_bahans_lastmonth)) {
                    $baki_stok = 0;
                    $jumlah_baki_stok = 0;
                } else {
                    foreach ($kemasukan_bahans_lastmonth as $key2 => $data2) {
                        // dd($data2);
                        $baki_stok = $data2->baki_stok_kehadapan;
                        // $jumlah_besar_baki_stok_bulan_lepas = $data2->jumlah_besar_baki_stok_bulan_depan;
                        $jumlah_baki_stok = $data2->total_kayu_dibawa_bulan_hadapan;
                        // dd($data2);
                        if ($key2 == $keySpecies)
                            break;
                    }
                }

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $baki_stok ?? 0,
                    'kayu_masuk' => 0,
                    'jumlah_stok_kayu_balak' => 0,
                    'proses_masuk' => 0,
                    'proses_keluar' => 0,
                    'baki_stok_kehadapan' => $baki_stok ?? 0,

                    'jumlah_baki_stok' => $jumlah_baki_stok,
                    'jumlah_kayu_masuk' => 0,
                    'total_stok_kayu_balak' => 0,
                    'total_kayu_masuk_jentera' =>  0,
                    'total_kayu_keluar_jentera' => 0,
                    'total_kayu_dibawa_bulan_hadapan' =>  0,

                    'jumlah_besar_baki_stok_bulan_lepas' => $jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => now('M'),
                    'tahun' => now('Y'),
                    'formcs_id' => $formc->id,

                ]);
            }
        }

        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where(
            'kategori_pengguna',
            'PHD'
        )->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formc))->delay($delay));
        }

        return redirect()->route('home-user');
    }

    public function store()
    {
        // dd($this->jumlah_besar_kemasukan_kayu_ke_kilang);
        // VALIDATION
        $min_recovery_rate = 0;
        $max_recovery_rate = 0;
        $this->min_rate[] = 0;
        $this->max_rate[] = 0;

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();

        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        for ($i = 0; $i < $this->species_count; $i++) {
            if (!isset($this->jumlah_stok_kayu_balak[$i])) {
                $this->jumlah_stok_kayu_balak[$i] = 0;
                $this->proses_masuk[$i] = 0;
                $this->proses_keluar[$i] = 0;
            }
            $this->min_rate[$i] = ((float)$this->proses_masuk[$i] ?? 0) * $min_recovery_rate;
            $this->max_rate[$i] = ((float)$this->proses_masuk[$i] ?? 0) * $max_recovery_rate;
            // dd($this->min_rate[$i]);
            $this->validate([
                'proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i],
                'proses_keluar.' . $i => 'numeric|min:' . $this->min_rate[$i] . '|max:' . $this->max_rate[$i],
            ]);
        }

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        // dd($recovery_rate);
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        for ($i = 0; $i < $this->species_count; $i++) {
            if (!isset($this->jumlah_stok_kayu_balak[$i])) {
                $this->jumlah_stok_kayu_balak[$i] = 0;
                $this->proses_masuk[$i] = 0;
                $this->proses_keluar[$i] = 0;
            }
            $this->min_rate[$i] = ($this->proses_masuk[$i] ?? 0) * $min_recovery_rate;
            $this->max_rate[$i] = ($this->proses_masuk[$i] ?? 0) * $max_recovery_rate;
            // dd($this->min_rate[$i]);
            $this->validate([
                'proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i],
                'proses_keluar.' . $i => 'numeric|min:' . $this->min_rate[$i] . '|max:' . $this->max_rate[$i],
            ]);
            // dd('test');
        }

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();

        if ($this->bulan ==  'Januari') {
            $this->bulan_id = "1";
        } else if ($this->bulan ==  'Februari') {
            $this->bulan_id = "2";
        } else if ($this->bulan ==  'Mac') {
            $this->bulan_id = "3";
        } else if ($this->bulan ==  'April') {
            $this->bulan_id = "4";
        } else if ($this->bulan ==  'Mei') {
            $this->bulan_id = "5";
        } else if ($this->bulan ==  'Jun') {
            $this->bulan_id = "6";
        } else if ($this->bulan ==  'Julai') {
            $this->bulan_id = "7";
        } else if ($this->bulan ==  'Ogos') {
            $this->bulan_id = "8";
        } else if ($this->bulan ==  'September') {
            $this->bulan_id = "9";
        } else if ($this->bulan ==  'Oktober') {
            $this->bulan_id = "10";
        } else if ($this->bulan ==  'November') {
            $this->bulan_id = "11";
        } else if ($this->bulan ==  'Disember') {
            $this->bulan_id = "12";
        }

        $user = auth()->user();
        // dd($this->suku_id);

        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $formc->status = 'Sedang Diproses';
        // $formc->status = 'Sedang Diisi';
        $formc->tiada_pengeluaran = 0;
        $formc->save();

        $batch = Batch::where('tahun', $formc->tahun)->where('bulan', $formc->bulan)->where('shuttle_id', $formc->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_c = 1;
        $batch->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', $this->kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        // dd($kemasukan_bahans);

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($this->species as $keySpecies => $data) {
                // dd( $this->jumlah_baki_stok);

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $this->baki_stok[$keySpecies] ?? 0,
                    'kayu_masuk' => $this->kayu_masuk[$keySpecies] ?? 0,
                    'jumlah_stok_kayu_balak' => $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0,
                    'proses_masuk' => $this->proses_masuk[$keySpecies] ?? 0,
                    'proses_keluar' => $this->proses_keluar[$keySpecies] ?? 0,
                    'baki_stok_kehadapan' => $this->baki_stok_kehadapan[$keySpecies] ?? 0,


                    'jumlah_baki_stok' => $this->jumlah_baki_stok[$keySpecies] ?? 0,
                    'jumlah_kayu_masuk' => $this->jumlah_kayu_masuk[$keySpecies] ?? 0,
                    'total_stok_kayu_balak' => $this->total_stok_kayu_balak[$keySpecies] ?? 0,
                    'total_kayu_masuk_jentera' => $this->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                    'total_kayu_keluar_jentera' => $this->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                    'total_kayu_dibawa_bulan_hadapan' => $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,


                    'jumlah_besar_baki_stok_bulan_lepas' => $this->jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $this->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $this->jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $this->jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $this->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $this->jumlah_besar_baki_stok_bulan_depan ?? 0,


                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => now('M'),
                    'tahun' => now('Y'),
                    'formcs_id' => $formc->id,
                ]);
            }
        } else {
            foreach ($kemasukan_bahans as $keySpecies => $data) {

                $data->baki_stok = $this->baki_stok[$keySpecies] ?? 0;
                $data->kayu_masuk = $this->kayu_masuk[$keySpecies] ?? 0;
                $data->jumlah_stok_kayu_balak = $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
                $data->proses_masuk = $this->proses_masuk[$keySpecies] ?? 0;
                $data->proses_keluar = $this->proses_keluar[$keySpecies] ?? 0;
                $data->baki_stok_kehadapan = $this->baki_stok_kehadapan[$keySpecies] ?? 0;

                $data->jumlah_baki_stok = $this->jumlah_baki_stok[$keySpecies] ?? 0;
                $data->jumlah_kayu_masuk = $this->jumlah_kayu_masuk[$keySpecies] ?? 0;
                $data->total_stok_kayu_balak = $this->total_stok_kayu_balak[$keySpecies] ?? 0;
                $data->total_kayu_masuk_jentera = $this->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                $data->total_kayu_keluar_jentera = $this->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                $data->total_kayu_dibawa_bulan_hadapan = $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;

                $data->jumlah_besar_baki_stok_bulan_lepas = $this->jumlah_besar_baki_stok_bulan_lepas ?? 0;
                $data->jumlah_besar_kemasukan_kayu_ke_kilang = $this->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0;
                $data->jumlah_besar_stok_kayu_balak = $this->jumlah_besar_stok_kayu_balak ?? 0;
                $data->jumlah_besar_kayu_ke_dalam_jentera = $this->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
                $data->jumlah_besar_pengeluaran_kayu_daripada_jentera = $this->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0;
                $data->jumlah_besar_baki_stok_bulan_depan = $this->jumlah_besar_baki_stok_bulan_depan ?? 0;

                $data->save();
            }
        }

        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        if ($this->sebelumnya) {
            return redirect()->route(
                'user.shuttle-3-formC.KayuLembut',
                $this->bulan_id
            );
        }

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where('kategori_pengguna',
            'PHD'
        )->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formc))->delay($delay));
        }

        return redirect()->route('home-user');
    }

    //FORMULA C
    //jumlah total kemasukan Kayu Balak (03)
    public function calcJumlahKayuMasuk($keySpecies, $keyKumpulanKayu, $singkatan) // (03)
    {
        $jumlah = 0;

        foreach ($this->species as $species_key => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $kayu_masuk =  $this->kayu_masuk[$species_key] ?? 0;
            } else {
                $kayu_masuk = 0;
            }
            $jumlah += (float)$kayu_masuk;
        }
        // dd($jumlah);
        $this->jumlah_kayu_masuk[$keyKumpulanKayu] = $jumlah; // (03, Jumlah)

        $this->calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan); // (02)

        $this->calcJumlahStokKayuBalak($keySpecies); //(04)
        $this->calcTotalStokKayuBalak($keyKumpulanKayu, $singkatan); //(04, Jumlah)

        $this->calcBakiStok($keySpecies); //(07) = (04) - (05)
        $this->calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan); // (05, Jumlah)
        $this->calcTotalPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan); // (06, Jumlah)

        $this->calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan); // (07, Jumlah)

        $this->calcJumlahBesarStokBulanLepas($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarKemasukanKayuKeKilang($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarKayuKeDalamJentera($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarBakiStokBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    //jumlah total baki stok (02)
    public function calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $baki_stok =  $this->baki_stok[$keySpecies] ?? 0;
            } else {
                $baki_stok = 0;
            }
            $jumlah += (float)$baki_stok;
        }
        $this->jumlah_baki_stok[$keyKumpulanKayu] = $jumlah;
    }

    //jumlah Stok Kayu balak = (04)=(02)+(03)
    public function calcJumlahStokKayuBalak($keySpecies)
    {
        $total_kayu = 0;
        // foreach ($this->species as $keySpecies => $data) {
        $baki_stok =  $this->baki_stok[$keySpecies] ?? 0;
        $kayu_masuk = $this->kayu_masuk[$keySpecies] ?? 0;

        $total_kayu = (float)$baki_stok + (float)$kayu_masuk;

        $this->jumlah_stok_kayu_balak[$keySpecies] = $total_kayu;
        // }
    }

    //jumlah total stok Kayu Balak (04)
    public function calcTotalStokKayuBalak($keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $jumlah_stok_kayu_balak =  $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
            } else {
                $jumlah_stok_kayu_balak = 0;
            }
            $jumlah += (float)$jumlah_stok_kayu_balak;
        }
        $this->total_stok_kayu_balak[$keyKumpulanKayu] = $jumlah;
    }

    //jumlah  baki stok dibawa ke bulan hadapan (04)-(05)
    public function calcBakiStok($keySpecies)
    {
        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah_stok_kayu_balak =  $this->jumlah_stok_kayu_balak[$keySpecies];
        $proses_masuk = $this->proses_masuk[$keySpecies];
        // $total_kayu = $jumlah_stok_kayu_balak - $proses_masuk;
        (float)$this->baki_stok_kehadapan[$keySpecies] = (float)$jumlah_stok_kayu_balak - (float)$proses_masuk;
    }

    //jumlah total stok Kayu Balak (05)
    public function calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        //   $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        $jumlah = 0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $proses_masuk =  $this->proses_masuk[$keySpecies] ?? 0;
            } else {
                $proses_masuk = 0;
            }
            $jumlah += $proses_masuk;
        }
        (float)$this->total_kayu_masuk_jentera[$keyKumpulanKayu] = $jumlah;
    }

    //jumlah total stok Kayu Balak (06)
    public function calcTotalPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        //    $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        $jumlah = 0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $proses_keluar =  $this->proses_keluar[$keySpecies] ?? 0;
            } else {
                $proses_keluar = 0;
            }
            $jumlah += (float)$proses_keluar;
        }
        // dd($jumlah);
        (float)$this->total_kayu_keluar_jentera[$keyKumpulanKayu] = $jumlah;
    }

    //jumlah total stok Kayu Balak (07)
    public function calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $baki_stok_kehadapan =  $this->baki_stok_kehadapan[$keySpecies] ?? 0;
            } else {
                $baki_stok_kehadapan = 0;
            }
            $jumlah += (float)$baki_stok_kehadapan;
        }
        // dd($jumlah);
        (float)$this->total_kayu_dibawa_bulan_hadapan[$keyKumpulanKayu] = $jumlah;
    }

    //TOTAL SEMUA SPECIES
    //JUMLAH BESAR STOK BULAN LEPAS
    public function calcJumlahBesarStokBulanLepas($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah =   0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $jumlah_baki_stok =  $this->jumlah_baki_stok[$keySpecies] ?? 0;
            } else {
                $jumlah_baki_stok = 0;
            }
            $jumlah += (float)$jumlah_baki_stok;
        }

        $kkb = $this->kemasukan_bahan_calc_kkb->jumlah_baki_stok ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->jumlah_baki_stok ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->jumlah_baki_stok ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->jumlah_baki_stok ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->jumlah_baki_stok ?? 0;

        (float)$besar_jumlah_baki_stok = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        (float)$jumlah_besar = (float)$besar_jumlah_baki_stok + (float)$jumlah;
        (float)$this->jumlah_besar_baki_stok_bulan_lepas = (float)$jumlah_besar;
    }

    //JUMLAH BESAR KEMASUKAN KAYU BALAK KE DALAM KAWASAN KILANG
    public function calcJumlahBesarKemasukanKayuKeKilang($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah =   0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $jumlah_kayu_masuk =  $this->jumlah_kayu_masuk[$keySpecies] ?? 0;
            } else {
                $jumlah_kayu_masuk = 0;
            }
            $jumlah += (float)$jumlah_kayu_masuk;
        }

        $kkb = $this->kemasukan_bahan_calc_kkb->jumlah_kayu_masuk ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->jumlah_kayu_masuk ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->jumlah_kayu_masuk ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->jumlah_kayu_masuk ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->jumlah_kayu_masuk ?? 0;

        (float)$besar_jumlah_kayu_masuk = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        (float)$jumlah_besar = (float)$besar_jumlah_kayu_masuk + (float)$jumlah;
        (float)$this->jumlah_besar_kemasukan_kayu_ke_kilang = (float)$jumlah_besar;
    }

    //JUMLAH BESAR Stok Kayu
    public function calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah =   0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $total_stok_kayu_balak =  $this->total_stok_kayu_balak[$keySpecies] ?? 0;
            } else {
                $total_stok_kayu_balak = 0;
            }
            $jumlah += (float)$total_stok_kayu_balak;
        }

        $kkb = $this->kemasukan_bahan_calc_kkb->total_stok_kayu_balak ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_stok_kayu_balak ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_stok_kayu_balak ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_stok_kayu_balak ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_stok_kayu_balak ?? 0;

        (float)$besar_total_stok_kayu_balak = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        (float)$jumlah_besar = (float)$besar_total_stok_kayu_balak + (float)$jumlah;
        (float)$this->jumlah_besar_stok_kayu_balak = (float)$jumlah_besar;
    }

    //JUMLAH BESAR KEMASUKAN KAYU BALAK KE DALAM JENTERA MEMPROSES
    public function calcJumlahBesarKayuKeDalamJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah =   0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $total_kayu_masuk_jentera =  $this->total_kayu_masuk_jentera[$keySpecies] ?? 0;
            } else {
                $total_kayu_masuk_jentera = 0;
            }
            $jumlah += (float)$total_kayu_masuk_jentera;
        }

        $kkb = $this->kemasukan_bahan_calc_kkb->total_kayu_masuk_jentera ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_kayu_masuk_jentera ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_kayu_masuk_jentera ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_kayu_masuk_jentera ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_kayu_masuk_jentera ?? 0;

        (float)$besar_total_kayu_masuk_jentera = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        (float)$jumlah_besar = (float)$besar_total_kayu_masuk_jentera + (float)$jumlah;
        (float)$this->jumlah_besar_kayu_ke_dalam_jentera = (float)$jumlah_besar;
    }

    //JUMLAH BESAR PENGELUARAN KAYU GERGAJI DARIPADA JENTERA MEMPROSES
    public function calcJumlahBesarPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah =   0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $total_kayu_keluar_jentera =  $this->total_kayu_keluar_jentera[$keySpecies] ?? 0;
            } else {
                $total_kayu_keluar_jentera = 0;
            }
            $jumlah += (float)$total_kayu_keluar_jentera;
        }

        $kkb = $this->kemasukan_bahan_calc_kkb->total_kayu_keluar_jentera ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_kayu_keluar_jentera ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_kayu_keluar_jentera ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_kayu_keluar_jentera ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_kayu_keluar_jentera ?? 0;

        (float)$besar_total_kayu_keluar_jentera = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        (float)$jumlah_besar = (float)$besar_total_kayu_keluar_jentera + (float)$jumlah;
        (float)$this->jumlah_besar_pengeluaran_kayu_daripada_jentera = (float)$jumlah_besar;
    }

    //JUMLAH BESAR BAKIK STOK DIBAWA KE BULAN HADAPAN
    public function calcJumlahBesarBakiStokBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $total_kayu_dibawa_bulan_hadapan =  $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;
            } else {
                $total_kayu_dibawa_bulan_hadapan = 0;
            }
            $jumlah += (float)$total_kayu_dibawa_bulan_hadapan;
        }

        $kkb = $this->kemasukan_bahan_calc_kkb->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kks = $this->kemasukan_bahan_calc_kks->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kkr = $this->kemasukan_bahan_calc_kkr->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kayu_lembut = $this->kemasukan_bahan_calc_kayu_lembut->total_kayu_dibawa_bulan_hadapan ?? 0;
        $lain_lain = $this->kemasukan_bahan_calc_lain_lain->total_kayu_dibawa_bulan_hadapan ?? 0;

        (float)$besar_total_kayu_dibawa_bulan_hadapan = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        (float)$jumlah_besar = (float)$besar_total_kayu_dibawa_bulan_hadapan + (float)$jumlah;
        (float)$this->jumlah_besar_baki_stok_bulan_depan = (float)$jumlah_besar;

        // dd($this->jumlah_besar_baki_stok_bulan_depan);
    }
}
