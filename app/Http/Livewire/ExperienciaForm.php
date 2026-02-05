<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Experiencia;

class ExperienciaForm extends Component
{
    public $editId = null;
    public $puesto = '';
    public $empresa = '';
    public $ubicacion = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $trabajo_actual = false;
    public $descripcion = '';

    protected $rules = [
        'puesto' => 'required|string|max:255',
        'empresa' => 'required|string|max:255',
        'ubicacion' => 'nullable|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        'descripcion' => 'nullable|string|max:2000',
    ];

    public function mount($experiencia = null)
    {
        if ($experiencia) {
            $this->editId = $experiencia->id;
            $this->puesto = $experiencia->puesto;
            $this->empresa = $experiencia->empresa;
            $this->ubicacion = $experiencia->ubicacion;
            $this->fecha_inicio = $experiencia->fecha_inicio->format('Y-m-d');
            $this->fecha_fin = $experiencia->fecha_fin ? $experiencia->fecha_fin->format('Y-m-d') : '';
            $this->trabajo_actual = $experiencia->trabajo_actual;
            $this->descripcion = $experiencia->descripcion;
        }
    }

    public function guardarExperiencia()
    {
        $this->validate();

        $data = [
            'puesto' => $this->puesto,
            'empresa' => $this->empresa,
            'ubicacion' => $this->ubicacion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->trabajo_actual ? null : $this->fecha_fin,
            'trabajo_actual' => $this->trabajo_actual,
            'descripcion' => $this->descripcion,
        ];

        if ($this->editId) {
            $experiencia = Experiencia::find($this->editId);
            $experiencia->update($data);
            $message = 'Experiencia actualizada correctamente!';
        } else {
            auth()->user()->experiencias()->create($data);
            $message = 'Experiencia agregada correctamente!';
        }

        $this->resetForm();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => $message
        ]);
        
        $this->emit('refreshProfile');
        $this->dispatchBrowserEvent('close-modal', 'experiencia');
    }

    public function resetForm()
    {
        $this->reset([
            'editId', 'puesto', 'empresa', 'ubicacion',
            'fecha_inicio', 'fecha_fin', 'trabajo_actual', 'descripcion'
        ]);
    }

    public function render()
    {
        return view('livewire.experiencia-form');
    }
}