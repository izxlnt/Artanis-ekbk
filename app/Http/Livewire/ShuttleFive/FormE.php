<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\Batch;
use App\Models\Form5E;
use App\Models\PenjualanKumai;
use App\Models\Shuttle;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormE extends Component
{
    public $bulan_id,$bulan;
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
            ['link' => route('user.shuttle-5-senaraiA', date('Y')), 'name' => "Borang 5E"],
        ];

        $kembali = route('user.shuttle-5-senaraiE', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();


        return view('livewire.shuttle-five.form-e',compact('kilang_info','returnArr'));
    }

    public function mount()
    {
            $this->jumlah_jualan_pasaran_tempatan = 0.00;
            $this->jumlah_jualan_eksport = 0.00;

    }

    public function updated($name, $value)
    {
        if ($value == ''){
            data_set($this, $name, 0);
        }
    }


    public function store()
    {
        $this->validate([
            'jumlah_jualan_pasaran_tempatan' => 'required',
            'jumlah_jualan_eksport' => 'required',
        ]);

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

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where('kategori_pengguna', 'PHD')->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $forme))->delay($delay));
        }

        return redirect()->route('home-user');
    }


}
