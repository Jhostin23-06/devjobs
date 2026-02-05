<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public $user;
    public $foto_perfil;
    public $mostrarCambioPassword = false;
    public $mostrarHabilidades = false;
    public $mostrarExperiencia = false;
    public $mostrarEducacion = false;

    // Datos del formulario
    public $name;
    public $email;
    public $telefono;
    public $direccion;
    public $ciudad;
    public $pais;
    public $biografia;
    public $titulo_profesional;
    public $linkedin;
    public $github;
    public $twitter;
    public $website;

    // Para cambio de contraseña
    public $current_password;
    public $password;
    public $password_confirmation;

    protected $listeners = ['refreshProfile' => '$refresh'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->telefono = $this->user->telefono;
        $this->direccion = $this->user->direccion;
        $this->ciudad = $this->user->ciudad;
        $this->pais = $this->user->pais;
        $this->biografia = $this->user->biografia;
        $this->titulo_profesional = $this->user->titulo_profesional;
        $this->linkedin = $this->user->linkedin;
        $this->github = $this->user->github;
        $this->twitter = $this->user->twitter;
        $this->website = $this->user->website;
    }

    public function actualizarInformacionBasica()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
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
            'foto_perfil' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'ciudad' => $this->ciudad,
            'pais' => $this->pais,
            'biografia' => $this->biografia,
            'titulo_profesional' => $this->titulo_profesional,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'twitter' => $this->twitter,
            'website' => $this->website,
        ];

        // Subir foto de perfil si existe
        if ($this->foto_perfil) {
            // Eliminar foto anterior si existe
            if ($this->user->foto_perfil) {
                Storage::delete('public/fotos_perfil/' . $this->user->foto_perfil);
            }

            $nombreFoto = time() . '_' . Str::slug($this->name) . '.' . $this->foto_perfil->getClientOriginalExtension();
            $this->foto_perfil->storeAs('public/fotos_perfil', $nombreFoto);
            $data['foto_perfil'] = $nombreFoto;
        }

        $this->user->update($data);
        $this->user->refresh();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Perfil actualizado correctamente!'
        ]);

        $this->foto_perfil = null;
        $this->emitSelf('refreshProfile');
    }

    public function actualizarPassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->addError('current_password', 'La contraseña actual es incorrecta.');
            return;
        }

        $this->user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->mostrarCambioPassword = false;

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Contraseña cambiada exitosamente!'
        ]);
    }

    public function render()
    {
        return view('livewire.profile-show', [
            'experiencias' => $this->user->experiencias()->orderBy('fecha_inicio', 'desc')->get(),
            'educaciones' => $this->user->educaciones()->orderBy('fecha_inicio', 'desc')->get(),
            'habilidades' => $this->user->habilidades()->withPivot('nivel')->get(),
        ]);
    }
}
