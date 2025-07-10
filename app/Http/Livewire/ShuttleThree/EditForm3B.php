<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Batch;
use Livewire\Component;
use App\Models\FormB;
use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use App\Models\Shuttle;
use App\Models\UlasanPhd;
use Illuminate\Support\Facades\Session;
use PDO;

class EditForm3B extends Component
{

    public $shuttle_id;
    public $pekerja_wargabumi_lelaki, $pekerja_wargabumi_perempuan, $pekerja_bukan_wargabumi_lelaki, $pekerja_bukan_wargabumi_perempuan, $pekerja_asing_lelaki, $pekerja_asing_perempuan,
        $jumlah_lelaki, $jumlah_perempuan, $jumlah_pekerja, $gaji_lelaki, $gaji_perempuan, $total_gaji_lelaki, $total_gaji_perempuan, $total_gaji,
        $total_bumi_lelaki,$total_bumi_perempuan,$total_bukanbumi_lelaki,$total_bukanbumi_perempuan,$total_asing_lelaki,$total_asing_perempuan,
        $total_pekerja_lelaki,$total_pekerja_perempuan,$total_pekerja, $jumlah_gaji_lelaki, $jumlah_gaji_perempuan, $jumlah_total_lelaki,
        $gaji_lelaki_perempuan, $perempuan, $lelaki, $jumlah_total_perempuan, $jumlah_total_gaji,$jumlah_lelaki_perempuan, $max_gaji, $min_gaji;

    public $validation_jumlah_lelaki_sifar, $validation_jumlah_perempuan_sifar;

    public function render()
    {
        // $id=auth()->user();
        $kategori_pekerja = KategoriGunaTenaga::get();

        $formb_id = FormB::findorfail($this->shuttle_id);


        // dd($formb_id);
        $ulasan = UlasanPhd::where('formbs_id',$formb_id->id)->latest('created_at')->first();


        if($formb_id->shuttle_type == 3){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-3-senaraiB', date('Y')), 'name' => "Borang 3B - JUMLAH GUNA TENAGA"],
            ];

            $kembali = route('user.shuttle-3-senaraiB', date('Y'));

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        }

        elseif($formb_id->shuttle_type == 4){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-4-senaraiB', date('Y')), 'name' => "Borang 4B - JUMLAH GUNA TENAGA"],
            ];

