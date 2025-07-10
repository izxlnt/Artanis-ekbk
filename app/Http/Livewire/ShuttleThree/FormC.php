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
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormC extends Component
{
    public $bulan_id;
    public $kilang_info , $kumpulan_kayu, $species;
    public $baki_stok, $jumlah_baki_stok, $kayu_masuk, $proses_masuk, $proses_keluar, $jumlah_kayu_masuk, $jumlah_stok_kayu_balak, $baki_stok_kehadapan, $jumlah, $total_stok_kayu_balak,
        $total_kayu_masuk_jentera, $total_kayu_keluar_jentera, $total_kayu_dibawa_bulan_hadapan, $jumlah_besar_baki_stok_bulan_lepas, $jumlah_besar_kemasukan_kayu_ke_kilang,
        $jumlah_besar_stok_kayu_balak, $jumlah_besar_kayu_ke_dalam_jentera, $jumlah_besar_pengeluaran_kayu_daripada_jentera, $jumlah_besar_baki_stok_bulan_depan, $bulan,
        $species_count;

    public function updated()
    {

        $min_recovery_rate = 0;
        $max_recovery_rate = 0;

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        // dd($recovery_rate);
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        // if ($shuttle_type == '3') {
        //     $min_recovery_rate = '0.65';
        //     $max_recovery_rate = '0.85';
        // } else if ($shuttle_type == '4') {
        //     $min_recovery_rate = '0.50';
        //     $max_recovery_rate = '0.80';
        // } else if ($shuttle_type == '5') {
        //     $min_recovery_rate = '0.80';
        //     $max_recovery_rate = '0.95';
        // }

        for ($i = 0; $i < $this->species_count; $i++) {
            if (!isset($this->jumlah_stok_kayu_balak[$i])) {
                $this->jumlah_stok_kayu_balak[$i] = 0;
                $this->proses_masuk[$i] = 0;
                $this->proses_keluar[$i] = 0;
            }

            $min_rate = $this->proses_masuk[$i] * $min_recovery_rate;
            $max_rate = $this->proses_masuk[$i] * $max_recovery_rate;
            // dd($max_rate);
            $this->validate([
                'proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i],
                'proses_keluar.' . $i => 'numeric|min:' . $min_rate . '|max:' . $max_rate,
            ]);
            // dd('test');
        }

    }

    public function render()
    {
        return view('livewire.shuttle-three.form-c');
    }

    public function mount()
    {
        # code...
        // $kayu_id = '1';
        // dd($kayu_id);
        // $this->species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->count();
        $this->species_count = Spesis::orderBy('kumpulan_kayu_id')->count();

        for ($i = 0; $i < $this->species_count; $i++) {
            $this->baki_stok[$i] = 0;
            $this->kayu_masuk[$i] = 0;
            $this->jumlah_stok_kayu_balak[$i] = 0;
            $this->proses_masuk[$i] = 0;
            $this->proses_keluar[$i] = 0;
            $this->baki_stok_kehadapan[$i] = 0;
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

        $id = auth()->user();
        // $kayu_id = '1';

        // $this->species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();
        $this->species = Spesis::orderBy('kumpulan_kayu_id')->get();

        // $this->kumpulan_kayu = KumpulanKayu::where('id', $kayu_id)->get();
        $this->kumpulan_kayu = KumpulanKayu::get();
        $this->kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
    }

    public function store()
    {
        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        // $shuttle_id = Shuttle::first();

        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        for ($i = 0; $i < $this->species_count; $i++) {
            if (!isset($this->jumlah_stok_kayu_balak[$i])) {
                $this->jumlah_stok_kayu_balak[$i] = 0;
                $this->proses_masuk[$i] = 0;
                $this->proses_keluar[$i] = 0;
            }
            $this->validate([
                'proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i],
                'proses_keluar.' . $i => 'numeric|max:' . $this->proses_masuk[$i],
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

        $formc->status = 'Sedang Diproses';
        $formc->save();

        $batch = Batch::where('tahun', $formc->tahun)->where('bulan', $formc->bulan)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_c = 1;
        $batch->save();


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
        // Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
        Session::flash('success', 'Maklumat berjaya dimasukkan');

        return redirect()->route('home-user');
    }


    public function tiadaPengeluaran()
    {

        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        // $shuttle_id = Shuttle::first();

        $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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

        $formc->status = 'Tiada Pengeluaran';
        $formc->save();

        $batch = Batch::where('tahun', $formc->tahun)->where('bulan', $formc->bulan)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_c = 1;
        $batch->save();


        // foreach ($this->species as $keySpecies => $data) {
        foreach ($species as $keySpecies => $data) {
            // dd($species);
            // dd( $this->jumlah_baki_stok);
            KemasukanBahan::create([
                'spesis_id' => $data->id,
                'baki_stok' => 0,
                'kayu_masuk' => 0,
                'jumlah_stok_kayu_balak' => 0,
                'proses_masuk' => 0,
                'proses_keluar' => 0,
                'baki_stok_kehadapan' => 0,

                'jumlah_baki_stok' => 0,
                'jumlah_kayu_masuk' => 0,
                'total_stok_kayu_balak' => 0,
                'total_kayu_masuk_jentera' =>  0,
                'total_kayu_keluar_jentera' => 0,
                'total_kayu_dibawa_bulan_hadapan' =>  0,

                'jumlah_besar_baki_stok_bulan_lepas' => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => 0,
                'jumlah_besar_stok_kayu_balak' => 0,
                'jumlah_besar_kayu_ke_dalam_jentera' => 0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan' => 0,

                'shuttle_id' => $shuttle_id->id,
                'kategori_guna_tenaga_id' => $data->id,
                'bulan' => now('M'),
                'tahun' => now('Y'),
                'formcs_id' => $formc->id,
            ]);
        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }

    //jumlah total baki stok (02)
    public function calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)

    {
        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        $jumlah = 0;

        // dd($jumlah);
        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $baki_stok =  $this->baki_stok[$keySpecies] ?? 0;
            } else {
                $baki_stok = 0;
            }
            $jumlah += (float)$baki_stok;
        }
        // dd($jumlah);
        $this->jumlah_baki_stok[$keyKumpulanKayu] = $jumlah;

        $this->calcJumlahStokKayuBalak($keySpecies);
        $this->calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokBulanLepas($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    //jumlah total kemasukan Kayu Balak (03)
    public function calcJumlahKayuMasuk($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        $jumlah = 0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $kayu_masuk =  $this->kayu_masuk[$keySpecies] ?? 0;
            } else {
                $kayu_masuk = 0;
            }
            $jumlah += $kayu_masuk;
        }
        // dd($jumlah);
        $this->jumlah_kayu_masuk[$keyKumpulanKayu] = $jumlah;
        $this->calcJumlahStokKayuBalak($keySpecies);
        $this->calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarKemasukanKayuKeKilang($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    //jumlah total stok Kayu Balak (04)
    public function calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        //  $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        $jumlah = 0;

        foreach ($this->species as $keySpecies => $data) {
            // dd($data->kumpulan_kayu->singkatan);
            if ($data->kumpulan_kayu->singkatan == $singkatan) {

                $jumlah_stok_kayu_balak =  $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
            } else {
                $jumlah_stok_kayu_balak = 0;
            }
            $jumlah += $jumlah_stok_kayu_balak;
        }
        // dd($jumlah);
        $this->total_stok_kayu_balak[$keyKumpulanKayu] = $jumlah;

        // $this->calcBakiStok($keySpecies, $keyKumpulanKayu, $singkatan);
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
        $this->calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarKayuKeDalamJentera($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarBakiStokBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);
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
        $this->calcJumlahBesarPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    //jumlah total stok Kayu Balak (07)
    public function calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        // dd('e');
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

    //jumlah Stok Kayu balak = (04)=(02)+(03)
    public function calcJumlahStokKayuBalak($keySpecies)
    {
        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        if (empty($this->baki_stok[$keySpecies])) {
            $this->baki_stok[$keySpecies] = 0;
        }
        if (empty($this->kayu_masuk[$keySpecies])) {
            $this->kayu_masuk[$keySpecies] = 0;
        }

        // $this->jumlah_stok_kayu_balak=0;
        // $baki_stok= 0;
        // $kayu_masuk = 0;
        $total_kayu = 0;
        foreach ($this->species as $keySpecies => $data) {
            $baki_stok =  $this->baki_stok[$keySpecies] ?? 0;
            $kayu_masuk = $this->kayu_masuk[$keySpecies] ?? 0;

            $total_kayu = (float)$baki_stok + (float)$kayu_masuk;

            $this->jumlah_stok_kayu_balak[$keySpecies] = $total_kayu;
        }

        // $this->calcBakiStok($key);

    }

    //jumlah  baki stok dibawa ke bulan hadapan (04)-(05)
    public function calcBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        // $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        if (empty($this->jumlah_stok_kayu_balak[$keySpecies])) {
            $this->jumlah_stok_kayu_balak[$keySpecies] = 0;
        }
        if (empty($this->proses_masuk[$keySpecies])) {
            $this->proses_masuk[$keySpecies] = 0;
        }

        $jumlah_stok_kayu_balak =  $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
        $proses_masuk = $this->proses_masuk[$keySpecies] ?? 0;

        // $total_kayu = $jumlah_stok_kayu_balak - $proses_masuk;
        $this->baki_stok_kehadapan[$keySpecies] = (float)$jumlah_stok_kayu_balak - (float)$proses_masuk;

        // $this->baki_stok_kehadapan [$key] = $total_kayu;
        // $this->calcJumlahKayuMasuk($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);

        $this->calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan);
    }

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
