<?php

namespace App\Http\Livewire\Spesis;

use App\Models\KumpulanKayu;
use App\Models\Spesis as ModelsSpesis;
use Livewire\Component;

class Spesis extends Component
{
    public $keterangan,$id_keterangan,$singkatan,$nama_tempatan,$nama_saintifik,$kod,$kumpulan_kayu_id,$aktif;
    public $updatedMode= 0;

    public function render(){
    // {   dd('test');
        $list = ModelsSpesis::get();
        $kumpulan_kayu_kayan= KumpulanKayu :: get();
        return view('livewire.spesis.spesis',compact('list','kumpulan_kayu_kayan'));
    }

    public function addNew(){
        // dd('masuk');
        $this->updatedMode = 1;
    }

    public function store()
    {

        $this->validate([
            'nama_tempatan' => 'required|string',
            'nama_saintifik' => 'required|string',
            'kod' => 'required|string',
            'kumpulan_kayu_id' => 'required',
            'aktif' => 'required',
        ]);

        ModelsSpesis::create([
            'nama_tempatan'=> $this->nama_tempatan,
            'nama_saintifik'=> $this->nama_saintifik,
            'kod'=> $this->kod,
            'kumpulan_kayu_id'=> $this->kumpulan_kayu_id,
            'aktif'=> $this->aktif,

        ]);

        // $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('spesis');
    }

    public function edit($id){
        // dd($id);
        $data = ModelsSpesis::find($id);
        $this->id_keterangan = $data->id;
        $this->nama_tempatan = $data->nama_tempatan;
        $this->nama_saintifik = $data->nama_saintifik;
        $this->kod = $data->kod;
        $this->kumpulan_kayu_id = $data->kumpulan_kayu_id;
        $this->aktif = $data->aktif;
        $this->updatedMode= 2;
    }

    public function update(){

        $this->validate([
            'nama_tempatan' => 'required|string',
            'nama_saintifik' => 'required|string',
            'kod' => 'required|string',
            'kumpulan_kayu_id' => 'required',
            'aktif' => 'required',
        ]);


        $data = ModelsSpesis::find($this->id_keterangan);
        $data -> update([
            'nama_tempatan'=> $this->nama_tempatan,
            'nama_saintifik'=> $this->nama_saintifik,
            'kod'=> $this->kod,
            'kumpulan_kayu_id'=> $this->kumpulan_kayu_id,
            'aktif'=> $this->aktif,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('spesis');

    }

    public function delete($id){
        // dd($id);
        $data = ModelsSpesis::find($id);
        $data->delete();
        return redirect()->route('spesis');

    }
}
