<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\HakMilik;
use App\Models\Negeri;
use App\Models\Shuttle;
use App\Models\TarafSyarikat;
use App\Models\Warganegara;
use Livewire\Component;

class FormA extends Component
{

    public $negeri,$daerah,$district,$poskod_kilang,$poskod_surat_menyurat,$alamat_kilang_poskod,$alamat_surat_menyurat_poskod ,$alamat_kilang_daerah, $alamat_surat_menyurat_daerah;
    public $tahun, $nama_kilang, $alamat_kilang_1, $alamat_kilang_2,$alamat_surat_menyurat_1,$alamat_surat_menyurat_2,$no_ssm,$langtitude_y,$longtitude_x,$daerah_id;
    public $no_telefon,$no_faks,$email,$website,$no_lesen,$tarikh_tubuh,$tarikh_operasi,$taraf_syarikat_catatan,$status_hak_milik,$status_warganegara,$nilai_harta,$catatan_1;

    public $daerah_readonly = true;
    public $poskod_kilang_readonly = true;
    public $poskod_surat_readonly = true;

    public function render()
    {
        $state = Negeri::distinct()->get('negeri');
        $this->district = Negeri::where('negeri',$this->negeri)->get()->unique('bandar');
        $district =$this->district;

        $this->poskod_kilang = Negeri::where('poskod',$this->alamat_kilang_poskod)->distinct()->get('bandar');
        $poskod_kilang =$this->poskod_kilang;

        $this->poskod_surat_menyurat = Negeri::where('poskod',$this->alamat_surat_menyurat_poskod)->distinct()->get('bandar');
        $poskod_surat_menyurat =$this->poskod_surat_menyurat;

        $taraf_sah_syarikat = TarafSyarikat::get();
        $hak_milik = HakMilik::get();
        $warganegara = Warganegara::get();


        return view('livewire.shuttle-five.form-a',compact('state','district','poskod_kilang','poskod_surat_menyurat','taraf_sah_syarikat','hak_milik','warganegara'));
    }

    public function mount()
    {
        $this->negeri = "";
        $this->daerah_id = "";
        $this->alamat_kilang_daerah = "";
        $this->alamat_surat_menyurat_daerah = "";
        $this->taraf_syarikat_catatan = "";
        $this->status_hak_milik = "";
        $this->status_warganegara = "";
        $this->catatan_1 = "";

    }

    protected $rules = [


        'tahun' => 'required|numeric',
        'nama_kilang' => 'required|string',
        'alamat_kilang_1' => 'required|string',
        'alamat_kilang_2' => 'nullable|string',
        'alamat_kilang_poskod' => 'required|string',
        'alamat_kilang_daerah' => 'required|string',
        'alamat_surat_menyurat_1'=> 'required|string',
        'alamat_surat_menyurat_2' => 'nullable|string',
        'alamat_surat_menyurat_poskod' => 'required|string',
        'no_ssm' => 'required|string',
        'longtitude_x' => 'required|string',
        'langtitude_y' => 'required|string',

        'no_telefon' => 'required|numeric',
        'no_faks' => 'required|numeric',
        'email' => 'required|email',
        'website' => 'required|string',
        'no_lesen' => 'required|string',
        'tarikh_tubuh' => 'required|date',
        'tarikh_operasi' => 'required|date',
        'taraf_syarikat_catatan' => 'required|string',
        'status_hak_milik' => 'required|string',
        'status_warganegara' => 'required|string',
        'nilai_harta' => 'required|numeric',
        'catatan_1' => 'required|string',
    ];

    // public function updated()                   //function called everytime user input
    // {
    //     $this->validate();
    // }

    public function loadDaerah($value){
        $this->negeri = $value;
        $this->district = Negeri::where('negeri',$this->negeri)->get()->unique('bandar');
        // dd($this->district);
        $this->daerah_readonly = false;
    }

    public function loadPoskodKilang($value){
        $this->poskod = $value;
        $this->district = Negeri::where('negeri',$this->poskod)->distinct()->get('bandar');
        $this->poskod_kilang_readonly = false;
    }

    public function loadPoskodSuratMenyurat($value){
        $this->poskod = $value;
        $this->district = Negeri::where('negeri',$this->poskod)->distinct()->get('bandar');
        $this->poskod_surat_readonly = false;
    }

    public function storeA(){
        $this->validate();
        $shuttle_type ="3";
        // dd($this);
        $shuttle3A = Shuttle::create([
            'shuttle_type'=> $shuttle_type,
            'tahun' => $this->tahun ?? null,
            'nama_kilang' => $this->nama_kilang ?? null,
            'alamat_kilang_1' => $this->alamat_kilang_1 ?? null,
            'alamat_kilang_2' => $this->alamat_kilang_2 ?? null,
            'alamat_kilang_poskod' => $this->alamat_kilang_poskod ?? null,
            'alamat_surat_menyurat_1'=> $this->alamat_surat_menyurat_1 ?? null,
            'alamat_surat_menyurat_2' => $this->alamat_surat_menyurat_2 ?? null,
            'alamat_surat_menyurat_poskod' => $this->alamat_surat_menyurat_poskod ?? null,
            'no_ssm' => $this->no_ssm ?? null,
            'longtitude_x' => $this->longtitude_x ?? null,
            'langtitude_y' => $this->langtitude_y ?? null,
            'daerah_id' => $this->daerah_id ?? null,

            'no_telefon' => $this->no_telefon ?? null,
            'no_faks' => $this->no_faks ?? null,
            'email' => $this->email ?? null,
            'website' => $this->website ?? null,
            'no_lesen' => $this->no_lesen ?? null,
            'tarikh_tubuh' => $this->tarikh_tubuh ?? null,
            'tarikh_operasi' => $this->tarikh_operasi ?? null,
            'taraf_syarikat_catatan' => $this->taraf_syarikat_catatan ?? null,
            'status_hak_milik' => $this->status_hak_milik ?? null,
            'status_warganegara' => $this->status_warganegara ?? null,
            'nilai_harta' => $this->nilai_harta ?? null,
            'catatan_1' => $this->catatan_1 ?? null,



        ]);
        $this->resetInputFields();
        session()->flash('success', 'Maklumat Borang 3A Berjaya Ditambah.');
        return redirect()->route('shuttle-3');

    }

    private function resetInputFields(){
        $this->shuttle_type = null;
        $this->tahun = null;
        $this->nama_kilang = null;
        $this->alamat_kilang_1 = null;
        $this->alamat_kilang_2 = null;
        $this->alamat_kilang_poskod = null;
        $this->alamat_surat_menyurat_1 = null;
        $this->alamat_surat_menyurat_2 = null;
        $this->alamat_surat_menyurat_poskod = null;
        $this->no_ssm =null;
        $this->longtitude_x = null;
        $this->langtitude_y = null;
        $this->daerah_id = null;

        $this->no_telefon = null;
        $this->no_faks = null;
        $this->email = null;
        $this->website = null;
        $this->no_lesen = null;
        $this->tarikh_tubuh = null;
        $this->tarikh_operasi = null;
        $this->taraf_syarikat_catatan = null;
        $this->status_hak_milik =null;
        $this->status_warganegara = null;
        $this->nilai_harta = null;
        $this->catatan_1 = null;

        $this->negeri = "0";
        $this->daerah = "0";
        $this->alamat_kilang_daerah = "0";
        $this->alamat_surat_menyurat_daerah = "0";
        $this->taraf_syarikat_catatan = "0";
        $this->status_hak_milik = "0";
        $this->status_warganegara = "0";
        $this->catatan_1 = "0";


    }
}
