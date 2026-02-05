<?php

namespace App\Http\Controllers;

use App\Models\Educacion;
use App\Models\Experiencia;
use App\Models\Habilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar perfil
    public function show()
    {
        $user = Auth::user();
        $habilidades = Habilidad::where('activo', true)->get();
        
        return view('profile-show', compact('user', 'habilidades'));
    }

    // Mostrar formulario de edición
    public function edit()
    {
        $user = Auth::user();
        $habilidades = Habilidad::where('activo', true)->get();
        
        return view('profile-edit', compact('user', 'habilidades'));
    }

    // Actualizar información básica
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'biografia' => 'nullable|string|max:1000',
            'titulo_profesional' => 'nullable|string|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'perfil_publico' => 'boolean',
            'recibir_notificaciones' => 'boolean',
        ]);

        // Manejar la foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto anterior si existe
            if ($user->foto_perfil) {
                Storage::delete('public/fotos_perfil/' . $user->foto_perfil);
            }
            
            $file = $request->file('foto_perfil');
            $fileName = time() . '_' . Str::slug($user->name) . '.' . $file->getClientOriginalExtension();
            
            // Guardar la imagen
            $file->storeAs('public/fotos_perfil', $fileName);
            $validated['foto_perfil'] = $fileName;
        } else {
            unset($validated['foto_perfil']);
        }

        $user->update($validated);

        return redirect()->route('profile-show')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    // Cambiar contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña cambiada exitosamente.');
    }

    // Gestionar habilidades
    public function updateHabilidades(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'habilidades' => 'nullable|array',
            'habilidades.*.id' => 'required|exists:habilidades,id',
            'habilidades.*.nivel' => 'required|integer|min:1|max:5',
            'habilidades.*.experiencia_meses' => 'nullable|integer|min:0',
        ]);

        // Sincronizar habilidades con niveles
        $habilidadesData = [];
        if ($request->has('habilidades')) {
            foreach ($request->habilidades as $habilidad) {
                $habilidadesData[$habilidad['id']] = [
                    'nivel' => $habilidad['nivel'],
                    'experiencia_meses' => $habilidad['experiencia_meses'] ?? null,
                ];
            }
        }
        
        $user->habilidades()->sync($habilidadesData);

        return back()->with('success', 'Habilidades actualizadas correctamente.');
    }

    // Gestionar experiencias
    public function storeExperiencia(Request $request)
    {
        $validated = $request->validate([
            'puesto' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'trabajo_actual' => 'boolean',
            'descripcion' => 'nullable|string',
        ]);

        Auth::user()->experiencias()->create($validated);

        return back()->with('success', 'Experiencia agregada correctamente.');
    }

    public function destroyExperiencia(Experiencia $experiencia)
    {
        if ($experiencia->user_id !== Auth::id()) {
            abort(403);
        }

        $experiencia->delete();
        return back()->with('success', 'Experiencia eliminada correctamente.');
    }

    // Gestionar educación
    public function storeEducacion(Request $request)
    {
        $validated = $request->validate([
            'institucion' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'campo_estudio' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estudiando_actualmente' => 'boolean',
            'descripcion' => 'nullable|string',
        ]);

        Auth::user()->educaciones()->create($validated);

        return back()->with('success', 'Educación agregada correctamente.');
    }

    public function destroyEducacion(Educacion $educacion)
    {
        if ($educacion->user_id !== Auth::id()) {
            abort(403);
        }

        $educacion->delete();
        return back()->with('success', 'Educación eliminada correctamente.');
    }
}
