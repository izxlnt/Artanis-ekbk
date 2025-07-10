<?php

namespace App\Http\Livewire\ShuttleFour;

use App\Models\Batch;
use App\Models\Form4E;
use App\Models\Pembeli;
use App\Models\Penjualan;
use App\Models\PenjualanPembeli;
use App\Models\Shuttle;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormE extends Component
{
    public $bulan_id, $bulan;
    public $total_export;
    public $jumlah_jualan, $total_jumlah_jualan, $catatan, $jumlah_pasaran_tempatan, $jumlah_venier_eksport, $jumlah_venier_tempatan;

    public function render()
    {
        if ($this->bulan_id ==  '1') {
            $this->bulan = "Januari";
        } else if ($this->bulan_id ==  '2') {
            $this->bulan = "Februari";
        } else if ($this->bulan_id ==  '3') {
            $this->bulan = "Mac";
        } else if ($this->bulan_id ==  '4') {
            $this->bulan = "April";
        } else if ($this->bulan_id ==  '5') {
            $this->bulan = "Mei";
        } else if ($this->bulan_id ==  '6') {
            $this->bulan = "Jun";
        } else if ($this->bulan_id ==  '7') {
            $this->bulan = "Julai";
        } else if ($this->bulan_id ==  '8') {
            $this->bulan = "Ogos";
        } else if ($this->bulan_id ==  '9') {
            $this->bulan = "September";
        } else if ($this->bulan_id ==  '10') {
            $this->bulan = "Oktober";
        } else if ($this->bulan_id ==  '11') {
            $this->bulan = "November";
        } else if ($this->bulan_id ==  '12') {
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
        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
        // dd($kilang_info);
        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();

        return view('livewire.shuttle-four.form-e', compact('jenis_pembeli', 'kilang_info', 'returnArr'));
    }

    public function mount()
    {
        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();

        foreach ($jenis_pembeli as $key => $data) {
            $this->jumlah_jualan[$key] = 0.00;
        }
    }

    public function updated($name, $value)
    {
        if ($value == ''){
            data_set($this, $name, 0);
        }
    }

    public function store()
    {
        $jenis_pembeli = Pembeli::where('shuttle', 4)->get();

        $this->validate([
            'total_export' => 'required',
            // 'jumlah_pasaran_tempatan' => 'required',
            'jumlah_venier_eksport' => 'required',
            'jumlah_venier_tempatan' => 'required',
        ]);

        if ($this->jumlah_jualan) {
            foreach ($jenis_pembeli as $key => $data) {
                $this->validate([
                    'jumlah_jualan.' . $key => 'required|numeric',
                ]);
            }
        } else {
            $this->validate([
                'jumlah_jualan' => 'required',
            ]);
        }


        $shuttle_id = Shuttle::first();



        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();
        $status = 'Sedang Diproses';
        // dd($shuttle_id);


        // $form4es = Form4E::create([
        //     'shuttle_id'=>$shuttle_id->id,
        //     'shuttle_type'=>$shuttle_id->shuttle_type,
        //     'tahun' => $kilang_info->tahun,
        //     'bulan' => now()->month,
        //     'nama_kilang' => $kilang_info->nama_kilang,
        //     'no_ssm' => $kilang_info->no_ssm,
        //     'no_lesen' => $kilang_info->no_lesen,
        //     'total_export' => $this->total_export,
        //     'jumlah_pasaran_tempatan' => $this->jumlah_pasaran_tempatan,
        //     'jumlah_venier_eksport' => $this->jumlah_venier_eksport,
        //     'jumlah_venier_tempatan' => $this->jumlah_venier_tempatan,
        //     'status' => $status,
        //     'status_catatan' => '0',
        // ]);

        if ($this->bulan ==  'Januari') {
            $this->bulan_id = "1";
        } else if ($this->bulan ==  'Februari') {
            $this->bulan_id = "2";
        } else if ($this->bulan ==  'Mac') {
            $this->bulan_id = "3";
        } else if ($this->bulan ==  'April') {
            $this->bulan_id = "4";
        } else if ($this->bulan ==  'Mei') {
            $this->bulan_id = "5";
        } else if ($this->bulan ==  'Jun') {
            $this->bulan_id = "6";
        } else if ($this->bulan ==  'Julai') {
            $this->bulan_id = "7";
        } else if ($this->bulan ==  'Ogos') {
            $this->bulan_id = "8";
        } else if ($this->bulan ==  'September') {
            $this->bulan_id = "9";
        } else if ($this->bulan ==  'Oktober') {
            $this->bulan_id = "10";
        } else if ($this->bulan ==  'November') {
            $this->bulan_id = "11";
        } else if ($this->bulan ==  'Disember') {
            $this->bulan_id = "12";
        }

        $user = auth()->user();

        $forme = Form4E::where('shuttle_id', $user->shuttle_id)->where('bulan', $this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $forme->total_export = $this->total_export;
        $forme->jumlah_pasaran_tempatan = $this->jumlah_pasaran_tempatan;
        $forme->jumlah_venier_eksport = $this->jumlah_venier_eksport;
        $forme->jumlah_venier_tempatan = $this->jumlah_venier_tempatan;
        $forme->status = 'Sedang Diproses';
        $forme->save();

        $batch = Batch::where('tahun', $forme->tahun)->where('bulan', $forme->bulan)->where('shuttle_id', $forme->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_e = 1;
        $batch->save();


        $catatan = "Tiada";
        foreach ($jenis_pembeli as $key => $data) {
            if ($data->keterangan == 'Lain-lain (Nyatakan)') {
                $data_catatan = $this->catatan[$key] ?? $catatan;
            } else {
                $data_catatan = "Tiada";
            }
            PenjualanPembeli::create([
                'form4es_id' => $forme->id,
                'pembeli_id' => $data->id,
                'catatan' => $data_catatan,
                'jumlah_jualan' => $this->jumlah_jualan[$key] ?? 0,
                'total_jumlah_jualan' => $this->total_jumlah_jualan
            ]);
        }

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
    public function calcTotalJumlahJualan()
    {
        $this->total_jumlah_jualan = 0.00;
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
}
