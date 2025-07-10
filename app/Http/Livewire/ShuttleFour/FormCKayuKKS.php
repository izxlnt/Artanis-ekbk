<?php

namespace App\Http\Livewire\ShuttleFour;

use App\Models\Batch;
use App\Models\FormC as ModelsFormC;
use App\Models\Kemasukan;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\RecoveryRate;
use App\Models\Shuttle;
use App\Models\Spesis;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormCKayuKKS extends Component
{
    public $bulan_id, $kayu_id, $max_rate, $min_rate, $sebelumnya = false;
    public $kilang_info, $kumpulan_kayu, $species, $species_count;
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
                // 'proses_keluar.' . $i => 'numeric|min:' . $this->min_rate[$i] . '|max:' . $this->max_rate[$i],
            ]);
            // dd('test');
        }
    }

    public function render()
    {

        // dd($this->bulan_id);
        $this->kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if($this->kilang_info->shuttle_type == '3'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-formC.KKB', $this->bulan_id), 'name' => "Borang 3C - KKB"],
                ['link' => route('user.shuttle-3-formC.KKS', $this->bulan_id), 'name' => "Borang 3C - KKS"],
            ];

            $kembali = route('user.shuttle-3-formC.KKB', $this->bulan_id);
        }
        elseif($this->kilang_info->shuttle_type == '4'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-4-formC.KKB', $this->bulan_id), 'name' => "Borang 4C - KKB"],
                ['link' => route('user.shuttle-4-formC.KKS', $this->bulan_id), 'name' => "Borang 4C - KKS"],
            ];

            $kembali = route('user.shuttle-4-formC.KKB', $this->bulan_id);
        }
        elseif($this->kilang_info->shuttle_type == '5'){
            $breadcrumbs    = [
                ['link' => route('home-phd'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-formC.KKB', $this->bulan_id), 'name' => "Borang 5C - KKB"],
                ['link' => route('user.shuttle-3-formC.KKS', $this->bulan_id), 'name' => "Borang 5C - KKS"],
            ];

            $kembali = route('user.shuttle-3-formC.KKB', $this->bulan_id);
        }



        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('livewire.shuttle-four.form-c-kayu-k-k-s', compact('returnArr'));
    }

    public function mount()
    {
        $this->kayu_id = '2';
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

            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) {
                    $q->where('kumpulan_kayu_id', $this->kayu_id);
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->get();
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', $this->kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();


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
                $this->jumlah_kayu_masuk[$key] = 0;
                $this->total_kayu_masuk_jentera[$key] = 0;
                $this->baki_stok_kehadapan[$key] = $baki_stok;
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
                // dd($baki_stok);
                $this->kayu_masuk[$key] = $data->kayu_masuk;
                $this->jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $this->proses_masuk[$key] = $data->proses_masuk;
                $this->proses_keluar[$key] = $data->proses_keluar;

                $this->jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $this->total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $this->total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $this->total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $this->total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $this->baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                $this->jumlah_besar_kemasukan_kayu_ke_kilang = $data->jumlah_besar_kemasukan_kayu_ke_kilang;
                $this->jumlah_besar_stok_kayu_balak = $data->jumlah_besar_stok_kayu_balak;
                $this->jumlah_besar_kayu_ke_dalam_jentera = $data->jumlah_besar_kayu_ke_dalam_jentera;
                $this->jumlah_besar_pengeluaran_kayu_daripada_jentera = $data->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $this->jumlah_besar_baki_stok_bulan_depan = $data->jumlah_besar_baki_stok_bulan_depan;
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

    public function store()
    {
        // dd('s');
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        // $shuttle_id = Shuttle::first();

        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
                // 'proses_keluar.' . $i => 'numeric|min:' . $this->min_rate[$i] . '|max:' . $this->max_rate[$i],
            ]);
            // dd('test');
        }

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
        // dd($kilang_info);

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();
        // dd($shuttle_id);
        // $formcs = ModelsFormC::create([
        //     'shuttle_id'=>$shuttle_id->id,
        //     'shuttle_type'=>$shuttle_id->shuttle_type,
        //     'status' => $status,
        //     'tahun' => $kilang_info->tahun,
        //     'bulan' => $this->bulan,
        //     'nama_kilang' => $kilang_info->nama_kilang,
        //     'no_ssm' => $kilang_info->no_ssm,
        //     'no_lesen' => $kilang_info->no_lesen,
        // ]);

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

        // $formc->status = 'Sedang Diproses';
        $formc->status = 'Sedang Diisi';
        $formc->save();

        // $batch = Batch::where('tahun', $formc->tahun)->where('bulan', $formc->bulan)->first();

        // // $batch->status = "Sedang Diproses";
        // $batch->status = "Sedang Diisi";
        // $batch->borang_c = 1;
        // $batch->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', $this->kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        // dd($kemasukan_bahans);

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($this->species as $keySpecies => $data) {
                // dd( $this->jumlah_baki_stok);
                if ($this->jumlah_besar_kemasukan_kayu_ke_kilang == 0) {
                    if ($this->jumlah_kayu_masuk == null) {
                        $this->jumlah_kayu_masuk[$keySpecies] = 0;
                    }
                    $this->jumlah_besar_kemasukan_kayu_ke_kilang += (float)$this->jumlah_kayu_masuk ?? 0;
                } else {
                    $this->jumlah_besar_kemasukan_kayu_ke_kilang = 0;

                    $kemasukan_bahan_semua = KemasukanBahan::with('spesis_id')
                        ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();
                    foreach ($kemasukan_bahan_semua as $kemasukan_bahan_semua_key => $kemasukan_bahan_semua_data) {
                        $this->jumlah_besar_kemasukan_kayu_ke_kilang += (float)$kemasukan_bahan_semua_data->jumlah_kayu_masuk ?? 0;
                    }
                }

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
                // dd($data);
                if ($this->jumlah_besar_kemasukan_kayu_ke_kilang == 0) {
                    if ($this->jumlah_kayu_masuk == null) {
                        $this->jumlah_kayu_masuk[$keySpecies] = 0;
                    }
                    $this->jumlah_besar_kemasukan_kayu_ke_kilang += (float)$this->jumlah_kayu_masuk ?? 0;
                } else {
                    $this->jumlah_besar_kemasukan_kayu_ke_kilang = 0;

                    $kemasukan_bahan_semua = KemasukanBahan::with('spesis_id')
                        ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();
                    foreach ($kemasukan_bahan_semua as $kemasukan_bahan_semua_key => $kemasukan_bahan_semua_data) {
                        $this->jumlah_besar_kemasukan_kayu_ke_kilang += (float)$kemasukan_bahan_semua_data->jumlah_kayu_masuk ?? 0;
                    }
                }

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
        // Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
        Session::flash('success', 'Maklumat berjaya dimasukkan');

        if($this->sebelumnya){
            return redirect()->route('user.shuttle-4-formC.KKB', $this->bulan_id);
        }

        return redirect()->route('user.shuttle-4-formC.KKR', $this->bulan_id);
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
        // dd($jumlah);
        $this->total_kayu_masuk_jentera[$keyKumpulanKayu] = $jumlah;
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
        $this->total_kayu_keluar_jentera[$keyKumpulanKayu] = $jumlah;
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
        $this->total_kayu_dibawa_bulan_hadapan[$keyKumpulanKayu] = $jumlah;
    }

    //TOTAL SEMUA SPECIES
    //JUMLAH BESAR STOK BULAN LEPAS
    public function calcJumlahBesarStokBulanLepas($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah =   0;

        foreach ($this->species as $keyKumpulanKayu => $data) {

            foreach ($this->species as $keySpecies => $data2) {

                if ($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu) {
                    $jumlah_besar_stok_kayu_balak = $this->jumlah_baki_stok[$keySpecies] ?? 0;
                    $jumlah += (float)$jumlah_besar_stok_kayu_balak;
                } else {
                    $jumlah_besar_stok_kayu_balak = 0;
                }
            }
        }
        $this->jumlah_besar_baki_stok_bulan_lepas = $jumlah;
    }

    //JUMLAH BESAR KEMASUKAN KAYU BALAK KE DALAM KAWASAN KILANG
    public function calcJumlahBesarKemasukanKayuKeKilang($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah =   0;

        foreach ($this->species as $keyKumpulanKayu => $data) {

            foreach ($this->species as $keySpecies => $data2) {

                if ($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu) {
                    $jumlah_besar_kemasukan_kayu_ke_kilang = $this->jumlah_kayu_masuk[$keySpecies] ?? 0;
                    $jumlah += (float)$jumlah_besar_kemasukan_kayu_ke_kilang;
                } else {
                    $jumlah_besar_kemasukan_kayu_ke_kilang = 0;
                }
            }
        }
        $this->jumlah_besar_kemasukan_kayu_ke_kilang = $jumlah;
    }

    //JUMLAH BESAR Stok Kayu
    public function calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah =   0;

        foreach ($this->species as $keyKumpulanKayu => $data) {

            foreach ($this->species as $keySpecies => $data2) {

                if ($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu) {
                    $jumlah_besar_stok_kayu_balak = $this->total_stok_kayu_balak[$keySpecies] ?? 0;
                    $jumlah += (float)$jumlah_besar_stok_kayu_balak;
                } else {
                    $jumlah_besar_stok_kayu_balak = 0;
                }
            }
        }
        $this->jumlah_besar_stok_kayu_balak = $jumlah;
    }

    //JUMLAH BESAR KEMASUKAN KAYU BALAK KE DALAM JENTERA MEMPROSES
    public function calcJumlahBesarKayuKeDalamJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        //  $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah =   0;

        foreach ($this->species as $keyKumpulanKayu => $data) {

            foreach ($this->species as $keySpecies => $data2) {

                if ($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu) {
                    $jumlah_besar_kayu_ke_dalam_jentera = $this->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                    $jumlah += (float)$jumlah_besar_kayu_ke_dalam_jentera;
                } else {
                    $jumlah_besar_kayu_ke_dalam_jentera = 0;
                }
            }
        }
        $this->jumlah_besar_kayu_ke_dalam_jentera = $jumlah;
    }

    //JUMLAH BESAR PENGELUARAN KAYU GERGAJI DARIPADA JENTERA MEMPROSES
    public function calcJumlahBesarPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        //  $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah =   0;

        foreach ($this->species as $keyKumpulanKayu => $data) {

            foreach ($this->species as $keySpecies => $data2) {

                if ($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu) {
                    $jumlah_besar_pengeluaran_kayu_daripada_jentera = $this->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                    $jumlah += (float)$jumlah_besar_pengeluaran_kayu_daripada_jentera;
                } else {
                    $jumlah_besar_pengeluaran_kayu_daripada_jentera = 0;
                }
            }
        }
        $this->jumlah_besar_pengeluaran_kayu_daripada_jentera = $jumlah;
    }

    //JUMLAH BESAR BAKIK STOK DIBAWA KE BULAN HADAPAN
    public function calcJumlahBesarBakiStokBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        //   $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $jumlah =   0;

        foreach ($this->species as $keyKumpulanKayu => $data) {

            foreach ($this->species as $keySpecies => $data2) {

                if ($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu) {
                    $jumlah_besar_baki_stok_bulan_depan = $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;
                    $jumlah += (float)$jumlah_besar_baki_stok_bulan_depan;
                } else {
                    $jumlah_besar_baki_stok_bulan_depan = 0;
                }
            }
        }
        $this->jumlah_besar_baki_stok_bulan_depan = $jumlah;
    }
}
