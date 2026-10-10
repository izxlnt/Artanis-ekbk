<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Batch;
use App\Models\FormD;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use App\Models\UlasanPhd;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
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
        $this->total_export=$idForm->total_export;

        // Map saved rows by buyer type (not by row position), so a buyer's figure always lands on
        // its own input even if rows were saved out of order or duplicated
        $existing = PenjualanPembeli::where('formds_id', $this->shuttle_id)->orderBy('id')->get()->keyBy('pembeli_id');
        foreach (Pembeli::where('shuttle', 3)->get() as $key => $pembeli) {
            $record = $existing->get($pembeli->id);
            $this->jumlah_jualan[$key] = $record ? $record->jumlah_jualan : null;
            $this->catatan[$key] = $record ? $record->catatan : null;
        }

        $this->calcTotalJumlahJualan();
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

        // Totals are derived from the buyer rows on the server: the page only recalculates them when
        // a field changes, so an untouched correction used to resubmit a stale (often 0) total
        $total = 0;
        foreach ($this->jumlah_jualan ?? [] as $val) {
            $total += (float) $val;
        }
        $this->total_jumlah_jualan = number_format($total, 2, '.', '');
        $this->jumlah_pasaran_tempatan = number_format($total, 2, '.', '');

        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();

        // delete + re-insert as one unit, so a double submit cannot leave duplicated buyer rows
        DB::transaction(function () use ($idForm, $jenis_pembeli) {
        PenjualanPembeli::where('formds_id', $idForm->id)->delete();

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
    if ($batch) {
        $batch->borang_d = "1";
        $batch->save();
    }

        // dd($test);

        foreach ($jenis_pembeli as $key => $data) {
            if($data->keterangan == 'Sektor awam (Nyatakan)'){
                $data_catatan= $this->catatan[$key] ?? null;
            }
            elseif($data->keterangan == 'Lain-lain (Nyatakan)'){
                $data_catatan= $this->catatan[$key] ?? null;
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
        });
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }
}
