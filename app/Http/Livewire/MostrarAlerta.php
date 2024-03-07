<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MostrarAlerta extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.mostrar-alerta');
    }
}
