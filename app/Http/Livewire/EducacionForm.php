<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Educacion;

class EducacionForm extends Component
{
    public $editId = null;
    public $institucion = '';
    public $titulo = '';
    public $campo_estudio = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $estudiando_actualmente = false;
    public $descripcion = '';

    protected $rules = [
        'institucion' => 'required|string|max:255',
        'titulo' => 'required|string|max:255',
        'campo_estudio' => 'nullable|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        'descripcion' => 'nullable|string|max:2000',
    ];

    public function mount($educacion = null)
    {
        if ($educacion) {
            $this->editId = $educacion->id;
            $this->institucion = $educacion->institucion;
            $this->titulo = $educacion->titulo;
            $this->campo_estudio = $educacion->campo_estudio;
            $this->fecha_inicio = $educacion->fecha_inicio->format('Y-m-d');
            $this->fecha_fin = $educacion->fecha_fin ? $educacion->fecha_fin->format('Y-m-d') : '';
            $this->estudiando_actualmente = $educacion->estudiando_actualmente;
            $this->descripcion = $educacion->descripcion;
        }
    }

    public function guardarEducacion()
    {
        $this->validate();

        $data = [
            'institucion' => $this->institucion,
            'titulo' => $this->titulo,
            'campo_estudio' => $this->campo_estudio,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->estudiando_actualmente ? null : $this->fecha_fin,
            'estudiando_actualmente' => $this->estudiando_actualmente,
            'descripcion' => $this->descripcion,
        ];

        if ($this->editId) {
            $educacion = Educacion::find($this->editId);
            $educacion->update($data);
            $message = 'Educación actualizada correctamente!';
        } else {
            auth()->user()->educaciones()->create($data);
            $message = 'Educación agregada correctamente!';
        }

        $this->resetForm();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => $message
        ]);
        
        $this->emit('refreshProfile');
        $this->dispatchBrowserEvent('close-modal', 'educacion');
    }

    public function resetForm()
    {
        $this->reset([
            'editId', 'institucion', 'titulo', 'campo_estudio',
            'fecha_inicio', 'fecha_fin', 'estudiando_actualmente', 'descripcion'
        ]);
    }

    public function render()
    {
        return view('livewire.educacion-form');
    }
}