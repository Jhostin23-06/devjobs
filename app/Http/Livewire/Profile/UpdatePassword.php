<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed|different:current_password',
    ];

    protected $messages = [
        'current_password.required' => 'La contraseña actual es obligatoria.',
        'password.required' => 'La nueva contraseña es obligatoria.',
        'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'password.different' => 'La nueva contraseña debe ser diferente a la actual.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function actualizarPassword()
    {
        $this->validate();

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'La contraseña actual es incorrecta.');
            return;
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        // Resetear formulario
        $this->reset(['current_password', 'password', 'password_confirmation']);

        $this->dispatchBrowserEvent('close-modal', 'cambiar-password');

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Contraseña cambiada exitosamente!'
        ]);
        
    }

    public function render()
    {
        return view('livewire.profile.update-password');
    }
}