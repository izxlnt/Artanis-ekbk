<?php

namespace App\Http\Livewire\ShuttleFour;

use App\Models\Batch;
use App\Models\Form4E;
use App\Models\Pembeli;
use App\Models\Penjualan;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use App\Models\UlasanPhd;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Editform4e extends Component
{
    public $shuttle_id;

    public $bulan_id,$bulan;
    public $total_export, $jumlah_jualan, $total_jumlah_jualan,$catatan,$jumlah_pasaran_tempatan,$jumlah_venier_eksport,$jumlah_venier_tempatan;

    public function render()
    {
        if($this->bulan_id ==  '1'){
            $this->bulan = "Januari";
        }else if($this->bulan_id ==  '2'){
            $this->bulan = "Februari";
        }else if($this->bulan_id ==  '3'){
            $this->bulan = "Mac";
        }else if($this->bulan_id ==  '4'){
            $this->bulan = "April";
        }
        else if($this->bulan_id ==  '5'){
            $this->bulan = "Mei";
        }
        else if($this->bulan_id ==  '6'){
            $this->bulan = "Jun";
        }
        else if($this->bulan_id ==  '7'){
            $this->bulan = "Julai";
        }
        else if($this->bulan_id ==  '8'){
            $this->bulan = "Ogos";
        }
        else if($this->bulan_id ==  '9'){
            $this->bulan = "September";
        }
        else if($this->bulan_id ==  '10'){
            $this->bulan = "Oktober";
        }
        else if($this->bulan_id ==  '11'){
            $this->bulan = "November";
        }
        else if($this->bulan_id ==  '12'){
            $this->bulan = "Disember";
        }


        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiE', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Borang 4E"],
        ];

        $kembali = route('user.shuttle-4-senaraiE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();
        $form4e_id = Form4E::findorfail($this->shuttle_id);

        $ulasan = UlasanPhd::where('form4es_id',$form4e_id->id)->latest('created_at')->first();




        // dd($form4e_id);
        $jenis_pembeli = Pembeli::where('shuttle',4)->get();
        return view('livewire.shuttle-four.editform4e',compact('jenis_pembeli','kilang_info','returnArr','ulasan','form4e_id'));
    }

    public function loadData(){

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();
        $id=auth()->user();

        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();


        $form4e = Form4E::where('id',$this->shuttle_id)->first();

// dd($form4e);

        $id =$form4e->id;

        $form4_e = PenjualanPembeli::where('form4es_id',$form4e->id)->get();

        $this->total_export = $form4e->total_export ??0;
        $this->bulan = $form4e->bulan;

        $this->jumlah_pasaran_tempatan = $form4e->jumlah_pasaran_tempatan ?? 0;
        $this->jumlah_venier_eksport = $form4e->jumlah_venier_eksport ??0 ;
        $this->jumlah_venier_tempatan = $form4e->jumlah_venier_tempatan ?? 0;

        foreach ($form4_e as $key => $value) {
            $this->jumlah_jualan[$key] = $value->jumlah_jualan ?? 0;
            $this->total_jumlah_jualan = number_format($value->total_jumlah_jualan ?? 0, 2, '.', '');
            // dd($this->total_jumlah_jualan);

            // $this->catatan[$key] = $this->catatan ;
            $this->catatan[$key] = $value->catatan ?? "Tiada Catatan";

        }


    }

    public function calcTotalJumlahJualan()
    {
        $this->total_jumlah_jualan = 0.00;
        $total_jumlah_jualan = 0;

        foreach ($this->jumlah_jualan as $data) {
            if (empty($data)) {
                $data = 0;
            }
            $total_jumlah_jualan += (float)$data;

            // dd($total_jumlah_jualan);

            $this->total_jumlah_jualan = number_format((float)$total_jumlah_jualan, 2, '.', '');
        }

        $this->calcTotalJumlahPasaranTempatan();
    }

    public function calcTotalJumlahPasaranTempatan()
    {
        $this->jumlah_pasaran_tempatan = 0.00;
        $jumlah_pasaran_tempatan = 0;

        foreach ($this->jumlah_jualan as $data) {
            if (empty($data)) {
                $data = 0;
            }
        $jumlah_pasaran_tempatan += (float)$data;

        $this->jumlah_pasaran_tempatan = number_format((float)$jumlah_pasaran_tempatan, 2, '.', '');
        }
    }

    public function update()
    {

        $id=auth()->user();

        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();


        $form4e = Form4E::where('id',$this->shuttle_id)->first();



        $id =$form4e->id;



        // foreach ($form4e as $key => $value) {
        //    $value->delete();
        // }

        // $idForm->delete();

        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();


        // $shuttle_id = Shuttle::first();

        $id=auth()->user();
        $shuttle_id = Shuttle::where('id',$id->shuttle_id)->first();
        $status= 'Sedang Diproses';

            $form4e->total_export = $this->total_export;
            $form4e->jumlah_pasaran_tempatan = $this->jumlah_pasaran_tempatan;
            $form4e->jumlah_venier_eksport = $this->jumlah_venier_eksport;
            $form4e->jumlah_venier_tempatan = $this->jumlah_venier_tempatan;
            $form4e->status = $status;
            $form4e->save();


        // $form4e->update([

        //     'total_export' => $this->total_export,
        //     'jumlah_pasaran_tempatan' => $this->jumlah_pasaran_tempatan,
        //     'jumlah_venier_eksport' => $this->jumlah_venier_eksport,
        //     'status' => $status,

        // ]);



    //     $status= 'Sedang Diproses';

    $form4e_id= Form4E::where('id',$this->shuttle_id)->first();


        // dd($formd_id);
    $form4e_id->status = $status;
    $form4e_id->save();

    $batch = Batch::where('tahun',$form4e_id->tahun)->where('bulan', $form4e_id->bulan)->where('shuttle_id', $form4e_id->shuttle_id)->first();
    $batch->borang_d = "1";
    $batch->save();

    $form4_e = PenjualanPembeli::where('form4es_id',$form4e_id->id)->get();
    // dd($form4_e);
    foreach ($form4_e as $data) {
        $data->delete();
    }

    $catatan="Tiada";
        foreach ($jenis_pembeli as $key => $data) {
            if($data->keterangan == 'Lain-lain (Nyatakan)'){
                $data_catatan= $this->catatan[$key] ?? $catatan;
            }
            else{
                $data_catatan= "Tiada";
            }
            PenjualanPembeli::create([
                'form4es_id'=>$form4e_id->id,
                'pembeli_id' => $data->id,
                'catatan' => $data_catatan,
                'jumlah_jualan' => $this->jumlah_jualan[$key],
                'total_jumlah_jualan' => $this->total_jumlah_jualan,
            ]);
        }


        // dd('masuk');

        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }
}
