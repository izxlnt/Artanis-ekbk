<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\FormC as ModelsFormC;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\RecoveryRate;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Services\FormFlowService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormCKayuKayuLembut extends Component
{
    public $bulan_id, $kayu_id, $max_rate, $min_rate, $sebelumnya = false;
    public $kilang_info, $kumpulan_kayu, $species, $species_count;
    public $baki_stok, $jumlah_baki_stok, $kayu_masuk, $proses_masuk, $proses_keluar, $jumlah_kayu_masuk, $jumlah_stok_kayu_balak, $baki_stok_kehadapan, $jumlah, $total_stok_kayu_balak,
        $total_kayu_masuk_jentera, $total_kayu_keluar_jentera, $total_kayu_dibawa_bulan_hadapan, $jumlah_besar_baki_stok_bulan_lepas, $jumlah_besar_kemasukan_kayu_ke_kilang,
        $jumlah_besar_stok_kayu_balak, $jumlah_besar_kayu_ke_dalam_jentera, $jumlah_besar_pengeluaran_kayu_daripada_jentera, $jumlah_besar_baki_stok_bulan_depan, $bulan;

    protected $listeners = ['sebelumnya' => 'sebelumnyaFunction'];

    public function updated()
    {
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
            $this->jumlah_stok_kayu_balak[$i] = (float)($this->baki_stok[$i] ?? 0) + (float)($this->kayu_masuk[$i] ?? 0);
            $this->validate(['proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i]]);
        }
    }

    public function render()
    {
        $this->kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $breadcrumbs = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-5-formC.KKB', $this->bulan_id), 'name' => "Borang 5C - KKB"],
            ['link' => route('user.shuttle-5-formC.KKS', $this->bulan_id), 'name' => "Borang 5C - KKS"],
            ['link' => route('user.shuttle-5-formC.KKR', $this->bulan_id), 'name' => "Borang 5C - KKR"],
            ['link' => route('user.shuttle-5-formC.KayuLembut', $this->bulan_id), 'name' => "Borang 5C - Kayu Lembut"],
        ];
        $kembali = route('user.shuttle-5-formC.KKR', $this->bulan_id);
        $returnArr = ['breadcrumbs' => $breadcrumbs, 'kembali' => $kembali];
        return view('livewire.shuttle-five.form-c-kayu-kayu-lembut', compact('returnArr'));
    }

    public function mount()
    {
        $this->kayu_id = '4';
        $this->species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $this->kayu_id)->count();
        $this->species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $this->kayu_id)->get();
        $this->kumpulan_kayu = KumpulanKayu::where('id', $this->kayu_id)->get();
        $this->kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = FormFlowService::findFormC(auth()->user()->shuttle_id, date("Y"), $this->bulan_id);

        if ($this->bulan_id != 1) {
            $lastmonth = $this->bulan_id - 1;
            $lastMonthformc = FormFlowService::findFormC(auth()->user()->shuttle_id, date("Y"), $lastmonth);

            if ($lastMonthformc) {
                $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                    ->whereHas('spesis_id', function ($q) { $q->where('kumpulan_kayu_id', $this->kayu_id); })
                    ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->get();
            }
        }

        $kemasukan_bahans = $formc
            ? KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
                $q->where('kumpulan_kayu_id', $this->kayu_id);
            })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get()
            : collect();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($this->species as $key => $value) {
                $baki_stok = 0;
                if (isset($kemasukan_bahans_lastmonth)) {
                    foreach ($kemasukan_bahans_lastmonth as $key2 => $data2) {
                        $baki_stok = $data2->baki_stok_kehadapan;
                        $this->jumlah_besar_baki_stok_bulan_lepas = $data2->jumlah_besar_baki_stok_bulan_depan ?? 0;
                        $this->jumlah_baki_stok[$key] = $data2->total_kayu_dibawa_bulan_hadapan ?? 0;
                        $this->total_stok_kayu_balak[$key] = $data2->total_kayu_dibawa_bulan_hadapan ?? 0;
                        $this->total_kayu_dibawa_bulan_hadapan[$key] = $data2->total_kayu_dibawa_bulan_hadapan ?? 0;
                        if ($key2 == $key) break;
                    }
                }
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
                if (isset($kemasukan_bahans_lastmonth)) {
                    foreach ($kemasukan_bahans_lastmonth as $key2 => $data2) {
                        $baki_stok = $data2->baki_stok_kehadapan;
                        $this->jumlah_besar_baki_stok_bulan_lepas = $data2->jumlah_besar_baki_stok_bulan_depan;
                        $this->jumlah_baki_stok[$key] = $data2->total_kayu_dibawa_bulan_hadapan;
                        if ($key2 == $key) break;
                    }
                }
                $this->baki_stok[$key] = $baki_stok;
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

        if ($this->bulan_id == '1') { $this->bulan = "Januari";
        } else if ($this->bulan_id == '2') { $this->bulan = "Februari";
        } else if ($this->bulan_id == '3') { $this->bulan = "Mac";
        } else if ($this->bulan_id == '4') { $this->bulan = "April";
        } else if ($this->bulan_id == '5') { $this->bulan = "Mei";
        } else if ($this->bulan_id == '6') { $this->bulan = "Jun";
        } else if ($this->bulan_id == '7') { $this->bulan = "Julai";
        } else if ($this->bulan_id == '8') { $this->bulan = "Ogos";
        } else if ($this->bulan_id == '9') { $this->bulan = "September";
        } else if ($this->bulan_id == '10') { $this->bulan = "Oktober";
        } else if ($this->bulan_id == '11') { $this->bulan = "November";
        } else if ($this->bulan_id == '12') { $this->bulan = "Disember"; }
    }

    public function sebelumnyaFunction()
    {
        $this->sebelumnya = true;
        $this->store();
    }

    public function store()
    {
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
            $this->jumlah_stok_kayu_balak[$i] = (float)($this->baki_stok[$i] ?? 0) + (float)($this->kayu_masuk[$i] ?? 0);
            $this->validate(['proses_masuk.' . $i => 'numeric|max:' . $this->jumlah_stok_kayu_balak[$i]]);
        }

        $id = auth()->user();
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();

        if ($this->bulan == 'Januari') { $this->bulan_id = "1";
        } else if ($this->bulan == 'Februari') { $this->bulan_id = "2";
        } else if ($this->bulan == 'Mac') { $this->bulan_id = "3";
        } else if ($this->bulan == 'April') { $this->bulan_id = "4";
        } else if ($this->bulan == 'Mei') { $this->bulan_id = "5";
        } else if ($this->bulan == 'Jun') { $this->bulan_id = "6";
        } else if ($this->bulan == 'Julai') { $this->bulan_id = "7";
        } else if ($this->bulan == 'Ogos') { $this->bulan_id = "8";
        } else if ($this->bulan == 'September') { $this->bulan_id = "9";
        } else if ($this->bulan == 'Oktober') { $this->bulan_id = "10";
        } else if ($this->bulan == 'November') { $this->bulan_id = "11";
        } else if ($this->bulan == 'Disember') { $this->bulan_id = "12"; }

        $user = auth()->user();
        $formc = FormFlowService::findFormC($user->shuttle_id, date("Y"), $this->bulan_id);
        $formc->status = 'Sedang Diisi';
        $formc->tiada_pengeluaran = 0;
        $formc->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', $this->kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($this->species as $keySpecies => $data) {
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
                    'bulan' => $this->bulan_id,
                    'tahun' => date('Y'),
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

        Session::flash('success', 'Maklumat berjaya dimasukkan');

        if ($this->sebelumnya) {
            return redirect()->route('user.shuttle-5-formC.KKR', $this->bulan_id);
        }

        return redirect()->route('user.shuttle-5-formC.LainLain', $this->bulan_id);
    }

    public function calcJumlahKayuMasuk($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $species_key => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $kayu_masuk = $this->kayu_masuk[$species_key] ?? 0;
            } else {
                $kayu_masuk = 0;
            }
            $jumlah += (float)$kayu_masuk;
        }
        $this->jumlah_kayu_masuk[$keyKumpulanKayu] = $jumlah;

        $this->calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahStokKayuBalak($keySpecies);
        $this->calcTotalStokKayuBalak($keyKumpulanKayu, $singkatan);
        $this->calcBakiStok($keySpecies);
        $this->calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcTotalPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    public function calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $baki_stok = $this->baki_stok[$keySpecies] ?? 0;
            } else {
                $baki_stok = 0;
            }
            $jumlah += (float)$baki_stok;
        }
        $this->jumlah_baki_stok[$keyKumpulanKayu] = $jumlah;
    }

    public function calcJumlahStokKayuBalak($keySpecies)
    {
        $baki_stok = $this->baki_stok[$keySpecies] ?? 0;
        $kayu_masuk = $this->kayu_masuk[$keySpecies] ?? 0;
        $this->jumlah_stok_kayu_balak[$keySpecies] = (float)$baki_stok + (float)$kayu_masuk;
    }

    public function calcTotalStokKayuBalak($keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $jumlah_stok_kayu_balak = $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
            } else {
                $jumlah_stok_kayu_balak = 0;
            }
            $jumlah += (float)$jumlah_stok_kayu_balak;
        }
        $this->total_stok_kayu_balak[$keyKumpulanKayu] = $jumlah;
    }

    public function calcBakiStok($keySpecies)
    {
        $jumlah_stok_kayu_balak = $this->jumlah_stok_kayu_balak[$keySpecies];
        $proses_masuk = $this->proses_masuk[$keySpecies];
        (float)$this->baki_stok_kehadapan[$keySpecies] = (float)$jumlah_stok_kayu_balak - (float)$proses_masuk;
    }

    public function calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $proses_masuk = $this->proses_masuk[$keySpecies] ?? 0;
            } else {
                $proses_masuk = 0;
            }
            $jumlah += $proses_masuk;
        }
        $this->total_kayu_masuk_jentera[$keyKumpulanKayu] = $jumlah;
    }

    public function calcTotalPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $proses_keluar = $this->proses_keluar[$keySpecies] ?? 0;
            } else {
                $proses_keluar = 0;
            }
            $jumlah += (float)$proses_keluar;
        }
        $this->total_kayu_keluar_jentera[$keyKumpulanKayu] = $jumlah;
    }

    public function calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $jumlah = 0;
        foreach ($this->species as $keySpecies => $data) {
            if ($data->kumpulan_kayu->singkatan == $singkatan) {
                $baki_stok_kehadapan = $this->baki_stok_kehadapan[$keySpecies] ?? 0;
            } else {
                $baki_stok_kehadapan = 0;
            }
            $jumlah += (float)$baki_stok_kehadapan;
        }
        $this->total_kayu_dibawa_bulan_hadapan[$keyKumpulanKayu] = $jumlah;
    }
}
