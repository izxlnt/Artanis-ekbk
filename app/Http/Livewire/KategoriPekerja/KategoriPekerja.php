<?php

namespace App\Http\Livewire\KategoriPekerja;

use App\Models\KategoriGunaTenaga;
use Livewire\Component;

class KategoriPekerja extends Component
{

    public $keterangan,$id_keterangan,$gaji_min,$gaji_max;
    public $updatedMode= 0;

    public function render(){
    // {   dd('test');
        $list = KategoriGunaTenaga::get();
        return view('livewire.kategori-pekerja.kategori-pekerja',compact('list'));
    }

    public function addNew(){
        // dd('masuk');
        $this->updatedMode = 1;
    }

    public function store()
    {
        $this->validate([
            'keterangan' => 'required|string',
            'gaji_min' => 'required|numeric',
            'gaji_max' => 'required|numeric',
        ]);


          KategoriGunaTenaga::create([
            'keterangan'=> $this->keterangan,
            'gaji_min'=> $this->gaji_min,
            'gaji_max'=> $this->gaji_max,
        ]);

        // $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('kategori-pekerja');
    }

    public function edit($id){
        // dd($id);
        $data = KategoriGunaTenaga::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->gaji_min = $data->gaji_min;
        $this->gaji_max = $data->gaji_max;
        $this->updatedMode= 2;
    }

    public function update(){

        $this->validate([
            'keterangan' => 'required|string',
            'gaji_min' => 'required|numeric',
            'gaji_max' => 'required|numeric',
        ]);


        $data = KategoriGunaTenaga::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
            'gaji_min'=> $this->gaji_min,
            'gaji_max'=> $this->gaji_max,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('kategori-pekerja');
    }

    public function delete($id){
        // dd($id);
        $data = KategoriGunaTenaga::find($id);
        $data->delete();
        return redirect()->route('kategori-pekerja');
    }
}
