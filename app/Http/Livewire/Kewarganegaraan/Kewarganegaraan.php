<?php

namespace App\Http\Livewire\Kewarganegaraan;
use App\Models\Warganegara;
use Livewire\Component;

class Kewarganegaraan extends Component
{
    public $updatedMode = 0;
    public $keterangan,$fungsi,$Warganegara,$id_keterangan;

    public function render()
    {
        // dd('masuk');
        $list = Warganegara::get();
        return view('livewire.kewarganegaraan.kewarganegaraan',compact('list'));
    }



    public function addNew(){
        // dd('masuk');
        $this->updatedMode= 1;
    }

    public function edit($id){
        // dd($id);
        $data = Warganegara::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->updatedMode= 2;
    }

    public function delete($id){
        // dd($id);
        $data = Warganegara::find($id);
        $data->delete();
        return redirect()->route('kewarganegaraan');
    }

    public function update(){

        $this->validate([
            'keterangan' => 'required|string',
        ]);


        $data = Warganegara::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('kewarganegaraan');
    }

    public function store(){

        $this->validate([
            'keterangan' => 'required|string',
        ]);

            Warganegara::create([
            'keterangan'=> $this->keterangan,
        ]);

        $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('kewarganegaraan');
    }

    private function resetInputFields(){
        $this->Warganegara = '';

    }
}
