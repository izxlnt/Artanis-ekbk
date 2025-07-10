<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\FormB;
use App\Models\FormB as FormBBaru;
use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use App\Models\Shuttle;
use App\Models\UlasanIpjpsm;
use App\Models\UlasanPhd;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class DataCleaning3B extends Component
{
    public $kilang_info, $formb_id;

    public $pekerja_wargabumi_lelaki_cleaning, $pekerja_wargabumi_perempuan_cleaning, $pekerja_bukan_wargabumi_lelaki_cleaning, $pekerja_bukan_wargabumi_perempuan_cleaning, $pekerja_asing_lelaki_cleaning, $pekerja_asing_perempuan_cleaning,
        $jumlah_lelaki_cleaning, $jumlah_perempuan_cleaning, $jumlah_pekerja_cleaning, $gaji_lelaki_cleaning, $gaji_perempuan_cleaning, $total_gaji_lelaki_cleaning, $total_gaji_perempuan_cleaning, $total_gaji_cleaning,
        $total_bumi_lelaki_cleaning, $total_bumi_perempuan, $total_bukanbumi_lelaki, $total_bukanbumi_perempuan, $total_asing_lelaki, $total_asing_perempuan,
        $total_pekerja_lelaki_cleaning, $total_pekerja_perempuan_cleaning, $total_pekerja_cleaning, $jumlah_gaji_lelaki_cleaning, $jumlah_gaji_perempuan_cleaning, $jumlah_total_lelaki_cleaning,
        $gaji_lelaki_perempuan_cleaning, $perempuan, $lelaki, $jumlah_total_perempuan_cleaning, $jumlah_total_gaji_cleaning, $jumlah_lelaki_perempuan,
        $total_bumi_perempuan_cleaning, $total_bukanbumi_lelaki_cleaning, $total_asing_lelaki_cleaning, $total_asing_perempuan_cleaning, $total_bukanbumi_perempuan_cleaning,
        $jumlah_lelaki_perempuan_cleaning, $ulasan_ipjpsm, $status, $formbs;

    // male cell use this function for calculation, use this in wire:change for male input cells
    public function calcJumlahPekerjaLelakiCleaning($key)   //(02)+(04)+(06)= (08)
    {
        $warga = $this->pekerja_wargabumi_lelaki_cleaning[$key] ?? 0;
        $bukan_warga = $this->pekerja_bukan_wargabumi_lelaki_cleaning[$key] ?? 0;
        $asing = $this->pekerja_asing_lelaki_cleaning[$key] ?? 0;

        $jumlah = (int)$warga + (int)$bukan_warga + (int)$asing;

        $this->jumlah_lelaki_cleaning[$key] = $jumlah;

        $this->calcJumlahLelakiBumiputeraCleaning($key); // (02, 9)
        $this->calcJumlahLelakiBukanBumiputeraCleaning($key); //(04, 9)
        $this->calcJumlahLelakiBukanWarganegaraCleaning($key); // (06, 9)
        $this->calcTotalAllPekerjaLelakiCleaning($key); // (08, 9)

        $this->calcJumlahPekerjaCleaning($key); // (10)
        $this->calcTotalAllJumlahPekerjaCleaning($key); // (10, 9)

        $this->calcTotalAllBayaranGajiPerPekerjaLelakiPerempuanCleaning($key); // (11)+(12)=(13)
        $this->calcTotalAllBayaranGajiPerPekerjaLelakiCleaning($key); // (11, 9)
        $this->calcTotalAllBayaranGajiLelakiPerempuanCleaning($key); // (13, 9)

        $this->calcJumlahGajiUpahSebulanLelakiCleaning($key); // (14)
        $this->calcTotalAllBayaranGajiLelakiCleaning($key); // (14, 9)

        $this->calcJumlahGajiCleaning($key); //(14)+(15)= (16)
        $this->calcTotalAllBayaranGajiCleaning($key); // (16, 9)
    }

    public function calcJumlahPekerjaPerempuanCleaning($key) //(03)+(05)+(07)= (09)
    {
        $warga = $this->pekerja_wargabumi_perempuan_cleaning[$key] ?? 0;
        $bukan_warga = $this->pekerja_bukan_wargabumi_perempuan_cleaning[$key] ?? 0;
        $asing = $this->pekerja_asing_perempuan_cleaning[$key] ?? 0;

        $jumlah = (int)$warga + (int)$bukan_warga + (int)$asing;

        $this->jumlah_perempuan_cleaning[$key] = $jumlah;

        $this->calcJumlahPerempuanBumiputeraCleaning($key); // (03, 9)
        $this->calcJumlahPerempuanBukanBumiputeraCleaning($key); // (05, 9)
        $this->calcJumlahPerempuanBukanWarganegaraCleaning($key); // (07, 9)
        $this->calcTotalAllPekerjaPerempuanCleaning($key);

        $this->calcJumlahPekerjaCleaning($key); // (10)
        $this->calcTotalAllJumlahPekerjaCleaning($key); // (10, 9)

        $this->calcTotalAllBayaranGajiPerPekerjaLelakiPerempuanCleaning($key); // (11)+(12)=(13)
        $this->calcTotalAllBayaranGajiPerPekerjaPerempuanCleaning($key); // (11, 9)
        $this->calcTotalAllBayaranGajiLelakiPerempuanCleaning($key); // (13, 9)

        $this->calcJumlahGajiUpahSebulanPerempuanCleaning($key); // (14)
        $this->calcTotalAllBayaranGajiPerempuanCleaning($key); // (14, 9)

        $this->calcJumlahGajiCleaning($key); //(14)+(15)= (16)
        $this->calcTotalAllBayaranGajiCleaning($key); // (16, 9)
    }

    public function calcJumlahPekerjaCleaning($key) //(08)+(09)= (10)
    {
        $lelaki = $this->jumlah_lelaki_cleaning[$key] ?? 0;
        $perempuan = $this->jumlah_perempuan_cleaning[$key] ?? 0;

        $this->jumlah_pekerja_cleaning[$key] = (int)$lelaki + (int)$perempuan;
    }

    public function calcTotalAllJumlahPekerjaCleaning($key)   //jumlah total pekerja lelaki + perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_pekerja_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {

            $total = $this->jumlah_pekerja_cleaning[$key] ?? 0;

            $this->total_pekerja_cleaning += (int)$total;
        }
    }

    public function calcJumlahGajiCleaning($key) //(13)+(14)= (15)
    {

        $lelaki = $this->total_gaji_lelaki_cleaning[$key] ?? 0;
        $perempuan = $this->total_gaji_perempuan_cleaning[$key] ?? 0;

        $this->total_gaji_cleaning[$key] =  (float)$lelaki + (float)$perempuan;
    }

    public function calcJumlahLelakiBumiputeraCleaning($key)    //jumlah total bumiputera lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bumi_lelaki_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->pekerja_wargabumi_lelaki_cleaning[$key] ?? 0;
            $this->total_bumi_lelaki_cleaning += (int)$lelaki;
        }
    }

    public function calcJumlahPerempuanBumiputeraCleaning($key) //jumlah total bumiputera perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bumi_perempuan_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->pekerja_wargabumi_perempuan_cleaning[$key] ?? 0;
            $this->total_bumi_perempuan_cleaning += (int)$perempuan;
        }
    }

    public function calcJumlahLelakiBukanBumiputeraCleaning($key) //jumlah total bukan bumiputera lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bukanbumi_lelaki_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->pekerja_bukan_wargabumi_lelaki_cleaning[$key] ?? 0;
            $this->total_bukanbumi_lelaki_cleaning += (int)$lelaki;
        }
    }

    public function calcJumlahPerempuanBukanBumiputeraCleaning($key)    //jumlah total bukan bumiputera perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_bukanbumi_perempuan_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->pekerja_bukan_wargabumi_perempuan_cleaning[$key] ?? 0;
            $this->total_bukanbumi_perempuan_cleaning += (int)$perempuan;
        }
    }


    public function calcJumlahLelakiBukanWarganegaraCleaning($key) //jumlah total bukan warganegara lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_asing_lelaki_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->pekerja_asing_lelaki_cleaning[$key] ?? 0;
            $this->total_asing_lelaki_cleaning += (int)$lelaki;
        }
    }

    public function calcJumlahPerempuanBukanWarganegaraCleaning($key)   //jumlah total bukan warganegara perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_asing_perempuan_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->pekerja_asing_perempuan_cleaning[$key] ?? 0;
            $this->total_asing_perempuan_cleaning += (int)$perempuan;
        }
    }

    public function calcTotalAllPekerjaLelakiCleaning($key)   //jumlah total pekerja lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_pekerja_lelaki_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->jumlah_lelaki_cleaning[$key] ?? 0;
            $this->total_pekerja_lelaki_cleaning += (int)$lelaki;
        }
    }

    public function calcTotalAllPekerjaPerempuanCleaning($key)   //jumlah total pekerja perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->total_pekerja_perempuan_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->jumlah_perempuan_cleaning[$key] ?? 0;
            $this->total_pekerja_perempuan_cleaning += (int)$perempuan;
        }
    }

    public function calcTotalAllBayaranGajiPerPekerjaLelakiCleaning($key)   //jumlah total bayaran gaji per pekerja lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_gaji_lelaki_cleaning = 0;
        $jumlah_gaji_lelaki_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->gaji_lelaki_cleaning[$key] ?? 0;
            $jumlah_gaji_lelaki_cleaning += round((float)$lelaki,2);
            $this->jumlah_gaji_lelaki_cleaning = round($jumlah_gaji_lelaki_cleaning,2);
        }
    }

    public function calcTotalAllBayaranGajiPerPekerjaPerempuanCleaning($key)   //jumlah total bayaran gaji per pekerja perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_gaji_perempuan_cleaning = 0;
        $jumlah_gaji_perempuan_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->gaji_perempuan_cleaning[$key] ?? 0;
            $jumlah_gaji_perempuan_cleaning += round((float)$perempuan,2);
            $this->jumlah_gaji_perempuan_cleaning = round($jumlah_gaji_perempuan_cleaning,2);
        }
    }

    public function calcTotalAllBayaranGajiLelakiPerempuanCleaning($key)   //TOTAL SEMUA GAJI PER LELAKI+PEREMPUAN
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_lelaki_perempuan_cleaning = 0;
        $jumlah_lelaki_perempuan_cleaning_decimal = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $jumlah_lelaki_perempuan_cleaning = $this->gaji_lelaki_perempuan_cleaning[$key] ?? null;
            $jumlah_lelaki_perempuan_cleaning_decimal += number_format((float)$jumlah_lelaki_perempuan_cleaning, 2,'.','');
            $this->jumlah_lelaki_perempuan_cleaning = round((float)$jumlah_lelaki_perempuan_cleaning_decimal,2);
        }
    }

    public function calcJumlahGajiUpahSebulanLelakiCleaning($key)   //(14)= (08) * (11)
    {
        $this->total_gaji_lelaki_cleaning[$key] = 0;
        $jumlah_lelaki = $this->jumlah_lelaki_cleaning[$key] ?? 0;
        $gaji_per_pekerja =  $this->gaji_lelaki_cleaning[$key] ?? 0;
        $total_gaji_lelaki = (int)$jumlah_lelaki * (float)$gaji_per_pekerja;
        $this->total_gaji_lelaki_cleaning[$key] += number_format((float)$total_gaji_lelaki,2,'.','');
    }

    public function calcJumlahGajiUpahSebulanPerempuanCleaning($key)   //(14)= (08) * (11)
    {
        $this->total_gaji_perempuan_cleaning[$key] = 0;
        $jumlah_perempuan = $this->jumlah_perempuan_cleaning[$key] ?? 0;
        $gaji_per_pekerja =  $this->gaji_lelaki_cleaning[$key] ?? 0;
        $total_gaji_perempuan = (int)$jumlah_perempuan * (float)$gaji_per_pekerja;
        $this->total_gaji_perempuan_cleaning[$key] += number_format((float)$total_gaji_perempuan,2,'.','');


    }

    public function calcTotalAllBayaranGajiPerPekerjaLelakiPerempuanCleaning($key)   //jumlah total bayaran gaji per pekerja lelaki + perempuan
    {
        $this->gaji_lelaki_perempuan_cleaning[$key] = 0;
        $gaji_lelaki_perempuan = 0;
        $perempuan = $this->gaji_perempuan_cleaning[$key] ?? 0;
        $lelaki = $this->gaji_lelaki_cleaning[$key] ?? 0;
        $decimal =number_format(((float)$lelaki + (float)$perempuan),2,'.','');
        $gaji_lelaki_perempuan += $decimal;
        $this->gaji_lelaki_perempuan_cleaning[$key] = round($gaji_lelaki_perempuan,2);
    }

    public function calcTotalAllBayaranGajiLelakiCleaning($key)   //jumlah total bayaran gaji pekerja lelaki
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_total_lelaki_cleaning = 0;
        $jumlah_total_lelaki_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $lelaki = $this->total_gaji_lelaki_cleaning[$key] ?? 0;
            $jumlah_total_lelaki_cleaning += round((float)$lelaki,2);
            $this->jumlah_total_lelaki_cleaning = round($jumlah_total_lelaki_cleaning,2);
        }
    }

    public function calcTotalAllBayaranGajiPerempuanCleaning($key)   //jumlah total bayaran gaji pekerja perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_total_perempuan_cleaning = 0;
        $jumlah_total_perempuan_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $perempuan = $this->total_gaji_perempuan_cleaning[$key] ?? 0;
            $jumlah_total_perempuan_cleaning += round((float)$perempuan,2);
            $this->jumlah_total_perempuan_cleaning = round($jumlah_total_perempuan_cleaning,2);
        }
    }

    public function calcTotalAllBayaranGajiCleaning($key)   //jumlah total bayaran gaji pekerja lelaki + perempuan
    {
        $kategori_pekerja = KategoriGunaTenaga::get();
        $this->jumlah_total_gaji_cleaning = 0;
        $jumlah_total_gaji_cleaning = 0;
        foreach ($kategori_pekerja as $key => $data) {
            $total = $this->total_gaji_cleaning[$key] ?? 0;
            $jumlah_total_gaji_cleaning += round((float)$total,2);
            $this->jumlah_total_gaji_cleaning = round($jumlah_total_gaji_cleaning,2);
        }
    }


    public function render()
    {
        // dd($this->kilang_info);
        $id_shuttle = $this->kilang_info->id;

        // dd($id_shuttle);
        $formb = FormB::where('id', $this->kilang_info->id)->where('status', 'Dihantar ke IPJPSM')->first();
        // dd($formb);
        $kilang_info = Shuttle::where('id', $formb->shuttle_id)->first();
        // dd($kilang_info);
        $kategori_pekerja = KategoriGunaTenaga::get();

        $ulasan_phd = UlasanPhd::where('formbs_id', $formb->id)->get();
        // dd($ulasan_phd);

        $form_b = GunaTenaga::where('formbs_id',$formb->id)->get();
        // dd($form_b);
        return view('livewire.shuttle-three.data-cleaning3-b',compact('kilang_info','kategori_pekerja','form_b','ulasan_phd','formb'));
    }

    public function update()
    {
        $user = auth()->user();

        // dd($user);
        $id_shuttle = $this->kilang_info->id;

        // dd($this->status);
        $formb = FormB::where('id', $this->kilang_info->id)->where('status', 'Dihantar ke IPJPSM')->first();

        $formb->status = "Lulus";
        $formb->save();

        // dd($formb->status);

        //ulasanIPJPSM-create

        UlasanIpjpsm::create([
            'ulasan' => $this->ulasan_ipjpsm,
            'user_id' => $user->id,
            'formbs_id' => $formb->id,
        ]);

        $formB = GunaTenaga::where('formbs_id', $formb->id)->get();
        foreach ($formB as $key => $data) {
            // dd($this->total_bumi_lelaki_cleaning);
           //ni baru tambah laporan
            if($this->pekerja_wargabumi_lelaki_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->pekerja_wargabumi_lelaki_laporan = $this->pekerja_wargabumi_lelaki_cleaning[$key];
                $data->save();
            }else{
                $data->pekerja_wargabumi_lelaki_laporan = $data->pekerja_wargabumi_lelaki;
                $data->save();
            }

            if($this->pekerja_wargabumi_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->pekerja_wargabumi_perempuan_laporan = $this->pekerja_wargabumi_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->pekerja_wargabumi_perempuan_laporan = $data->pekerja_wargabumi_perempuan;
                $data->save();
            }

            if($this->pekerja_bukan_wargabumi_lelaki_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->pekerja_bukan_wargabumi_lelaki_laporan = $this->pekerja_bukan_wargabumi_lelaki_cleaning[$key];
                $data->save();
            }else{
                $data->pekerja_bukan_wargabumi_lelaki_laporan = $data->pekerja_bukan_wargabumi_lelaki;
                $data->save();
            }

            if($this->pekerja_bukan_wargabumi_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->pekerja_bukan_wargabumi_perempuan_laporan = $this->pekerja_bukan_wargabumi_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->pekerja_bukan_wargabumi_perempuan_laporan = $data->pekerja_bukan_wargabumi_perempuan;
                $data->save();
            }

            if($this->pekerja_asing_lelaki_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->pekerja_asing_lelaki_laporan = $this->pekerja_asing_lelaki_cleaning[$key];
                $data->save();
            }else{
                $data->pekerja_asing_lelaki_laporan = $data->pekerja_asing_lelaki;
                $data->save();
            }

            if($this->pekerja_asing_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->pekerja_asing_perempuan_laporan = $this->pekerja_asing_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->pekerja_asing_perempuan_laporan = $data->pekerja_asing_perempuan;
                $data->save();
            }

            if($this->jumlah_lelaki_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->jumlah_lelaki_laporan = $this->jumlah_lelaki_cleaning[$key];
                $data->save();
            }else{
                $data->jumlah_lelaki_laporan = $data->jumlah_lelaki;
                $data->save();
            }

            if($this->jumlah_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->jumlah_perempuan_laporan = $this->jumlah_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->jumlah_perempuan_laporan = $data->jumlah_perempuan;
                $data->save();
            }

            if($this->jumlah_pekerja_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->jumlah_pekerja_laporan = $this->jumlah_pekerja_cleaning[$key];
                $data->save();
            }else{
                $data->jumlah_pekerja_laporan = $data->jumlah_pekerja;
                $data->save();
            }

            if($this->gaji_lelaki_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->gaji_lelaki_laporan = $this->gaji_lelaki_cleaning[$key];
                $data->save();
            }else{
                $data->gaji_lelaki_laporan = $data->gaji_lelaki;
                $data->save();
            }

            if($this->gaji_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->gaji_perempuan_laporan = $this->gaji_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->gaji_perempuan_laporan = $data->gaji_perempuan;
                $data->save();
            }
            if($this->gaji_lelaki_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->gaji_lelaki_perempuan_laporan = $this->gaji_lelaki_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->gaji_lelaki_perempuan_laporan = $data->gaji_lelaki_perempuan;
                $data->save();
            }

            if($this->total_gaji_lelaki_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->total_gaji_lelaki_laporan = $this->total_gaji_lelaki_cleaning[$key];
                $data->save();
            }else{
                $data->total_gaji_lelaki_laporan = $data->total_gaji_lelaki;
                $data->save();
            }

            if($this->total_gaji_perempuan_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->total_gaji_perempuan_laporan = $this->total_gaji_perempuan_cleaning[$key];
                $data->save();
            }else{
                $data->total_gaji_perempuan_laporan = $data->total_gaji_perempuan;
                $data->save();
            }

            if($this->total_gaji_cleaning[$key] ?? null){
                //if data cleaning inserted
                $data->total_gaji_laporan = $this->total_gaji_cleaning[$key];
                $data->save();
            }else{
                $data->total_gaji_laporan = $data->total_gaji;
                $data->save();
            }


            if($this->total_bumi_lelaki_cleaning == null){
                $data->total_bumi_lelaki_laporan = $data->total_bumi_lelaki;
                $data->save();
            }else{
                $data->total_bumi_lelaki_laporan = $this->total_bumi_lelaki_cleaning;
                $data->save();
            }

            if($this->total_bumi_perempuan_cleaning == null){
                $data->total_bumi_perempuan_laporan = $data->total_bumi_perempuan;
                $data->save();
            }else{
                $data->total_bumi_perempuan_laporan = $this->total_bumi_perempuan_cleaning;
                $data->save();
            }

            if($this->total_bukanbumi_lelaki_cleaning == null){
                $data->total_bukanbumi_lelaki_laporan = $data->total_bukanbumi_lelaki;
                $data->save();
            }else{
                $data->total_bukanbumi_lelaki_laporan = $this->total_bukanbumi_lelaki_cleaning;
                $data->save();
            }

            if($this->total_bukanbumi_perempuan_cleaning == null){
                $data->total_bukanbumi_perempuan_laporan = $data->total_bukanbumi_perempuan;
                $data->save();
            }else{
                $data->total_bukanbumi_perempuan_laporan = $this->total_bukanbumi_perempuan_cleaning;
                $data->save();
            }

            if($this->total_asing_lelaki_cleaning == null){
                $data->total_asing_lelaki_laporan = $data->total_asing_lelaki;
                $data->save();
            }else{
                $data->total_asing_lelaki_laporan = $this->total_asing_lelaki_cleaning;
                $data->save();
            }

            if($this->total_asing_perempuan_cleaning == null){
                $data->total_asing_perempuan_laporan = $data->total_asing_perempuan;
                $data->save();
            }else{
                $data->total_asing_perempuan_laporan = $this->total_asing_perempuan_cleaning;
                $data->save();
            }

            if($this->total_pekerja_lelaki_cleaning == null){
                $data->total_pekerja_lelaki_laporan = $data->total_pekerja_lelaki;
                $data->save();
            }else{
                $data->total_pekerja_lelaki_laporan = $this->total_pekerja_lelaki_cleaning;
                $data->save();
            }

            if($this->total_pekerja_perempuan_cleaning == null){
                $data->total_pekerja_perempuan_laporan = $data->total_pekerja_perempuan;
                $data->save();
            }else{
                $data->total_pekerja_perempuan_laporan = $this->total_pekerja_perempuan_cleaning;
                $data->save();
            }
//
            if($this->total_pekerja_cleaning == null){
                $data->total_pekerja_laporan = $data->total_pekerja;
                $data->save();
            }else{
                $data->total_pekerja_laporan = $this->total_pekerja_cleaning;
                $data->save();
            }

            if($this->jumlah_gaji_lelaki_cleaning == null){
                $data->jumlah_gaji_lelaki_laporan = $data->jumlah_gaji_lelaki;
                $data->save();
            }else{
                $data->jumlah_gaji_lelaki_laporan = $this->jumlah_gaji_lelaki_cleaning;
                $data->save();
            }

            if($this->jumlah_gaji_perempuan_cleaning == null){
                $data->jumlah_gaji_perempuan_laporan = $data->jumlah_gaji_perempuan;
                $data->save();
            }else{
                $data->jumlah_gaji_perempuan_laporan = $this->jumlah_gaji_perempuan_cleaning;
                $data->save();
            }

            if($this->jumlah_lelaki_perempuan_cleaning == null){
                $data->jumlah_lelaki_perempuan_laporan = $data->jumlah_lelaki_perempuan;
                $data->save();
            }else{
                $data->jumlah_lelaki_perempuan_laporan = $this->jumlah_lelaki_perempuan_cleaning;
                $data->save();
            }

            if($this->jumlah_total_lelaki_cleaning == null){
                $data->jumlah_total_lelaki_laporan = $data->jumlah_total_lelaki;
                $data->save();
            }else{
                $data->jumlah_total_lelaki_laporan = $this->jumlah_total_lelaki_cleaning;
                $data->save();
            }

            if($this->jumlah_total_perempuan_cleaning == null){
                $data->jumlah_total_perempuan_laporan = $data->jumlah_total_perempuan;
                $data->save();
            }else{
                $data->jumlah_total_perempuan_laporan = $this->jumlah_total_perempuan_cleaning;
                $data->save();
            }

            if($this->jumlah_total_gaji_cleaning == null){
                $data->jumlah_total_gaji_laporan = $data->jumlah_total_gaji;
                $data->save();
            }else{
                $data->jumlah_total_gaji_laporan = $this->jumlah_total_gaji_cleaning;
                $data->save();
            }

            $data->update([
                'pekerja_wargabumi_lelaki_cleaning' => $this->pekerja_wargabumi_lelaki_cleaning[$key] ?? 0,
                'pekerja_wargabumi_perempuan_cleaning' => $this->pekerja_wargabumi_perempuan_cleaning[$key] ?? 0,
                'pekerja_bukan_wargabumi_lelaki_cleaning' => $this->pekerja_bukan_wargabumi_lelaki_cleaning[$key] ?? 0,
                'pekerja_bukan_wargabumi_perempuan_cleaning' => $this->pekerja_bukan_wargabumi_perempuan_cleaning[$key] ?? 0,
                'pekerja_asing_lelaki_cleaning' => $this->pekerja_asing_lelaki_cleaning[$key] ?? 0,
                'pekerja_asing_perempuan_cleaning' => $this->pekerja_asing_perempuan_cleaning[$key] ?? 0,
                'jumlah_lelaki_cleaning' => $this->jumlah_lelaki_cleaning[$key] ?? 0,
                'jumlah_perempuan_cleaning' => $this->jumlah_perempuan_cleaning[$key] ?? 0,
                'jumlah_pekerja_cleaning' => $this->jumlah_pekerja_cleaning[$key] ?? 0,
                'gaji_lelaki_cleaning' => $this->gaji_lelaki_cleaning[$key] ?? 0,
                'gaji_perempuan_cleaning' => $this->gaji_perempuan_cleaning[$key] ?? 0,
                'total_gaji_lelaki_cleaning' => $this->total_gaji_lelaki_cleaning[$key] ?? 0,
                'total_gaji_perempuan_cleaning' => $this->total_gaji_perempuan_cleaning[$key] ?? 0,
                'total_gaji_cleaning' => $this->total_gaji_cleaning[$key] ?? 0,
                'gaji_lelaki_perempuan_cleaning'  => $this->gaji_lelaki_perempuan_cleaning[$key] ?? 0,

                'total_bumi_lelaki_cleaning'  => $this->total_bumi_lelaki_cleaning ?? 0,
                'total_bumi_perempuan_cleaning'  => $this->total_bumi_perempuan_cleaning ?? 0,
                'total_bukanbumi_lelaki_cleaning' => $this->total_bukanbumi_lelaki_cleaning ?? 0,
                'total_bukanbumi_perempuan_cleaning' => $this->total_bukanbumi_perempuan_cleaning ?? 0,
                'total_asing_lelaki_cleaning' => $this->total_asing_lelaki_cleaning ?? 0,
                'total_asing_perempuan_cleaning' => $this->total_asing_perempuan_cleaning ?? 0,
                'total_pekerja_lelaki_cleaning' => $this->total_pekerja_lelaki_cleaning ?? 0,
                'total_pekerja_perempuan_cleaning' => $this->total_pekerja_perempuan_cleaning ?? 0,
                'total_pekerja_cleaning' => $this->total_pekerja_cleaning ?? 0,
                'jumlah_gaji_lelaki_cleaning' => $this->jumlah_gaji_lelaki_cleaning ?? 0,
                'jumlah_gaji_perempuan_cleaning' => $this->jumlah_gaji_perempuan_cleaning ?? 0,
                'jumlah_lelaki_perempuan_cleaning' => $this->jumlah_lelaki_perempuan_cleaning ?? 0,
                'jumlah_total_lelaki_cleaning' => $this->jumlah_total_lelaki_cleaning ?? 0,
                'jumlah_total_perempuan_cleaning' => $this->jumlah_total_perempuan_cleaning ?? 0,
                'jumlah_total_gaji_cleaning' => $this->jumlah_total_gaji_cleaning ?? 0,
            ]);

            // dd($data->total_bumi_lelaki);





        }

        $kilang_info = Shuttle::where('id', $formb->shuttle_id)->first();
        if($kilang_info->shuttle_type == '3'){
            Session::flash('success', 'Maklumat pengesahan berjaya disimpan.');
            return redirect()->route('shuttle-3-listB', date('Y'));
        }
        elseif($kilang_info->shuttle_type == '4'){
            Session::flash('success', 'Maklumat pengesahan berjaya disimpan.');
            return redirect()->route('shuttle-4-listB', date('Y'));
        }

        elseif($kilang_info->shuttle_type == '5'){
            Session::flash('success', 'Maklumat pengesahan berjaya disimpan.');
            return redirect()->route('shuttle-5-listB', date('Y'));
        }

    }
}
