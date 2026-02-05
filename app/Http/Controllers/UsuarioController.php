<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function show(User $user)
    {
        // Verificar si el perfil es público
        if (!$user->perfil_publico && (!auth()->check() || auth()->id() !== $user->id)) {
            abort(403, 'Este perfil es privado');
        }

        return view('usuarios.show', [
            'usuario' => $user->load(['habilidades', 'experiencias', 'educaciones']),
            'esMiPerfil' => auth()->check() && auth()->id() === $user->id,
        ]);
    }

    public function showById(User $user)
    {
        return $this->show($user);
    }
}
