<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MostrarVacante extends Component
{
    public $vacante;

    public function render()
    {
        return view('livewire.mostrar-vacante');
    }
}
