<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Batch;
use App\Models\FormD as ModelsFormD;
use App\Models\Pembeli;
use App\Models\Penjualan;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormD extends Component
{
    public $bulan_id;
    public $total_export, $jumlah_jualan, $total_jumlah_jualan,$catatan,$jumlah_pasaran_tempatan,$bulan;
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
        $id=auth()->user();
        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();


        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-3-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-3-senaraiA', date('Y')), 'name' => "Borang 3D - PENYATA PENJUALAN"],
        ];

        $kembali = route('user.shuttle-3-senaraiD', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('livewire.shuttle-three.form-d', compact('jenis_pembeli','kilang_info','returnArr'));
    }

    public function calcTotalJumlahJualan()
    {
        $this->total_jumlah_jualan = 0.00;
        $decimal = 0.00;

        foreach ($this->jumlah_jualan as $data) {
            if (empty($data)) {
                $data = 0.00;
            }

            $decimal += number_format((float)$data,2,'.','');
        }
        // dd(number_format((float)$decimal,2,'.',''));
        $this->total_jumlah_jualan = number_format((float)$decimal,2,'.','');

        $this->calcTotalJumlahPasaranTempatan();
    }

    public function calcTotalJumlahPasaranTempatan()
    {
        $this->jumlah_pasaran_tempatan = 0;
        $point = 0.00;

        foreach ($this->jumlah_jualan as $data) {
            if (empty($data)) {
                $data = 0.00;
            }

            $point += number_format((float)$data,2,'.','');
        }
        // dd(number_format((float)$point,2,'.',''));

        $this->jumlah_pasaran_tempatan = number_format((float)$point,2,'.','');

    }

    public function store()
    {
        $shuttle_id = Shuttle::first();

        $jenis_pembeli = Pembeli::where('shuttle', 3)->get();


        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();
        $shuttle_id = Shuttle::where('id',$id->shuttle_id)->first();

        $status= 'Sedang Diproses';


        // $formds = ModelsFormD::create([
        //     'shuttle_id'=>$shuttle_id->id,
        //     'shuttle_type'=>$shuttle_id->shuttle_type,
        //     'tahun' => $kilang_info->tahun,
        //     'bulan' => $this->bulan,
        //     'nama_kilang' => $kilang_info->nama_kilang,
        //     'no_ssm' => $kilang_info->no_ssm,
        //     'no_lesen' => $kilang_info->no_lesen,
        //     'total_export' => $this->total_export,
        //     'jumlah_pasaran_tempatan' => $this->jumlah_pasaran_tempatan,
        //     'status' => $status,
        //     'status_catatan' => '0',
        // ]);

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
        // dd($this->suku_id);

        $formd = ModelsFormD::where('shuttle_id',$user->shuttle_id)->where('bulan',$this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $formd->total_export = $this->total_export ?? 0;
        $formd->jumlah_pasaran_tempatan = $this->jumlah_pasaran_tempatan ?? 0;
        $formd->status = 'Sedang Diproses';
        $formd->save();


        $batch = Batch::where('tahun',$formd->tahun)->where('bulan',$formd->bulan)->where('shuttle_id',$formd->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_d = 1;
        $batch->save();

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
                'formds_id'=>$formd->id ,
                'pembeli_id' => $data->id ,
                'catatan' => $data_catatan ?? null,
                'jumlah_jualan' => $this->jumlah_jualan[$key] ?? 0,
                'total_jumlah_jualan' => $this->total_jumlah_jualan ?? 0,
            ]);
        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where(
            'kategori_pengguna',
            'PHD'
        )->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formd))->delay($delay));
        }

        return redirect()->route('home-user');
    }
}
