<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContadorNotificaciones extends Component
{

    public $contador = 0;
    
    protected $listeners = ['notificacionActualizada' => 'actualizarContador'];

    public function mount()
    {
        $this->actualizarContador();
    }

    public function actualizarContador()
    {
        $this->contador = Auth::user()->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.contador-notificaciones');
    }
}
