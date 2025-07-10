<?php

namespace App\Http\Livewire\JenisKayuKumai;
use App\Models\JenisKayu;

use Livewire\Component;

class JenisKayuKumai extends Component
{
    public $keterangan,$id_keterangan;
    public $updatedMode= 0;
    public function render()
    {
        $list = JenisKayu::get();
        return view('livewire.jenis-kayu-kumai.jenis-kayu-kumai',compact('list'));
    }

    public function addNew(){
        // dd('masuk');
        $this->updatedMode = 1;
    }


    public function store(){

        $this->validate([
            'keterangan' => 'required|string',
        ]);

        // dd('masuk');
            JenisKayu::create([
            'keterangan'=> $this->keterangan,
        ]);

        // $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('jenis-kayu-kumai');
    }

    public function back(){
        // dd('masuk');
        $this->updatedMode= 0;
        $this->render();

    }

    public function delete($id){
        // dd($id);
        $data = JenisKayu::find($id);
        $data->delete();
        return redirect()->route('jenis-kayu-kumai');
    }

    public function edit($id){
        // dd($id);
        $data = JenisKayu::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->updatedMode= 2;
    }

    public function update(){

        $this->validate([
            'keterangan' => 'required|string',
        ]);

        $data = JenisKayu::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('jenis-kayu-kumai');
    }

}
