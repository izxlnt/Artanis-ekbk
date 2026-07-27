<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\Batch;
use App\Models\Form5D;
use App\Models\JenisKayu;
use App\Models\KemasukanBahan;
use App\Models\PengeluaranForm5D;
use App\Models\PengeluaranKumai;
use App\Models\Shuttle;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use App\Services\FormFlowService;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormD extends Component
{
    public $bulan_id,$bulan,$form_c_data;
    public $pengeluaran_kayu,$total_jumlah_pengeluaran,$catatan,$total;
    public $kemasukan_bahan_calc_lain_lain;

    public function mount()
    {
        $this->kemasukan_bahan_calc_lain_lain = $this->form_c_data
            ? (float) KemasukanBahan::where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $this->form_c_data->id)->sum('proses_keluar')
            : 0;

        $formd = FormFlowService::findFormD(auth()->user()->shuttle_id, 5, date("Y"), $this->bulan_id);

        if ($formd && $formd->status === 'Tidak Lengkap') {
            $this->total_jumlah_pengeluaran = $formd->total_jumlah_pengeluaran;

            $jenis_kayu = JenisKayu::get();
            $existing = PengeluaranForm5D::where('form5ds_id', $formd->id)->get()->keyBy('jenis_kayu_id');

            foreach ($jenis_kayu as $key => $jenis) {
                $record = $existing->get($jenis->id);
                $this->pengeluaran_kayu[$key] = $record ? $record->pengeluaran_kayu : null;
                $this->catatan[$key] = $record ? $record->catatan : null;
            }
        }
    }

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
            ['link' => route('user.shuttle-5-formD', [date('Y'), $this->bulan_id]), 'name' => "Borang 5D"],
        ];

        $kembali = route('user.shuttle-5-senaraiD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('livewire.shuttle-five.form-d',compact('jenis_kumai','kilang_info','returnArr'));
    }

    public function calcTotalJumlahPengeluaranKayu()
    {
        $this->total_jumlah_pengeluaran = 0;
        $total_jumlah_pengeluaran = 0;

        foreach ($this->pengeluaran_kayu as $data) {
            if (empty($data)) {
                $data = 0;
            }
            $total_jumlah_pengeluaran += $data;
            $this->total_jumlah_pengeluaran = round($total_jumlah_pengeluaran,2);
        }
    }

    public function store()
    {
        $total = 0;
        foreach ($this->pengeluaran_kayu ?? [] as $val) {
            $total += (float) $val;
        }
        $this->total_jumlah_pengeluaran = round($total, 2);

        if(round($this->total_jumlah_pengeluaran, 2) != round($this->kemasukan_bahan_calc_lain_lain, 2)){
            $this->emit('alert', ['type' => 'error', 'message' => 'Jumlah Pengeluaran Kayu Kumai Mestilah Sama Dengan Jumlah Pengeluaran Di Borang 5C (' . $this->kemasukan_bahan_calc_lain_lain . ')']);
            return back();
        }

        $jenis_kayu = JenisKayu::get();

        $shuttle_id = Shuttle::first();


        $user=auth()->user();
        // $kilang_info = Shuttle::where('id',$user->shuttle_id)->first();
        // $status= 'Sedang Diproses';

        $formd = FormFlowService::findFormD($user->shuttle_id, 5, date("Y"), $this->bulan_id);


        $formd->total_jumlah_pengeluaran = $this->total_jumlah_pengeluaran;

        $formd->status = 'Sedang Diproses';
        $formd->save();

        //batch
        $batch = Batch::firstOrNew(['tahun' => $formd->tahun, 'bulan' => $formd->bulan, 'shuttle_id' => $formd->shuttle->id]);

        $batch->status = "Sedang Diproses";
        $batch->borang_d = 1;
        $batch->save();


        // dd($test);
        $total = $this->total_jumlah_pengeluaran;
        // dd($total);

        PengeluaranForm5D::where('form5ds_id', $formd->id)->delete();

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
                'total_jumlah_pengeluaran'=>$this->total_jumlah_pengeluaran
            ]);
        // dd('masuk');


        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }

    public function tiadaPengeluaran()
    {
        $jenis_kayu = JenisKayu::get();

        $shuttle_id = Shuttle::first();


        $user=auth()->user();
        // $kilang_info = Shuttle::where('id',$user->shuttle_id)->first();
        // $status= 'Sedang Diproses';

        $formd = FormFlowService::findFormD($user->shuttle_id, 5, date("Y"), $this->bulan_id);


        $formd->total_jumlah_pengeluaran = 0;

        $formd->status = 'Tiada Pengeluaran';
        $formd->tiada_pengeluaran = 1;
        $formd->save();

        //batch
        $batch = Batch::firstOrNew(['tahun' => $formd->tahun, 'bulan' => $formd->bulan, 'shuttle_id' => $formd->shuttle->id]);

        $batch->status = "Sedang Diproses";
        $batch->borang_d = 1;
        $batch->save();


        // dd($test);
        $total = $this->total_jumlah_pengeluaran;
        // dd($total);

        PengeluaranForm5D::where('form5ds_id', $formd->id)->delete();

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
                'pengeluaran_kayu' => 0 ?? 0,
            ]);
        // dd('masuk');


        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where('kategori_pengguna', 'PHD')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formd))->delay($delay));
        }

        return redirect()->route('home-user');
    }
}
