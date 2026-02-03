<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        // Usar los nuevos métodos
        $notificacionesNoLeidas = $user->notificacionesNoLeidas()->get();
        $notificacionesLeidas = $user->notificacionesLeidas()->get();
        
        // Combinar todas
        $notificaciones = $notificacionesNoLeidas
            ->merge($notificacionesLeidas)
            ->sortByDesc('created_at');

        return view('notificaciones.index', [
            'notificaciones' => $notificaciones,
            'notificacionesNoLeidas' => $notificacionesNoLeidas,
            'notificacionesLeidas' => $notificacionesLeidas
        ]);
    }
}
