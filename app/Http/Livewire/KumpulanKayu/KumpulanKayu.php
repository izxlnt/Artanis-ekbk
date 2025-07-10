<?php

namespace App\Http\Livewire\KumpulanKayu;

use App\Models\KumpulanKayu as Kayu;

use Livewire\Component;

class KumpulanKayu extends Component
{

    public $keterangan,$id_keterangan,$singkatan;
    public $updatedMode= 0;

    public function render(){
    // {   dd('test');
        $list = Kayu::get();
        return view('livewire.kumpulan-kayu.kumpulan-kayu',compact('list'));
    }

    public function addNew(){
        // dd('masuk');
        $this->updatedMode = 1;
    }

    public function store()
    {
        $this->validate([
            'keterangan' => 'required|string',
            'singkatan' => 'required|string',
        ]);

        Kayu::create([
            'keterangan'=> $this->keterangan,
            'singkatan'=> $this->singkatan,

        ]);

        // $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('kumpulan-kayu');
    }

    public function edit($id){
        // dd($id);
        $data = Kayu::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->singkatan = $data->singkatan;
        $this->updatedMode= 2;
    }

    public function update(){


        $this->validate([
            'keterangan' => 'required|string',
            'singkatan' => 'required|string',

        ]);


        $data = Kayu::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
            'singkatan'=> $this->singkatan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('kumpulan-kayu');

    }

    public function delete($id){
        // dd($id);
        $data = Kayu::find($id);
        $data->delete();
        return redirect()->route('kumpulan-kayu');

    }
}
