<?php

namespace App\Http\Livewire\HakMilikSyarikat;
use App\Models\HakMilik;
use Illuminate\Support\Facades\Validator;


use Livewire\Component;


class HakMilikSyarikat extends Component
{


    public $updatedMode = 0;
    public $keterangan,$fungsi,$HakMilik,$id_keterangan;

    public function render()
    {
        // dd('masuk');
        $list = HakMilik::get();
        return view('livewire.hak-milik-syarikat.hak-milik-syarikat',compact('list'));
    }



    public function addNew(){
        // dd('masuk');
        $this->updatedMode= 1;
    }

    public function back(){
        // dd('masuk');
        $this->updatedMode= 0;
    }

    public function edit($id){
        // dd($id);
        $data = HakMilik::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->updatedMode= 2;
    }

    public function delete($id){
        // dd($id);
        $data = HakMilik::find($id);
        $data->delete();
        return redirect()->route('hak-milik-syarikat');
    }

    public function update(){

        $this->validate([
            'keterangan' => 'required|string',
        ]);

        $data = HakMilik::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('hak-milik-syarikat');

    }


    public function store(){
        // dd('masuk');
        $this->validate([
            'keterangan' => 'required|string',
        ]);

            HakMilik::create([
            'keterangan'=> $this->keterangan,
        ]);

        $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('hak-milik-syarikat');

    }

    private function resetInputFields(){
        $this->HakMilik = '';
        // $this->updatedMode= 2;

    }
}
