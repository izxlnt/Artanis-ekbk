<?php

namespace App\Http\Livewire\StatusOperasi;

use App\Models\Status;
use Livewire\Component;

class StatusOperasi extends Component
{
    public $updatedMode = 0;
    public $keterangan,$fungsi,$Warganegara,$id_keterangan;

    public function render()
    {
        // dd('masuk');
        $list = Status::get();
        return view('livewire.status-operasi.status-operasi',compact('list'));

    }



    public function addNew(){
        // dd('masuk');
        $this->updatedMode= 1;
    }

    public function edit($id){
        // dd($id);
        $data = Status::find($id);
        $this->id_keterangan = $data->id;
        $this->keterangan = $data->keterangan;
        $this->updatedMode= 2;
    }

    public function delete($id){
        // dd($id);
        $data = Status::find($id);
        $data->delete();
        return redirect()->route('status-operasi');
    }

    public function update(){
        $data = Status::find($this->id_keterangan);
        $data -> update([
            'keterangan'=> $this->keterangan,
        ]);



        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('status-operasi');
    }

    public function store(){
        // dd('masuk');
        Status::create([
            'keterangan'=> $this->keterangan,
        ]);

        $this->resetInputFields();

        // session()->flash('message', 'Hak Milik Syarikat berjaya ditambah');
        return redirect()->route('status-operasi');
    }

    private function resetInputFields(){
        $this->Warganegara = '';

    }
}
