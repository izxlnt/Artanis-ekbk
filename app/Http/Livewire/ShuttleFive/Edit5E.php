<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\Batch;
use App\Models\Form5E;
use App\Models\PenjualanKumai;
use App\Models\Shuttle;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Edit5E extends Component
{
    public $shuttle_id;
    public $bulan_id,$bulan,$ulasan_phd,$form_5e_id;
    public $jumlah_jualan_pasaran_tempatan,$jumlah_jualan_eksport;
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
            ['link' => route('user.shuttle-5-senaraiE', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "Borang 5E - PENYATA PENJUALAN"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $id = auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();
        // dd($this->shuttle_id);
        $id_shuttle =$this->shuttle_id;
        $form5_id = Form5E::findorfail($this->form_5e_id);
        // dd($form5_id);


        $ulasan_phd = $this->ulasan_phd;


        return view('livewire.shuttle-five.edit5-e',compact('kilang_info','returnArr','ulasan_phd','form5_id'));
    }

    public function loadData(){

        $id=auth()->user();

        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();


        $form5d =  Form5E::findorfail($this->form_5e_id);
        // dd($form5d);

        // foreach ($form5d as $key => $value) {
            $this->jumlah_jualan_pasaran_tempatan = $form5d->jumlah_jualan_pasaran_tempatan;
            $this->jumlah_jualan_eksport = $form5d->jumlah_jualan_eksport;

        // }
    }

    public function store()
    {

        if($this->bulan ==  'Januari'){
            $this->bulan_id = "1";
        }else if($this->bulan ==  'Februari'){
            $this->bulan_id = "2";
        }else if($this->bulan ==  'Mac'){
            $this->bulan_id = "3";
        }else if($this->bulan ==  'April'){
            $this->bulan_id = "4";
        }
        else if($this->bulan ==  'Mei'){
            $this->bulan_id = "5";
        }
        else if($this->bulan ==  'Jun'){
            $this->bulan_id = "6";
        }
        else if($this->bulan ==  'Julai'){
            $this->bulan_id = "7";
        }
        else if($this->bulan ==  'Ogos'){
            $this->bulan_id = "8";
        }
        else if($this->bulan ==  'September'){
            $this->bulan_id = "9";
        }
        else if($this->bulan ==  'Oktober'){
            $this->bulan_id = "10";
        }
        else if($this->bulan ==  'November'){
            $this->bulan_id = "11";
        }
        else if($this->bulan ==  'Disember'){
            $this->bulan_id = "12";
        }

        $user = auth()->user();

        $forme = Form5E::where('shuttle_id',$user->shuttle_id)->where('bulan',$this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $forme->jumlah_jualan_pasaran_tempatan = $this->jumlah_jualan_pasaran_tempatan;
        $forme->jumlah_jualan_eksport = $this->jumlah_jualan_eksport;


        $forme->status = 'Sedang Diproses';
        $forme->save();

        $batch = Batch::where('tahun',$forme->tahun)->where('bulan',$forme->bulan)->where('shuttle_id',$forme->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_e = 1;
        $batch->save();



        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }


}