            $kembali = route('user.shuttle-4-senaraiB', date('Y'));

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        }

        elseif($formb_id->shuttle_type == 5){
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiB', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => route('user.shuttle-5-senaraiB', date('Y')), 'name' => "Borang 5B - JUMLAH GUNA TENAGA"],
            ];

            $kembali = route('user.shuttle-5-senaraiB', date('Y'));

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];
        }

        return view('livewire.shuttle-three.edit-form3-b',compact('kategori_pekerja','ulasan','formb_id', 'returnArr'));
    }

    public function mount(){
        $formB = GunaTenaga::where('formbs_id',$this->shuttle_id)->get();
        // dd($formB);
        foreach ($formB as $key => $value) {
            $this->pekerja_wargabumi_lelaki[$key] = $value->pekerja_wargabumi_lelaki;
            $this->pekerja_wargabumi_perempuan[$key] = $value->pekerja_wargabumi_perempuan;
            $this->pekerja_bukan_wargabumi_lelaki[$key] = $value->pekerja_bukan_wargabumi_lelaki;
            $this->pekerja_bukan_wargabumi_perempuan[$key] = $value->pekerja_bukan_wargabumi_perempuan;
            $this->pekerja_asing_lelaki[$key] = $value->pekerja_asing_lelaki;
            $this->pekerja_asing_perempuan[$key] = $value->pekerja_asing_perempuan;
            $this->jumlah_lelaki[$key] = $value->jumlah_lelaki;
            $this->jumlah_perempuan[$key] = $value->jumlah_perempuan;
            $this->jumlah_pekerja[$key] = $value->jumlah_pekerja;
            $this->gaji_lelaki[$key] = number_format($value->gaji_lelaki, 2, '.', '');
            $this->gaji_perempuan[$key] = number_format($value->gaji_lelaki, 2, '.', '');
            $this->gaji_lelaki_perempuan[$key] = number_format($value->gaji_lelaki_perempuan, 2, '.', '');
            $this->total_gaji_lelaki[$key] = number_format($value->total_gaji_lelaki, 2, '.', '');
            $this->total_gaji_perempuan[$key] = number_format($value->total_gaji_perempuan, 2, '.', '');
            $this->total_gaji[$key] = number_format($value->total_gaji, 2, '.', '');

            $this->total_bumi_lelaki = $value->total_bumi_lelaki;
            $this->total_bumi_perempuan = $value->total_bumi_perempuan;
            $this->total_bukanbumi_lelaki = $value->total_bukanbumi_lelaki;
            $this->total_bukanbumi_perempuan = $value->total_bukanbumi_perempuan;
            $this->total_asing_lelaki = $value->total_asing_lelaki;
            $this->total_asing_perempuan = $value->total_asing_perempuan;
            $this->total_pekerja_lelaki = $value->total_pekerja_lelaki;
            $this->total_pekerja_perempuan = $value->total_pekerja_perempuan;
            $this->total_pekerja = $value->total_pekerja;
            $this->jumlah_gaji_lelaki = number_format($value->jumlah_gaji_lelaki, 2, '.', '');
            $this->jumlah_gaji_perempuan = number_format($value->jumlah_gaji_perempuan, 2, '.', '');
            $this->jumlah_lelaki_perempuan = number_format($value->jumlah_lelaki_perempuan, 2, '.', '');
            $this->jumlah_total_lelaki = $value->jumlah_total_lelaki;
            $this->jumlah_total_perempuan = $value->jumlah_total_perempuan;
            $this->jumlah_total_gaji = number_format($value->jumlah_total_gaji, 2, '.', '');
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
            // $this->jumlah_gaji_perempuan =1;
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

    public function update()
    {
        $kategori = KategoriGunaTenaga::get();


        foreach ($kategori as $key => $value) {
            $this->max_gaji[$key] = $value->gaji_max;
            $this->min_gaji[$key] = $value->gaji_min;
        }

        foreach ($this->gaji_lelaki as $key => $data) {
            if ($data == '0.00') {
                (float)$this->gaji_lelaki[$key] = '';
            }
        }

        foreach ($this->gaji_perempuan as $key => $data) {
            if ($data == '0.00') {
                (float)$this->gaji_perempuan[$key] = '';
            }
        }

        $this->validate([
            'gaji_lelaki.0' => 'required_unless:jumlah_lelaki.0, 0|numeric|min:' . $this->min_gaji[0] . '|max:' . $this->max_gaji[0],
            'gaji_perempuan.0' => 'required_unless:jumlah_perempuan.0, 0|numeric|min:' . $this->min_gaji[0] . '|max:' . $this->max_gaji[0],

            'gaji_lelaki.1' => 'required_unless:jumlah_lelaki.1,0|numeric|min:' . $this->min_gaji[1] . '|max:' . $this->max_gaji[1],
            'gaji_perempuan.1' => 'required_unless:jumlah_perempuan.1, 0|numeric|min:' . $this->min_gaji[1] . '|max:' . $this->max_gaji[1],

            'gaji_lelaki.2' => 'required_unless:jumlah_lelaki.2, 0|numeric|min:' . $this->min_gaji[2] . '|max:' . $this->max_gaji[2],
            'gaji_perempuan.2' => 'required_unless:jumlah_perempuan.2, 0|numeric|min:' . $this->min_gaji[2] . '|max:' . $this->max_gaji[2],

            'gaji_lelaki.3' => 'required_unless:jumlah_lelaki.3, 0|numeric|min:' . $this->min_gaji[3] . '|max:' . $this->max_gaji[3],
            'gaji_perempuan.3' => 'required_unless:jumlah_perempuan.3, 0|numeric|min:' . $this->min_gaji[3] . '|max:' . $this->max_gaji[3],

            'gaji_lelaki.4' => 'required_unless:jumlah_lelaki.4, 0|numeric|min:' . $this->min_gaji[4] . '|max:' . $this->max_gaji[4],
            'gaji_perempuan.4' => 'required_unless:jumlah_perempuan.4, 0|numeric|min:' . $this->min_gaji[4] . '|max:' . $this->max_gaji[4],

            'gaji_lelaki.5' => 'required_unless:jumlah_lelaki.5, 0|numeric|min:' . $this->min_gaji[5] . '|max:' . $this->max_gaji[5],
            'gaji_perempuan.5' => 'required_unless:jumlah_perempuan.5, 0|numeric|min:' . $this->min_gaji[5] . '|max:' . $this->max_gaji[5],

            'gaji_lelaki.6' => 'required_unless:jumlah_lelaki.6, 0|numeric|min:' . $this->min_gaji[6] . '|max:' . $this->max_gaji[6],
            'gaji_perempuan.6' => 'required_unless:jumlah_perempuan.6, 0|numeric|min:' . $this->min_gaji[6] . '|max:' . $this->max_gaji[6],

            'gaji_lelaki.7' => 'required_unless:jumlah_lelaki.7, 0|numeric|min:' . $this->min_gaji[7] . '|max:' . $this->max_gaji[7],
            'gaji_perempuan.7' => 'required_unless:jumlah_perempuan.7, 0|numeric|min:' . $this->min_gaji[7] . '|max:' . $this->max_gaji[7],
        ]);

        foreach ($this->gaji_lelaki as $key => $data) {
            if ($data == '') {
                (float)$this->gaji_lelaki[$key] = '0.00';
            }
        }

        foreach ($this->gaji_perempuan as $key => $data) {
            if ($data == '') {
                (float)$this->gaji_perempuan[$key] = '0.00';
            }
        }

        $kategori_pekerja = KategoriGunaTenaga::get();
        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();
        $status= 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id',$id->shuttle_id)->first();

        // $formB=GunaTenaga::where('shuttle_id',$this->shuttle_id)->get();
        $formb= FormB::findorfail($this->shuttle_id);
        $formb->status = 'Sedang Diproses';
        $formb->save();

        if($formb->suku_tahun == 1){
            $bulan = 3;
        }elseif($formb->suku_tahun == 2){
            $bulan = 6;
        }elseif($formb->suku_tahun == 3){
            $bulan = 9;
        }elseif($formb->suku_tahun == 4){
            $bulan = 12;
        }

        $batch = Batch::where('tahun',$formb->tahun)->where('bulan', $bulan)->where('shuttle_id', $formb->shuttle_id)->where('borang_b','0')->first();
        // $batch->borang_b = "1";
        // $batch->save();

        // dd($formb_id);
        $guna_tenaga_update = GunaTenaga::where('formbs_id',$formb->id)->get();
        foreach ($guna_tenaga_update as $key => $data) {
            $data->update([
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
                'gaji_lelaki_perempuan'  => $this->gaji_lelaki_perempuan[$key] ?? 0 ,

                'total_bumi_lelaki'  => $this->total_bumi_lelaki ,
                'total_bumi_perempuan'  => $this->total_bumi_perempuan ,
                'total_bukanbumi_lelaki' => $this->total_bukanbumi_lelaki ,
                'total_bukanbumi_perempuan' => $this->total_bukanbumi_perempuan ,
                'total_asing_lelaki' => $this->total_asing_lelaki ,
                'total_asing_perempuan' => $this->total_asing_perempuan ,
                'total_pekerja_lelaki' => $this->total_pekerja_lelaki ,
                'total_pekerja_perempuan' => $this->total_pekerja_perempuan ,
                'total_pekerja' => $this->total_pekerja ,
                'jumlah_gaji_lelaki' => $this->jumlah_gaji_lelaki ,
                'jumlah_gaji_perempuan' => $this->jumlah_gaji_perempuan ,
                'jumlah_lelaki_perempuan' => $this->jumlah_lelaki_perempuan ,
                'jumlah_total_lelaki' => $this->jumlah_total_lelaki ,
                'jumlah_total_perempuan' => $this->jumlah_total_perempuan ,
                'jumlah_total_gaji' => $this->jumlah_total_gaji ,

                // 'shuttle_id' => $shuttle_id->id,
                // 'kategori_guna_tenaga_id' => $data->id,
                // 'bulan' => now()->month,
                // 'tahun' => now()->year,
                // 'formbs_id' => $formb->id,
            ]);
    }
    Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD');

    return redirect()->route('home-user');
    }
}
