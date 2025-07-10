<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Batch;
use App\Models\FormD;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use App\Models\UlasanPhd;
use Livewire\Component;
use Illuminate\Support\Facades\Session;


class EditForm3D extends Component
{
    public $shuttle_id;
    public $total_export, $jumlah_jualan, $total_jumlah_jualan,$catatan,$jumlah_pasaran_tempatan;
    public function render()
    {
        $formd_id = FormD::findorfail($this->shuttle_id);


        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        $kilang_info = Shuttle::where('id',$formd_id->id)->first();

        $ulasan = UlasanPhd::where('formds_id',$formd_id->id)->latest('created_at')->first();

        return view('livewire.shuttle-three.edit-form3-d', compact('jenis_pembeli','kilang_info','formd_id','ulasan'));
    }

    public function loadData(){

        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();
        $idForm= FormD::where('id',$this->shuttle_id)->first();
        // dd($idForm);
        $formD = PenjualanPembeli::where('formds_id',$this->shuttle_id)->get();

        // dd($formD[9]->catatan);
        // dd($idForm);

        $this->total_export=$idForm->total_export;
        $this->jumlah_pasaran_tempatan=$idForm->jumlah_pasaran_tempatan;

        foreach ($formD as $key => $value) {
            $this->jumlah_jualan[$key] = $value->jumlah_jualan;
            $this->total_jumlah_jualan = $value->total_jumlah_jualan;

            // $this->catatan[$key] = $this->catatan ;
            $this->catatan[$key] = $value->catatan;

        }
        // dd($this->catatan);

    }

    public function calcTotalJumlahJualan()
    {
        $total_jumlah_jualan = 0;

        foreach ($this->jumlah_jualan as $data) {
            if (empty($data)) {
                $data = 0;
            }
            $total_jumlah_jualan += (float)$data;

        $this->total_jumlah_jualan = number_format((float)$total_jumlah_jualan, 2, '.', '');

        }




        $this->calcTotalJumlahPasaranTempatan();
    }

    public function calcTotalJumlahPasaranTempatan()
    {
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
        $idForm= FormD::where('id',$this->shuttle_id)->first();

        // dd($idForm);

        $formD = PenjualanPembeli::where('formds_id',$idForm->id)->get();
        foreach ($formD as $key => $value) {
           $value->delete();
        }

        // $idForm->delete();

        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        // $shuttle_id = Shuttle::first();

        $id=auth()->user();
        $shuttle_id = Shuttle::where('id',$id->shuttle_id)->first();
        $status= 'Sedang Diproses';


        $idForm->update([

            'total_export' => $this->total_export ?? 0,
            'jumlah_pasaran_tempatan' => $this->jumlah_pasaran_tempatan ?? 0,
            'status' => $status,

        ]);

    //     $status= 'Sedang Diproses';

    $formd_id= FormD::where('id',$this->shuttle_id)->first();


        // dd($formd_id);
    $formd_id->status = $status;
    $formd_id->save();

    $batch = Batch::where('tahun',$formd_id->tahun)->where('bulan', $formd_id->bulan)->where('shuttle_id', $formd_id->shuttle_id)->first();
    $batch->borang_d = "1";
    $batch->save();

        // dd($test);

        foreach ($jenis_pembeli as $key => $data) {
            if($data->keterangan == 'Sektor awam (Nyatakan)'){
                $data_catatan= $this->catatan[$key];
            }
            elseif($data->keterangan == 'Lain-lain (Nyatakan)'){
                $data_catatan= $this->catatan[$key];
            }
            else{
                $data_catatan= "Tiada";
            }

            PenjualanPembeli::create([
                'formds_id'=>$idForm->id,
                'pembeli_id' => $data->id,
                'catatan' => $data_catatan,
                'jumlah_jualan' => $this->jumlah_jualan[$key] ?? 0,
                'total_jumlah_jualan' => $this->total_jumlah_jualan ?? 0,
            ]);
        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }
}
