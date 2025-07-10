<?php

namespace App\Http\Livewire\JenisPembeliShuttle4;

use App\Models\Pembeli;
use Livewire\Component;

class JenisPembeliShuttle4 extends Component
{

    public $keterangan,$id_keterangan;
    public $updatedMode= 0;

    public function render()
    {
        $list = Pembeli::where('shuttle',4) -> get();
        return view('livewire.jenis-pembeli-shuttle4.jenis-pembeli-shuttle4',compact('list'));
    }

    public function addNew(){
        // dd('masuk');
        $this->updatedMode = 1;
    }

    public function store()
    {

        $this->validate([
            'keterangan' => 'required|string',
        ]);

          Pembeli::create([
            'shuttle' => '4',
            'keterangan'=> $this->keterangan,
        ]);

        // $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('jenis-pembeli-shuttle4');
    }

    public function edit($id){
        // dd($id);
        $data = Pembeli::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->updatedMode= 2;
    }

    public function update(){

        $this->validate([
            'keterangan' => 'required|string',
        ]);


        $data = Pembeli::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('jenis-pembeli-shuttle4');
    }

    public function delete($id){
        // dd($id);
        $data = Pembeli::find($id);
        $data->delete();
        return redirect()->route('jenis-pembeli-shuttle4');
    }

}
