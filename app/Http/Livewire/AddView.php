<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Candidato;

class AddView extends Component
{
    // Declara una propiedad para almacenar el ID del candidato
    public $user_id;

    // Define un método para actualizar la vista del candidato
    public function addView()
    {
        // Encuentra el candidato con el ID especificado
        $candidato = Candidato::find($this->user_id);

        // Incrementa el número de vistas del candidato
        $candidato->views += 1;
        $candidato->save();
    }
}
