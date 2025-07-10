<?php

namespace App\Http\Livewire\ShuttleFour;

use App\Models\Shuttle;
use Livewire\Component;

class Shuttle4 extends Component
{
    public $loadData = true;
    public $form_type = '4A';

    public function render()
    {
        // dd($this->form_type ?? '3A');
        if ($this->form_type == '4A') {
            $route = route('shuttle-4-formA');
            $this->dispatchBrowserEvent('changed');
        } elseif ($this->form_type == '4B') {
            $route = route('shuttle-4-formB');
            $this->dispatchBrowserEvent('changed');
        } elseif ($this->form_type == '4C') {
            $route = route('shuttle-4-formC');
            $this->dispatchBrowserEvent('changed');
        } elseif ($this->form_type == '4D') {
            $route = route('shuttle-4-formD');
            $this->dispatchBrowserEvent('changed');
        }
        elseif ($this->form_type == '4E') {
            $route = route('shuttle-4-formE');
            $this->dispatchBrowserEvent('changed');
        }

        if ($this->loadData) {
            $shuttles = Shuttle::where('shuttle_type', '4')->paginate(10);
            // dd($shuttles);
        }

        $array = array(
            'shuttles' => $shuttles ?? [],
            'route' => $route
        );

        return view('livewire.shuttle-four.shuttle4', $array);
    }
}
