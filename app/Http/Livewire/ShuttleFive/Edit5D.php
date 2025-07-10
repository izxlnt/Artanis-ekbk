<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\Batch;
use App\Models\Form5D;
use App\Models\JenisKayu;
use App\Models\PengeluaranForm5D;
use App\Models\PengeluaranKumai;
use App\Models\Shuttle;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Edit5D extends Component
{
    public $bulan_id,$bulan;
    public $shuttle_id;
    public $pengeluaran_kayu,$total_jumlah_pengeluaran,$catatan,$total;

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
        $jenis_kumai = JenisKayu::get();
        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-5-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-5-formD', date('Y')), 'name' => "Borang 5D - PENYATA PENGELUARAN"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('livewire.shuttle-five.edit5-d',compact('jenis_kumai','kilang_info','returnArr'));
    }

    public function loadData(){

        $id=auth()->user();

        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();


        $form5d = Form5D::where('id',$this->bulan_id)->first();
        // dd($form5d);

        $form5_d = PengeluaranForm5D::where('form5ds_id',$form5d->id)->get();
        // dd($form5_d);

        foreach ($form5_d as $key => $value) {
            $this->pengeluaran_kayu[$key] = $value->pengeluaran_kayu;
            $this->catatan[$key] = $value->catatan;
            $this->total_jumlah_pengeluaran = $value->total_jumlah_pengeluaran;

        }


    }

    public function calcTotalJumlahPengeluaranKayu()
    {
        $this->total_jumlah_pengeluaran = 0;

        foreach ($this->pengeluaran_kayu as $data) {
            if (empty($data)) {
                $data = 0;
            }
            $this->total_jumlah_pengeluaran += $data;
        }
    }

    public function store()
    {
        $jenis_kayu = JenisKayu::get();

        $shuttle_id = Shuttle::first();


        $user=auth()->user();

        $kilang_info = Shuttle::where('id',$user->shuttle_id)->first();


        $formd = Form5D::where('id',$this->bulan_id)->first();
        $formd->total_jumlah_pengeluaran = $this->total_jumlah_pengeluaran;
        $formd->status = 'Sedang Diproses';
        $formd->save();

        //batch
        $batch = Batch::where('tahun',$formd->tahun)->where('bulan',$formd->bulan)->where('shuttle_id',$formd->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_d = 1;
        $batch->save();


        // dd($test);
        $total = $this->total_jumlah_pengeluaran;
        // dd($total);
        $form5_d = PengeluaranForm5D::where('form5ds_id',$formd->id)->get();
        foreach ($form5_d as $key => $value) {
            $value->delete();
        }
        foreach ($jenis_kayu as $key => $data) {
            if($data->keterangan == 'Lain-lain Profil Kumai (Other Moulding Profiles) (Nyatakan)'){
                $data_catatan= $this->catatan[$key] ?? null;
            }
            else{
                $data_catatan= "Tiada";
            }
            PengeluaranForm5D::create([
                'form5ds_id'=>$formd->id,
                'jenis_kayu_id' => $data->id,
                'catatan' => $data_catatan,
                'pengeluaran_kayu' => $this->pengeluaran_kayu[$key] ?? null,
                'total_jumlah_pengeluaran'=>$total,
            ]);
        // dd('masuk');


        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }
}
