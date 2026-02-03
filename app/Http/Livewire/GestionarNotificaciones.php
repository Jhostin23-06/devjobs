<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class GestionarNotificaciones extends Component
{
    public $notificaciones;
    public $notificacionesNoLeidas;
    public $notificacionesLeidas;
    public $mostrarSoloNoLeidas = false;

    // ✅ Agregar este listener para actualizar contador
    protected $listeners = [
        'notificacionActualizada' => 'cargarNotificaciones',
        'actualizarContador' => '$refresh' // Para forzar refresh del contador
    ];

    public function mount()
    {
        $this->cargarNotificaciones();
    }

    public function cargarNotificaciones()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Usar métodos EXPLÍCITOS del modelo
        $this->notificacionesNoLeidas = $user->unreadNotifications()->get();
        $this->notificacionesLeidas = $user->readNotifications()->get();
        
        // Combinar y ordenar
        $this->notificaciones = $this->notificacionesNoLeidas
            ->merge($this->notificacionesLeidas)
            ->sortByDesc('created_at');
    }

    public function marcarComoLeida($notificacionId)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $notificacion = DatabaseNotification::find($notificacionId);
        
        if ($notificacion && 
            $notificacion->notifiable_id == $user->id && 
            $notificacion->notifiable_type == User::class &&
            is_null($notificacion->read_at)) {
            
            $notificacion->markAsRead();
            $this->cargarNotificaciones();
            
            // ✅ EMITIR EVENTO GLOBAL para actualizar contador
            $this->emitTo('contador-notificaciones', 'notificacionActualizada');
            $this->dispatchBrowserEvent('notificaciones-actualizadas');
            
            session()->flash('mensaje', 'Notificación marcada como leída');
        }
    }

    public function marcarTodasComoLeidas()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        $this->cargarNotificaciones();
        
        // ✅ EMITIR EVENTO GLOBAL para actualizar contador
        $this->emitTo('contador-notificaciones', 'notificacionActualizada');
        $this->dispatchBrowserEvent('notificaciones-actualizadas');
        
        session()->flash('mensaje', 'Todas las notificaciones han sido marcadas como leídas');
    }

    public function marcarComoNoLeida($notificacionId)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $notificacion = DatabaseNotification::find($notificacionId);
        
        if ($notificacion && 
            $notificacion->notifiable_id == $user->id && 
            $notificacion->notifiable_type == User::class &&
            $notificacion->read_at) {
            
            $notificacion->update(['read_at' => null]);
            $this->cargarNotificaciones();
            
            // ✅ EMITIR EVENTO GLOBAL para actualizar contador
            $this->emitTo('contador-notificaciones', 'notificacionActualizada');
            $this->dispatchBrowserEvent('notificaciones-actualizadas');
            
            session()->flash('mensaje', 'Notificación marcada como no leída');
        }
    }

    public function eliminarNotificacion($notificacionId)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $notificacion = DatabaseNotification::find($notificacionId);
        
        if ($notificacion && 
            $notificacion->notifiable_id == $user->id && 
            $notificacion->notifiable_type == User::class) {
            
            $notificacion->delete();
            $this->cargarNotificaciones();
            
            // ✅ EMITIR EVENTO GLOBAL para actualizar contador
            $this->emitTo('contador-notificaciones', 'notificacionActualizada');
            $this->dispatchBrowserEvent('notificaciones-actualizadas');
            
            session()->flash('mensaje', 'Notificación eliminada');
        }
    }

    public function eliminarTodasLeidas()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $user->readNotifications()->delete();
        
        $this->cargarNotificaciones();
        
        // ✅ EMITIR EVENTO GLOBAL para actualizar contador
        $this->emitTo('contador-notificaciones', 'notificacionActualizada');
        $this->dispatchBrowserEvent('notificaciones-actualizadas');
        
        session()->flash('mensaje', 'Notificaciones leídas eliminadas');
    }

    public function render()
    {
        return view('livewire.gestionar-notificaciones');
    }
}