<?php

namespace App\Http\Livewire\ShuttleFour;

use App\Models\Batch;
use App\Models\Form4D;
use App\Models\KemasukanBahan;
use App\Models\Pengeluaran;
use App\Models\ProdukPengeluaran;
use App\Models\Shuttle;
use App\Models\FormC as ModelsFormC;
use App\Models\RecoveryRate;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Editform4d extends Component
{
    public $inputs = [];
    public $inputs2 = [];
    public $i= 0;
    public $j= 0;
    public $bulan_id, $bulan, $kemasukan_bahan_calc_lain_lain;
    public $produk_ketebalan,$produk_isipadumr_a,$produk_isipaduwbp_a,$jumlah_mr,$junlah_wbp,$rekod_veniermuka,$rekod_venierteras,$jumlah_pengeluaran,$baki_stok,$jumlah_kecil_mr,
    $jumlah_wbp,$jumlah_kecil_1_mr,$jumlah_kecil_2_mr,$jumlah_kecil_1_wbp,$produk_isipadumr_b,$produk_isipaduwbp_b,$jumlah_kecil_2_wbp,$jumlah_besar_mr,$jumlah_besar_wbp,
    $produk_ketebalan_a,$produk_ketebalan_b;

    // public function updated()
    // {
    //     // if(isset($this->produk_isipadumr_a)){
    //     //     $this->count_product = count($this->produk_isipadumr_a);
    //     // }else{
    //     //     $this->count_product = 0;
    //     // }

    //     foreach ($this->produk_isipadumr_a as $key => $value) {
    //         // dd($key);
    //         $this->validate([
    //             'produk_ketebalan_a.'.$key => 'required_if:produk_isipadumr_a.'.$key.', null',
    //             'produk_isipadumr_a.'.$key => 'numeric|max: 11',
    //             'produk_isipaduwbp_a.'.$key => 'numeric|max: 11',
    //             'produk_ketebalan_b.' . $key => 'required_if:produk_isipadumr_a.' . $key.', null',
    //             'produk_isipadumr_b.'.$key => 'numeric|min: 12',
    //             'produk_isipaduwbp_b.' . $key => 'numeric|min: 12',
    //         ]);
    //     }
    // }


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
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();

        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('user.shuttle-4-senaraiD', date('Y')), 'name' => "Kemasukan Maklumat"],
            ['link' => route('user.shuttle-4-formD', date('Y')), 'name' => "Borang 4D - PENYATA PENGELUARAN"],
        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('livewire.shuttle-four.form-d', compact ('kilang_info','returnArr'));
    }

    public function mount()
    {
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $this->bulan_id)->whereYear('created_at', date("Y"))->first();
        $this->kemasukan_bahan_calc_lain_lain = KemasukanBahan::
        where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->latest('updated_at')->first();

        $user = auth()->user();

        $formd = Form4D::where('shuttle_id',$user->shuttle_id)->where('bulan',$this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $form4_d = ProdukPengeluaran::where('form4ds_id',$formd->id)->get();

        // dd($form4_d->produk_ketebalan);
        //sangkuttttt

        $this->produk_isipadumr_a[0] = 0;
        $this->produk_isipaduwbp_a[0] = 0;
        $this->jumlah_kecil_1_mr = 0;
        $this->jumlah_kecil_1_wbp = 0;

        $this->produk_isipadumr_b[0] = 0;
        $this->produk_isipaduwbp_b[0] = 0;
        $this->jumlah_kecil_2_mr = 0;
        $this->jumlah_kecil_2_wbp = 0;
        $this->jumlah_kecil_2_wbp = 0;

        $this->jumlah_besar_mr = 0;
        $this->jumlah_besar_wbp = 0;

        $this->rekod_veniermuka = 0;
        $this->rekod_venierteras = 0;
        $this->jumlah_pengeluaran = 0;

        // dd($this->kemasukan_bahan_calc_lain_lain->jumlah_besar_kayu_ke_dalam_jentera);
    }

    public function addNipis($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->produk_isipadumr_a[$this->i] = 0;
        $this->produk_isipaduwbp_a[$this->i] = 0;
        // dd($this->produk_isipaduwbp_a[$this->i]);
    }

    public function removeNipis($i, $value)
    {
        unset($this->inputs[$i]);
        unset($this->produk_ketebalan_a[$value]);
        unset($this->produk_isipadumr_a[$value]);
        unset($this->produk_isipaduwbp_a[$value]);
        $i = $value - 1;
        $this->i = $i;
        $this->render();

        $this->CalcJumlah_kecil_1_mr();
        $this->CalcJumlah_kecil_1_wbp();
        // $this->CalcJumlah_besar_mr();
    }

    public function addTebal($j)
    {
        $j = $j + 1;
        $this->j = $j;
        array_push($this->inputs2 ,$j);
        $this->produk_isipadumr_b[$this->j] = 0;
        $this->produk_isipaduwbp_b[$this->j] = 0;
    }

    public function removeTebal($j, $value)
    {
        unset($this->inputs2[$j]);
        unset($this->produk_ketebalan_b[$value]);
        unset($this->produk_isipadumr_b[$value]);
        unset($this->produk_isipaduwbp_b[$value]);
        $j = $value - 1;
        $this->j = $j;
        $this->render();

        $this->CalcJumlah_kecil_2_mr();
        $this->CalcJumlah_kecil_2_wbp();
        // $this->CalcJumlah_besar_mr();



    }

    public function CalcJumlah_kecil_1_mr(){

        $jumlah_kecil_1_mr=0;


        foreach($this->produk_isipadumr_a as $key => $value){

            $produk_isipadumr = $this->produk_isipadumr_a[$key] ?? 0;
            $jumlah_kecil_1_mr += (float)$produk_isipadumr;
        }

        $this->jumlah_kecil_1_mr =  $jumlah_kecil_1_mr;

        $this->CalcJumlah_besar_mr();
        // dd($this->jumlah_kecil_1_mr);
        // $this->CalcJumlah_besar_mr();

    }

    public function CalcJumlah_kecil_1_wbp(){

        $jumlah_kecil_1_wbp=0;
        foreach($this->produk_isipaduwbp_a as $key => $value){
            $produk_isipaduwbp = $this->produk_isipaduwbp_a[$key] ?? 0;
            $jumlah_kecil_1_wbp += (float)$produk_isipaduwbp;
        }

        $this->jumlah_kecil_1_wbp =  $jumlah_kecil_1_wbp;
        $this->CalcJumlah_besar_wbp();

        // dd($this->jumlah_kecil_1_wbp);
        // $this->CalcJumlah_besar_mr();

    }

    public function CalcJumlah_kecil_2_mr(){

        $jumlah_kecil_2_mr=0;
        foreach($this->produk_isipadumr_b as $key => $value){
            $produk_isipadumr = $this->produk_isipadumr_b[$key] ?? 0;
            $jumlah_kecil_2_mr += (float)$produk_isipadumr;
        }

        $this->jumlah_kecil_2_mr =  $jumlah_kecil_2_mr;
        $this->CalcJumlah_besar_mr();


        // dd($this->jumlah_kecil_1_mr);
        // $this->CalcJumlah_besar_mr();

    }

    public function CalcJumlah_kecil_2_wbp(){

        $jumlah_kecil_2_wbp=0;
        foreach($this->produk_isipaduwbp_b as $key => $value){
            $produk_isipaduwbp = $this->produk_isipaduwbp_b[$key] ?? 0;
            $jumlah_kecil_2_wbp += (float)$produk_isipaduwbp;
        }

        $this->jumlah_kecil_2_wbp =  $jumlah_kecil_2_wbp;
        $this->CalcJumlah_besar_wbp();

        // dd($this->jumlah_kecil_2_wbp);
        // $this->CalcJumlah_besar_mr();

    }


    public function CalcJumlah_besar_mr(){

        $jumlah_besar_mr = 0;
        $jumlah_kecil_1_mr= $this->jumlah_kecil_1_mr ?? 0;
        $jumlah_kecil_2_mr= $this->jumlah_kecil_2_mr ?? 0;

        $jumlah_besar_mr= (float)$jumlah_kecil_1_mr + (float)$jumlah_kecil_2_mr;

        $this->jumlah_besar_mr = $jumlah_besar_mr;
        // dd($this->jumlah_besar_mr);

    }

    public function CalcJumlah_besar_wbp(){

        $jumlah_besar_wbp = 0;
        $jumlah_kecil_1_wbp= $this->jumlah_kecil_1_wbp ?? 0;
        $jumlah_kecil_2_wbp= $this->jumlah_kecil_2_wbp ?? 0;

        $jumlah_besar_wbp= (float)$jumlah_kecil_1_wbp + (float)$jumlah_kecil_2_wbp;

        $this->jumlah_besar_wbp= $jumlah_besar_wbp;
        // dd($this->jumlah_besar_mr);

    }

    public function CalcJumlah_Venier(){

        $jumlah_pengeluaran = 0;
        $rekod_veniermuka = $this-> rekod_veniermuka ?? 0 ;
        $rekod_venierteras= $this -> rekod_venierteras ?? 0;

        $jumlah_pengeluaran = (float)$rekod_veniermuka + (float)$rekod_venierteras ?? 0 ;

        $this->jumlah_pengeluaran = $jumlah_pengeluaran;
    }

    public function store()
    {
        $recovery_rate = RecoveryRate::where('shuttle_type', '4')->first();

        $min_recovery_rate = (float)$recovery_rate->min_recovery_rate * (float)$this->kemasukan_bahan_calc_lain_lain->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
        $max_recovery_rate = (float)$recovery_rate->max_recovery_rate * (float)$this->kemasukan_bahan_calc_lain_lain->jumlah_besar_kayu_ke_dalam_jentera ?? 0;

        // dd($min_recovery_rate);
        foreach ($this->produk_isipadumr_a as $key => $value) {
            $this->validate([
                'produk_isipadumr_a.0' => 'required',
                'produk_ketebalan_a.' . $key => 'numeric|required_if:produk_isipadumr_a.' . $key . ', null|max:11',
                'produk_isipadumr_a.' . $key => 'numeric',
                'produk_isipaduwbp_a.' . $key => 'numeric',
                'produk_ketebalan_b.' . $key => 'numeric|required_if:produk_isipadumr_a.' . $key . ', null|min:12',
                'produk_isipadumr_b.' . $key => 'numeric',
                'produk_isipaduwbp_b.' . $key => 'numeric',
            ]);
        }

        $total = (float)$this->jumlah_besar_mr + (float)$this->jumlah_besar_wbp + (float)$this->jumlah_pengeluaran;
        if($total > $max_recovery_rate){
            $this->emit('alert', ['type' => 'error', 'message' => 'Jumlah A.Papan Lapis & B.Venir Tidak Boleh Melebihi ' . $max_recovery_rate]);
            return back();
        }elseif($total > 0 && $total < $min_recovery_rate){
            $this->emit('alert', ['type' => 'error', 'message' => 'Jumlah A.Papan Lapis & B.Venir Tidak Boleh Kurang daripada ' . $min_recovery_rate]);
            return back();
        }

        // dd('tes');
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

        $formd = Form4D::where('shuttle_id',$user->shuttle_id)->where('bulan',$this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $formd->rekod_veniermuka = $this->rekod_veniermuka;
        $formd->rekod_venierteras = $this->rekod_venierteras;
        $formd->jumlah_pengeluaran = $this->jumlah_pengeluaran;

        $formd->status = 'Sedang Diproses';
        $formd->save();

        //batch
        $batch = Batch::where('tahun',$formd->tahun)->where('bulan',$formd->bulan)->where('shuttle_id',$formd->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_d = 1;
        $batch->save();

        // dd($this->jumlah_besar_mr);
        foreach($this->produk_ketebalan_a as $key => $value){
            ProdukPengeluaran::create([
                'form4ds_id' => $formd->id,
                'produk_ketebalan' => $this->produk_ketebalan_a[$key] ?? 0,
                'produk_isipadumr' => $this->produk_isipadumr_a[$key]  ?? 0,
                'produk_isipaduwbp' => $this->produk_isipaduwbp_a[$key]  ?? 0,

                'jumlah_kecil_1_mr' => $this->jumlah_kecil_1_mr  ?? 0,
                'jumlah_kecil_1_wbp' => $this->jumlah_kecil_1_wbp  ?? 0,

                'jumlah_kecil_2_mr' => $this->jumlah_kecil_2_mr  ?? 0,
                'jumlah_kecil_2_wbp' => $this->jumlah_kecil_2_wbp  ?? 0,

                'jumlah_besar_mr' => $this->jumlah_besar_mr  ?? 0,
                'jumlah_besar_wbp' => $this->jumlah_besar_wbp  ?? 0,
             ]);
        }

        foreach($this->produk_ketebalan_b as $key => $value){
            ProdukPengeluaran::create([
                'form4ds_id' => $formd->id,
                'produk_ketebalan' => $this->produk_ketebalan_b[$key]  ?? 0,
                'produk_isipadumr' => $this->produk_isipadumr_b[$key]  ?? 0,
                'produk_isipaduwbp' => $this->produk_isipaduwbp_b[$key]  ?? 0,

                'jumlah_kecil_1_mr' => $this->jumlah_kecil_1_mr  ?? 0,
                'jumlah_kecil_1_wbp' => $this->jumlah_kecil_1_wbp  ?? 0,

                'jumlah_kecil_2_mr' => $this->jumlah_kecil_2_mr  ?? 0,
                'jumlah_kecil_2_wbp' => $this->jumlah_kecil_2_wbp  ?? 0,

                'jumlah_besar_mr' => $this->jumlah_besar_mr  ?? 0,
                'jumlah_besar_wbp' => $this->jumlah_besar_wbp  ?? 0,
             ]);
        }
        $this->inputs = [];

        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }

    public function tiadaPengeluaran()
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

        $formd = Form4D::where('shuttle_id',$user->shuttle_id)->where('bulan',$this->bulan_id)->whereYear('created_at', date("Y"))->first();

        $formd->status = 'Tiada Pengeluaran';
        $formd->tiada_pengeluaran = 1;
        $formd->save();

        //batch
        $batch = Batch::where('tahun',$formd->tahun)->where('bulan',$formd->bulan)->where('shuttle_id',$formd->shuttle->id)->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_d = 1;
        $batch->save();

        ProdukPengeluaran::create([
            'form4ds_id' => $formd->id,
            'produk_ketebalan' =>  0,
            'produk_isipadumr' =>  0,
            'produk_isipaduwbp' =>  0,

            'jumlah_kecil_1_mr' => 0,
            'jumlah_kecil_1_wbp' => 0,

            'jumlah_kecil_2_mr' => 0,
            'jumlah_kecil_2_wbp' => 0,

            'jumlah_besar_mr' => 0,
            'jumlah_besar_wbp' => 0,

            ]);

        // foreach($this->produk_ketebalan_b as $key => $value){
        //     ProdukPengeluaran::create([
        //         'form4ds_id' => $formd->id,
        //         'produk_ketebalan' => 0,
        //         'produk_isipadumr' => 0,
        //         'produk_isipaduwbp' => 0,


        //         'jumlah_kecil_2_mr' => 0,
        //         'jumlah_kecil_2_wbp' => 0,

        //         'jumlah_besar_mr' => 0,
        //         'jumlah_besar_wbp' => 0,


        //      ]);
        // }

        $this->inputs = [];
        // $this->resetInputFields();
        // dd('test');
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }
}
