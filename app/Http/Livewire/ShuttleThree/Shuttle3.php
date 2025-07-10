<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Shuttle;
use Livewire\Component;

class Shuttle3 extends Component
{
    public $loadData = true;
    public $form_type = '3A';

    public function render()
    {
        // dd($this->form_type ?? '3A');
        if ($this->form_type == '3A') {
            $route = route('shuttle-3-formA');
            $this->dispatchBrowserEvent('changed');
        } elseif ($this->form_type == '3B') {
            $route = route('shuttle-3-formB');
            $this->dispatchBrowserEvent('changed');
        } elseif ($this->form_type == '3C') {
            $route = route('shuttle-3-formC');
            $this->dispatchBrowserEvent('changed');
        } elseif ($this->form_type == '3D') {
            $route = route('shuttle-3-formD');
            $this->dispatchBrowserEvent('changed');
        }

        if ($this->loadData) {
            $shuttles = Shuttle::where('shuttle_type', '3')->paginate(10);
            // dd($shuttles);
        }

        $array = array(
            'shuttles' => $shuttles ?? [],
            'route' => $route
        );

        return view('livewire.shuttle-three.shuttle3', $array);
    }
}
