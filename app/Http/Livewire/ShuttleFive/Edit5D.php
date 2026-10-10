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

        // Map saved rows by product type (not by row position), in the same order store() saves them,
        // so a product's figure always lands on its own input
        $form5_d = PengeluaranForm5D::where('form5ds_id',$form5d->id)->orderBy('id')->get()->keyBy('jenis_kayu_id');

        foreach (JenisKayu::get() as $key => $jenis) {
            $value = $form5_d->get($jenis->id);
            $this->pengeluaran_kayu[$key] = $value ? $value->pengeluaran_kayu : null;
            $this->catatan[$key] = $value ? $value->catatan : null;
            if ($value) {
                $this->total_jumlah_pengeluaran = $value->total_jumlah_pengeluaran;
            }
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

        // Same rule as the new-form page (FormD::store): the product breakdown must add up to the
        // moulding output declared in the same month's Borang 5C. Without it a corrected 5C and its
        // 5D drifted apart (Laporan 33 vs Borang 5C).
        $total = 0;
        foreach ($this->pengeluaran_kayu ?? [] as $val) {
            $total += (float) $val;
        }
        $this->total_jumlah_pengeluaran = round($total, 2);

        $formc = \App\Models\FormC::where('shuttle_id', $formd->shuttle_id)->where('tahun', $formd->tahun)->where('bulan', $formd->bulan)->first();

        // 5D is checked against the 5C output, so 5C must be corrected and re-submitted first;
        // otherwise a reopened 5D could be saved against the old (often 0) output
        if (!$formc || !in_array($formc->status, \App\Services\FormFlowService::SUBMITTED, true)) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Sila lengkapkan dan hantar semula Borang 5C bulan ini terlebih dahulu sebelum mengemaskini Borang 5D.']);
            return back();
        }

        $pengeluaran_5c = round((float) \App\Models\KemasukanBahan::where('formcs_id', $formc->id)->sum('proses_keluar'), 2);
        if ($this->total_jumlah_pengeluaran != $pengeluaran_5c) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Jumlah Pengeluaran Kayu Kumai Mestilah Sama Dengan Jumlah Pengeluaran Di Borang 5C (' . $pengeluaran_5c . ')']);
            return back();
        }

        $total = $this->total_jumlah_pengeluaran;

        // form, package flag and product rows are saved as one unit, so a double submit
        // cannot leave duplicated or missing product rows
        \Illuminate\Support\Facades\DB::transaction(function () use ($formd, $jenis_kayu, $total) {
            $formd->total_jumlah_pengeluaran = $total;
            $formd->status = 'Sedang Diproses';
            $formd->save();

            $batch = Batch::where('tahun',$formd->tahun)->where('bulan',$formd->bulan)->where('shuttle_id',$formd->shuttle_id)->first();
            if ($batch) {
                $batch->status = "Sedang Diproses";
                $batch->borang_d = 1;
                $batch->save();
            }

            PengeluaranForm5D::where('form5ds_id', $formd->id)->delete();

            foreach ($jenis_kayu as $key => $data) {
                // the stored label is "E. Lain-lain Profil Kumai ..." - match on the name, not the full label
                $data_catatan = stripos($data->keterangan, 'Lain-lain') !== false ? ($this->catatan[$key] ?? null) : "Tiada";

                PengeluaranForm5D::create([
                    'form5ds_id'=>$formd->id,
                    'jenis_kayu_id' => $data->id,
                    'catatan' => $data_catatan,
                    'pengeluaran_kayu' => $this->pengeluaran_kayu[$key] ?? null,
                    'total_jumlah_pengeluaran'=>$total,
                ]);
            }
        });
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }
}
