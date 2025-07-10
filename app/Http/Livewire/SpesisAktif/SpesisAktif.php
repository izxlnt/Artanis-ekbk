<?php

namespace App\Http\Livewire\SpesisAktif;

use App\Models\KumpulanKayu;
use App\Models\Spesis;
use Livewire\Component;

class SpesisAktif extends Component
{

    public function render()
    {
        $spesis = Spesis::with('kumpulan_kayu')->get();
        // dd($spesis);
        $kumpulan_kayu = KumpulanKayu::get();
        return view('livewire.spesis-aktif.spesis-aktif',compact('spesis','kumpulan_kayu'));
    }

    public function updateActive ($id)
    {
        // dd('masuk');
        $data = Spesis::find($id);
        // dd($data);
        if ($data->aktif) {
            $this->aktif = 0;
        }
        else {
            $this->aktif = 1;
        }
        $data -> update([
            'aktif'=> $this->aktif,
        ]);
        // dd($this->aktif);

        return redirect()->route('spesis-aktif');

    }
}
