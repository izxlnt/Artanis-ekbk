<?php

namespace App\Http\Livewire\TarafSyarikat;

use App\Models\TarafSyarikat as ModelsTarafSyarikat;
use Livewire\Component;

class TarafSyarikat extends Component
{
    public $updatedMode = 0;
    public $keterangan,$fungsi,$Warganegara,$id_keterangan;

    public function render()
    {
        // dd('masuk');
        $list = ModelsTarafSyarikat::get();
        return view('livewire.taraf-syarikat.taraf-syarikat',compact('list'));
    }



    public function addNew(){
        // dd('masuk');
        $this->updatedMode= 1;
    }

    public function edit($id){
        // dd($id);
        $data = ModelsTarafSyarikat::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->updatedMode= 2;
    }

    public function delete($id){
        // dd($id);
        $data = ModelsTarafSyarikat::find($id);
        $data->delete();
        return redirect()->route('taraf-syarikat');
    }

    public function update(){
        $this->validate([
            'keterangan' => 'required|string'
        ]);
        $data = ModelsTarafSyarikat::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('taraf-syarikat');
    }

    public function store(){

        $this->validate([
            'keterangan' => 'required|string'
        ]);
        ModelsTarafSyarikat::create([
            'keterangan'=> $this->keterangan,
        ]);

        $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('taraf-syarikat');
    }

    private function resetInputFields(){
        $this->Warganegara = '';

    }
}
