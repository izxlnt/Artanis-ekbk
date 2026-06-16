<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\Batch;
use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use App\Models\Shuttle;
use App\Models\FormB as FormBBaru;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormB extends Component
{
    public $suku_id;
    public $year;

    public $pekerja_wargabumi_lelaki, $pekerja_wargabumi_perempuan, $pekerja_bukan_wargabumi_lelaki, $pekerja_bukan_wargabumi_perempuan, $pekerja_asing_lelaki, $pekerja_asing_perempuan,
        $jumlah_lelaki, $jumlah_perempuan, $jumlah_pekerja, $gaji_lelaki, $gaji_perempuan, $total_gaji_lelaki, $total_gaji_perempuan, $total_gaji,
        $total_bumi_lelaki, $total_bumi_perempuan, $total_bukanbumi_lelaki, $total_bukanbumi_perempuan, $total_asing_lelaki, $total_asing_perempuan,
        $total_pekerja_lelaki, $total_pekerja_perempuan, $total_pekerja, $jumlah_gaji_lelaki, $jumlah_gaji_perempuan, $jumlah_total_lelaki,
        $gaji_lelaki_perempuan, $perempuan, $lelaki, $jumlah_total_perempuan, $jumlah_total_gaji, $jumlah_lelaki_perempuan, $suku,
        $max_gaji, $min_gaji;

        public function updated($name, $value)
        {
            if ( $value == '' ) data_set($this, $name, null);
        }

    public function render()
    {

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiB', $this->year), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-5-senaraiB', $this->year), 'name' => "Borang 5B"],
        ];


        $kembali = route('user.shuttle-5-senaraiB', $this->year);

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($this->suku_id ==  '1') {
            $this->suku = "Pertama (Mac)";
        } else if ($this->suku_id ==  '2') {
            $this->suku = "Kedua (Jun)";
        } else if ($this->suku_id ==  '3') {
            $this->suku = "Ketiga (September)";
        } else if ($this->suku_id ==  '4') {
            $this->suku = "Keempat (Disember)";
        }


        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
        $kategori_pekerja = KategoriGunaTenaga::get();
        return view('livewire.shuttle-five.form-b', compact('kategori_pekerja', 'kilang_info','returnArr'));
    }

    public function mount($year = null)
    {
        if ($year) {
            $this->year = $year;
        } elseif (!$this->year) {
            $this->year = date('Y');
        }

        $kategori_pekerja = KategoriGunaTenaga::get();
        foreach ($kategori_pekerja as $key => $value) {
            $this->jumlah_lelaki[$key] = 0;
            $this->jumlah_perempuan[$key] = 0;
            $this->jumlah_pekerja[$key] = 0;
            $this->gaji_lelaki_perempuan[$key] = 0;
            $this->total_gaji_lelaki[$key] = 0;
            $this->total_gaji_perempuan[$key] = 0;
            $this->total_gaji[$key] = 0;
        }

        $this->total_bumi_lelaki = 0;
        $this->total_bumi_perempuan = 0;
        $this->total_bukanbumi_lelaki = 0;
        $this->total_bukanbumi_perempuan = 0;
        $this->total_asing_lelaki = 0;
        $this->total_asing_perempuan = 0;
        $this->total_pekerja_lelaki = 0;
        $this->total_pekerja_perempuan = 0;
        $this->total_pekerja = 0;
        $this->jumlah_gaji_lelaki = 0;
        $this->jumlah_gaji_perempuan = 0;
        $this->jumlah_lelaki_perempuan  = 0;
        $this->jumlah_total_lelaki  = 0;
        $this->jumlah_total_perempuan  = 0;
        $this->jumlah_total_gaji  = 0;

        $formb = FormBBaru::where('shuttle_id', auth()->user()->shuttle_id)
            ->where('suku_tahun', $this->suku_id)
            ->where('tahun', $this->year)
            ->where('status', 'Tidak Lengkap')
            ->first();

        if ($formb) {
            $existing = GunaTenaga::where('formbs_id', $formb->id)
                ->orderBy('id', 'desc')
                ->get()
                ->unique('kategori_guna_tenaga_id')
                ->values();

            foreach ($existing as $key => $row) {
                $this->pekerja_wargabumi_lelaki[$key] = $row->pekerja_wargabumi_lelaki;
                $this->pekerja_wargabumi_perempuan[$key] = $row->pekerja_wargabumi_perempuan;
                $this->pekerja_bukan_wargabumi_lelaki[$key] = $row->pekerja_bukan_wargabumi_lelaki;
                $this->pekerja_bukan_wargabumi_perempuan[$key] = $row->pekerja_bukan_wargabumi_perempuan;
                $this->pekerja_asing_lelaki[$key] = $row->pekerja_asing_lelaki;
                $this->pekerja_asing_perempuan[$key] = $row->pekerja_asing_perempuan;
                $this->jumlah_lelaki[$key] = $row->jumlah_lelaki;
                $this->jumlah_perempuan[$key] = $row->jumlah_perempuan;
                $this->jumlah_pekerja[$key] = $row->jumlah_pekerja;
                $this->gaji_lelaki[$key] = $row->gaji_lelaki;
                $this->gaji_perempuan[$key] = $row->gaji_perempuan;
                $this->gaji_lelaki_perempuan[$key] = $row->gaji_lelaki_perempuan;
                $this->total_gaji_lelaki[$key] = $row->total_gaji_lelaki;
                $this->total_gaji_perempuan[$key] = $row->total_gaji_perempuan;
                $this->total_gaji[$key] = $row->total_gaji;
            }

            foreach ($kategori_pekerja as $key => $value) {
                $this->total_bumi_lelaki += (int)($this->pekerja_wargabumi_lelaki[$key] ?? 0);
                $this->total_bumi_perempuan += (int)($this->pekerja_wargabumi_perempuan[$key] ?? 0);
                $this->total_bukanbumi_lelaki += (int)($this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0);
                $this->total_bukanbumi_perempuan += (int)($this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0);
                $this->total_asing_lelaki += (int)($this->pekerja_asing_lelaki[$key] ?? 0);
                $this->total_asing_perempuan += (int)($this->pekerja_asing_perempuan[$key] ?? 0);
                $this->total_pekerja_lelaki += (int)($this->jumlah_lelaki[$key] ?? 0);
                $this->total_pekerja_perempuan += (int)($this->jumlah_perempuan[$key] ?? 0);
                $this->total_pekerja += (int)($this->jumlah_pekerja[$key] ?? 0);
                $this->jumlah_gaji_lelaki += (float)($this->gaji_lelaki[$key] ?? 0);
                $this->jumlah_gaji_perempuan += (float)($this->gaji_perempuan[$key] ?? 0);
                $this->jumlah_lelaki_perempuan += (float)($this->gaji_lelaki_perempuan[$key] ?? 0);
                $this->jumlah_total_lelaki += (float)($this->total_gaji_lelaki[$key] ?? 0);
                $this->jumlah_total_perempuan += (float)($this->total_gaji_perempuan[$key] ?? 0);
                $this->jumlah_total_gaji += (float)($this->total_gaji[$key] ?? 0);
            }
            $this->jumlah_gaji_lelaki = round($this->jumlah_gaji_lelaki, 2);
            $this->jumlah_gaji_perempuan = round($this->jumlah_gaji_perempuan, 2);
            $this->jumlah_lelaki_perempuan = round($this->jumlah_lelaki_perempuan, 2);
            $this->jumlah_total_lelaki = round($this->jumlah_total_lelaki, 2);
            $this->jumlah_total_perempuan = round($this->jumlah_total_perempuan, 2);
            $this->jumlah_total_gaji = round($this->jumlah_total_gaji, 2);
        }
    }

    // male cell use this function for calculation, use this in wire:change for male input cells
    public function calcJumlahPekerjaLelaki($key)   //(02)+(04)+(06)= (08)
    {
        $warga = $this->pekerja_wargabumi_lelaki[$key] ?? 0;
        $bukan_warga = $this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0;
        $asing = $this->pekerja_asing_lelaki[$key] ?? 0;

        $jumlah = (int)$warga + (int)$bukan_warga + (int)$asing;

        $this->jumlah_lelaki[$key] = $jumlah; // (08)

        $this->calcJumlahLelakiBumiputera($key); // (02, 9)
        $this->calcJumlahLelakiBukanBumiputera($key); //(04, 9)
        $this->calcJumlahLelakiBukanWarganegara($key); // (06, 9)
        $this->calcTotalAllPekerjaLelaki($key); // (08, 9)

        $this->calcJumlahPekerja($key); // (10)
        $this->calcTotalAllJumlahPekerja($key); // (10, 9)

        $this->calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan($key); // (11)+(12)=(13)
        $this->calcTotalAllBayaranGajiPerPekerjaLelaki($key); // (11, 9)
        $this->calcTotalAllBayaranGajiLelakiPerempuan($key); // (13, 9)

        $this->calcJumlahGajiUpahSebulanLelaki($key); // (14)
        $this->calcTotalAllBayaranGajiLelaki($key); // (14, 9)

        $this->calcJumlahGaji($key); //(14)+(15)= (16)
        $this->calcTotalAllBayaranGaji($key); // (16, 9)
    }

    // female cell use this function for calculation, use this in wire:change for female input cells
    public function calcJumlahPekerjaPerempuan($key) //(03)+(05)+(07)= (09)
    {
        $warga = $this->pekerja_wargabumi_perempuan[$key] ?? 0;
        $bukan_warga = $this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0;
        $asing = $this->pekerja_asing_perempuan[$key] ?? 0;

        $jumlah = (int)$warga + (int)$bukan_warga + (int)$asing;

        $this->jumlah_perempuan[$key] = $jumlah;

        $this->calcJumlahPerempuanBumiputera($key); // (03, 9)
        $this->calcJumlahPerempuanBukanBumiputera($key); // (05, 9)
        $this->calcJumlahPerempuanBukanWarganegara($key); // (07, 9)
        $this->calcTotalAllPekerjaPerempuan($key);

        $this->calcJumlahPekerja($key); // (10)
        $this->calcTotalAllJumlahPekerja($key); // (10, 9)

        $this->calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan($key); // (11)+(12)=(13)
        $this->calcTotalAllBayaranGajiPerPekerjaPerempuan($key); // (11, 9)
        $this->calcTotalAllBayaranGajiLelakiPerempuan($key); // (13, 9)

        $this->calcJumlahGajiUpahSebulanPerempuan($key); // (14)
        $this->calcTotalAllBayaranGajiPerempuan($key); // (14, 9)

        $this->calcJumlahGaji($key); //(14)+(15)= (16)
        $this->calcTotalAllBayaranGaji($key); // (16, 9)
    }

    public function calcJumlahPekerja($key) // (08)+(09)= (10)
    {
        $lelaki = $this->jumlah_lelaki[$key] ?? 0;
        $perempuan = $this->jumlah_perempuan[$key] ?? 0;
        $this->jumlah_pekerja[$key] = (int)$lelaki + (int)$perempuan;
    }

    public function calcTotalAllJumlahPekerja($key) // (10, 9)
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_pekerja = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $total = $this->jumlah_pekerja[$key] ?? 0;
            $this->total_pekerja += (int)$total;
        }
    }

    public function calcJumlahGaji($key) //(13)+(14)= (15)
    {
        $lelaki = $this->total_gaji_lelaki[$key] ?? 0;
        $perempuan = $this->total_gaji_perempuan[$key] ?? 0;
        $this->total_gaji[$key] = number_format((float)$lelaki + (float)$perempuan ,2,'.','');
    }

    public function calcJumlahLelakiBumiputera($key)    //jumlah total bumiputera lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bumi_lelaki = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->pekerja_wargabumi_lelaki[$key] ?? 0;
            $this->total_bumi_lelaki += (int)$lelaki;
        }
    }

    public function calcJumlahPerempuanBumiputera($key) //jumlah total bumiputera perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bumi_perempuan = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->pekerja_wargabumi_perempuan[$key] ?? 0;
            $this->total_bumi_perempuan += (int)$perempuan;
        }
    }

    public function calcJumlahLelakiBukanBumiputera($key) //jumlah total bukan bumiputera lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bukanbumi_lelaki = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0;
            $this->total_bukanbumi_lelaki += (int)$lelaki;
        }
    }

    public function calcJumlahPerempuanBukanBumiputera($key)    //jumlah total bukan bumiputera perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bukanbumi_perempuan = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0;
            $this->total_bukanbumi_perempuan += (int)$perempuan;
        }
    }

    public function calcJumlahLelakiBukanWarganegara($key) //jumlah total bukan warganegara lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_asing_lelaki = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->pekerja_asing_lelaki[$key] ?? 0;
            $this->total_asing_lelaki += (int)$lelaki;
        }
    }

    public function calcJumlahPerempuanBukanWarganegara($key)   //jumlah total bukan warganegara perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_asing_perempuan = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->pekerja_asing_perempuan[$key] ?? 0;
            $this->total_asing_perempuan += (int)$perempuan;
        }
    }

    public function calcTotalAllPekerjaLelaki($key)   //jumlah total pekerja lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_pekerja_lelaki = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->jumlah_lelaki[$key] ?? 0;
            $this->total_pekerja_lelaki += (int)$lelaki;
        }
    }

    public function calcTotalAllPekerjaPerempuan($key)   //jumlah total pekerja perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_pekerja_perempuan = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->jumlah_perempuan[$key] ?? 0;
            $this->total_pekerja_perempuan += (int)$perempuan;
        }
    }

    public function calcTotalAllBayaranGajiPerPekerjaLelaki($key)   //jumlah total bayaran gaji per pekerja lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_gaji_lelaki = 0;
        $jumlah_gaji_lelaki = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->gaji_lelaki[$key] ?? 0;
            $jumlah_gaji_lelaki += round((float)$lelaki,2);
            $this->jumlah_gaji_lelaki = round($jumlah_gaji_lelaki,2);
        }
    }

    public function calcTotalAllBayaranGajiPerPekerjaPerempuan($key)   //jumlah total bayaran gaji per pekerja perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_gaji_perempuan = 0;
        $jumlah_gaji_perempuan = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->gaji_perempuan[$key] ?? 0;
            $jumlah_gaji_perempuan += round((float)$perempuan,2);
            $this->jumlah_gaji_perempuan = round($jumlah_gaji_perempuan,2);
        }
    }


    public function calcTotalAllBayaranGajiLelakiPerempuan($key)   //TOTAL SEMUA GAJI PER LELAKI+PEREMPUAN
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_lelaki_perempuan = 0;
        $jumlah_lelaki_perempuan_baru = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $jumlah_lelaki_perempuan = number_format($this->gaji_lelaki_perempuan[$key] ?? 0.00 ,2,'.','');
            $jumlah_lelaki_perempuan_baru += number_format((float)$jumlah_lelaki_perempuan, 2,'.','');
            $this->jumlah_lelaki_perempuan = round($jumlah_lelaki_perempuan_baru,2);
        }
    }

    public function calcJumlahGajiUpahSebulanLelaki($key)   //(14)= (08) * (11)
    {
        $this->total_gaji_lelaki[$key] = 0;
        $jumlah_lelaki = $this->jumlah_lelaki[$key] ?? 0;
        $gaji_per_pekerja =  $this->gaji_lelaki[$key] ?? 0;
        $total_gaji_lelaki = (int)$jumlah_lelaki * (float)$gaji_per_pekerja;
        $this->total_gaji_lelaki[$key] += number_format((float)$total_gaji_lelaki,2,'.','');
    }

    public function calcJumlahGajiUpahSebulanPerempuan($key)   //(14)= (08) * (11)
    {
        $this->total_gaji_perempuan[$key] = 0;
        $jumlah_perempuan = $this->jumlah_perempuan[$key] ?? 0;
        $gaji_per_pekerja =  $this->gaji_perempuan[$key] ?? 0;
        $total_gaji_perempuan = (int)$jumlah_perempuan * (float)$gaji_per_pekerja;
        $this->total_gaji_perempuan[$key] += number_format((float)$total_gaji_perempuan,2,'.','');
    }

    public function calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan($key)   //jumlah total bayaran gaji per pekerja lelaki + perempuan
    {
        $this->gaji_lelaki_perempuan[$key] = 0;
        $gaji_lelaki_perempuan = 0;
        $perempuan = $this->gaji_perempuan[$key] ?? 0;
        $lelaki = $this->gaji_lelaki[$key] ?? 0;
        $decimal =number_format(((float)$lelaki + (float)$perempuan),2,'.','');
        $gaji_lelaki_perempuan += $decimal;
        $this->gaji_lelaki_perempuan[$key] = round($gaji_lelaki_perempuan,2);
        // $this->gaji_lelaki_perempuan[$key] =1;
    }

    public function calcTotalAllBayaranGajiLelaki($key)   //jumlah total bayaran gaji pekerja lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_total_lelaki = 0;
        $jumlah_total_lelaki = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = number_format($this->total_gaji_lelaki[$key],2,'.','') ?? 0;
            $jumlah_total_lelaki += number_format((float)$lelaki,2,'.','');
            $this->jumlah_total_lelaki = round($jumlah_total_lelaki, 2);
        }
    }

    public function calcTotalAllBayaranGajiPerempuan($key)   //jumlah total bayaran gaji pekerja perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_total_perempuan = 0;
        $jumlah_total_perempuan = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = number_format($this->total_gaji_perempuan[$key],2,'.','') ?? 0;
            $jumlah_total_perempuan += number_format((float)$perempuan,2,'.','');
            $this->jumlah_total_perempuan = round($jumlah_total_perempuan,2);
        }
    }

    public function calcTotalAllBayaranGaji($key)   //jumlah total bayaran gaji pekerja lelaki + perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_total_gaji = 0.00;
        $jumlah_total_gaji = 0;
        foreach ($kategori_pekerja as $key => $data) {
            (float)$total = number_format((float)$this->total_gaji[$key],2,'.','') ?? 0.00;
            $jumlah_total_gaji += round($total,2);
            $this->jumlah_total_gaji = round($jumlah_total_gaji,2);

        }

        // dd($this->jumlah_total_gaji);

    }


    public function store()
    {
        $kategori = KategoriGunaTenaga::get();

        foreach ($kategori as $key => $value) {
            $this->max_gaji[$key] = $value->gaji_max;
            $this->min_gaji[$key] = $value->gaji_min;
        }

        foreach ($kategori as $key => $value) {
            $this->jumlah_lelaki[$key] = (int)($this->pekerja_wargabumi_lelaki[$key] ?? 0)
                + (int)($this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0)
                + (int)($this->pekerja_asing_lelaki[$key] ?? 0);
            $this->jumlah_perempuan[$key] = (int)($this->pekerja_wargabumi_perempuan[$key] ?? 0)
                + (int)($this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0)
                + (int)($this->pekerja_asing_perempuan[$key] ?? 0);
            $this->jumlah_pekerja[$key] = $this->jumlah_lelaki[$key] + $this->jumlah_perempuan[$key];
        }

        if ($this->jumlah_pekerja[0] == 0) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Jumlah Pekerja bagi Pemilik dan Rakan Kongsi tidak boleh 0']);
            return back();
        }

        $rules = [];
        foreach ($kategori as $key => $value) {
            if (($this->jumlah_lelaki[$key] ?? 0) > 0) {
                $rules['gaji_lelaki.' . $key] = 'required|numeric|min:' . $value->gaji_min . '|max:' . $value->gaji_max;
            }
            if (($this->jumlah_perempuan[$key] ?? 0) > 0) {
                $rules['gaji_perempuan.' . $key] = 'required|numeric|min:' . $value->gaji_min . '|max:' . $value->gaji_max;
            }
        }
        if (!empty($rules)) {
            $this->validate($rules);
        }

        // Recalculate derived salary fields and grand totals before saving
        $this->total_bumi_lelaki = $this->total_bumi_perempuan = 0;
        $this->total_bukanbumi_lelaki = $this->total_bukanbumi_perempuan = 0;
        $this->total_asing_lelaki = $this->total_asing_perempuan = 0;
        $this->total_pekerja_lelaki = $this->total_pekerja_perempuan = $this->total_pekerja = 0;
        $this->jumlah_gaji_lelaki = $this->jumlah_gaji_perempuan = $this->jumlah_lelaki_perempuan = 0;
        $this->jumlah_total_lelaki = $this->jumlah_total_perempuan = $this->jumlah_total_gaji = 0;

        foreach ($kategori as $key => $value) {
            $jl = $this->jumlah_lelaki[$key] ?? 0;
            $jp = $this->jumlah_perempuan[$key] ?? 0;
            $gl = (float)($this->gaji_lelaki[$key] ?? 0);
            $gp = (float)($this->gaji_perempuan[$key] ?? 0);

            $this->gaji_lelaki_perempuan[$key] = round($gl + $gp, 2);
            $this->total_gaji_lelaki[$key] = round($jl * $gl, 2);
            $this->total_gaji_perempuan[$key] = round($jp * $gp, 2);
            $this->total_gaji[$key] = round($this->total_gaji_lelaki[$key] + $this->total_gaji_perempuan[$key], 2);

            $this->total_bumi_lelaki += (int)($this->pekerja_wargabumi_lelaki[$key] ?? 0);
            $this->total_bumi_perempuan += (int)($this->pekerja_wargabumi_perempuan[$key] ?? 0);
            $this->total_bukanbumi_lelaki += (int)($this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0);
            $this->total_bukanbumi_perempuan += (int)($this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0);
            $this->total_asing_lelaki += (int)($this->pekerja_asing_lelaki[$key] ?? 0);
            $this->total_asing_perempuan += (int)($this->pekerja_asing_perempuan[$key] ?? 0);
            $this->total_pekerja_lelaki += $jl;
            $this->total_pekerja_perempuan += $jp;
            $this->total_pekerja += $this->jumlah_pekerja[$key] ?? 0;
            $this->jumlah_gaji_lelaki += $gl;
            $this->jumlah_gaji_perempuan += $gp;
            $this->jumlah_lelaki_perempuan += $this->gaji_lelaki_perempuan[$key];
            $this->jumlah_total_lelaki += $this->total_gaji_lelaki[$key];
            $this->jumlah_total_perempuan += $this->total_gaji_perempuan[$key];
            $this->jumlah_total_gaji += $this->total_gaji[$key];
        }
        // $this->validate([
        //     'gaji_lelaki.0' => 'min:'.$this->min_gaji.'|max:'.$this->max_gaji.'|required',
        //     'gaji_perempuan.0' => 'min:'.$this->min_gaji.'|max:'.$this->max_gaji.'|required',

        //     'gaji_lelaki.*' => 'min:'.$this->min_gaji.'|max:'.$this->max_gaji.'|required',
        //     'gaji_perempuan.*' => 'min:'.$this->min_gaji.'|max:'.$this->max_gaji.'|required',
        // ]);

        $kategori_pekerja = KategoriGunaTenaga::get();
        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        // dd($kilang_info);
        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();
        // dd($shuttle_id);
        // $formbs = FormBBaru::create([
        //     'shuttle_id'=>$shuttle_id->id,
        //     'shuttle_type'=>$shuttle_id->shuttle_type,
        //     'status' => $status,
        //     'tahun' => $kilang_info->tahun,
        //     'suku_tahun' => $this->suku,
        //     'nama_kilang' => $kilang_info->nama_kilang,
        //     'no_ssm' => $kilang_info->no_ssm,
        //     'no_lesen' => $kilang_info->no_lesen,

        //     //tambah  nama kilang, tahun,nolesen,no ssm
        // ]);
        // dd($this->total_bumi_lelaki);
        // dd($this->gaji_lelaki_perempuan);

        if ($this->suku ==  'Suku Pertama') {
            $this->suku_id = "1";
        } else if ($this->suku_id ==  'Suku Kedua') {
            $this->suku_id = "2";
        } else if ($this->suku ==  'Suku Ketiga') {
            $this->suku_id = "3";
        } else if ($this->suku ==  'Suku Keempat') {
            $this->suku_id = "4";
        }

        $user = auth()->user();
        // dd($this->suku_id);

        $formb = FormBBaru::where('shuttle_id', $user->shuttle_id)->where('suku_tahun', $this->suku_id)->where('tahun', $this->year)->first();

        $formb->status = 'Sedang Diproses';
        $formb->save();

        if ($formb->suku_tahun == 1) {
            $bulan = 3;
        } elseif ($formb->suku_tahun == 2) {
            $bulan = 6;
        } elseif ($formb->suku_tahun == 3) {
            $bulan = 9;
        } elseif ($formb->suku_tahun == 4) {
            $bulan = 12;
        }
        $batch = Batch::where('tahun', $formb->tahun)->where('bulan', $bulan)->where('shuttle_id',$formb->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_b = 1;
        $batch->save();
        // dd($formb);

        GunaTenaga::where('formbs_id', $formb->id)->delete();

        foreach ($kategori_pekerja as $key => $data) {
            GunaTenaga::create([
                'pekerja_wargabumi_lelaki' => $this->pekerja_wargabumi_lelaki[$key] ?? 0,
                'pekerja_wargabumi_perempuan' => $this->pekerja_wargabumi_perempuan[$key] ?? 0,
                'pekerja_bukan_wargabumi_lelaki' => $this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0,
                'pekerja_bukan_wargabumi_perempuan' => $this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0,
                'pekerja_asing_lelaki' => $this->pekerja_asing_lelaki[$key] ?? 0,
                'pekerja_asing_perempuan' => $this->pekerja_asing_perempuan[$key] ?? 0,
                'jumlah_lelaki' => $this->jumlah_lelaki[$key] ?? 0,
                'jumlah_perempuan' => $this->jumlah_perempuan[$key] ?? 0,
                'jumlah_pekerja' => $this->jumlah_pekerja[$key] ?? 0,
                'gaji_lelaki' => $this->gaji_lelaki[$key] ?? 0,
                'gaji_perempuan' => $this->gaji_perempuan[$key] ?? 0,
                'total_gaji_lelaki' => $this->total_gaji_lelaki[$key] ?? 0,
                'total_gaji_perempuan' => $this->total_gaji_perempuan[$key] ?? 0,
                'total_gaji' => $this->total_gaji[$key] ?? 0,
                'gaji_lelaki_perempuan'  => $this->gaji_lelaki_perempuan[$key] ?? 0,

                'total_bumi_lelaki'  => $this->total_bumi_lelaki ?? 0,
                'total_bumi_perempuan'  => $this->total_bumi_perempuan ?? 0,
                'total_bukanbumi_lelaki' => $this->total_bukanbumi_lelaki ?? 0,
                'total_bukanbumi_perempuan' => $this->total_bukanbumi_perempuan ?? 0,
                'total_asing_lelaki' => $this->total_asing_lelaki ?? 0,
                'total_asing_perempuan' => $this->total_asing_perempuan ?? 0,
                'total_pekerja_lelaki' => $this->total_pekerja_lelaki ?? 0,
                'total_pekerja_perempuan' => $this->total_pekerja_perempuan ?? 0,
                'total_pekerja' => $this->total_pekerja ?? 0,
                'jumlah_gaji_lelaki' => $this->jumlah_gaji_lelaki ?? 0,
                'jumlah_gaji_perempuan' => $this->jumlah_gaji_perempuan ?? 0,
                'jumlah_lelaki_perempuan' => $this->jumlah_lelaki_perempuan ?? 0,
                'jumlah_total_lelaki' => $this->jumlah_total_lelaki ?? 0,
                'jumlah_total_perempuan' => $this->jumlah_total_perempuan ?? 0,
                'jumlah_total_gaji' => $this->jumlah_total_gaji ?? 0,

                'shuttle_id' => $shuttle_id->id,
                'kategori_guna_tenaga_id' => $data->id,
                'bulan' => now()->month,
                'tahun' => $this->year,
                'formbs_id' => $formb->id,


            ]);
        }
        Session::flash('success', 'Maklumat berjaya dihantar. Sila tunggu untuk pengesahan PHD.');


        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where('kategori_pengguna', 'PHD')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formb))->delay($delay));
        }

        return redirect()->route('home-user');
    }
}
