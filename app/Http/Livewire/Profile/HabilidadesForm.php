<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Habilidad;

class HabilidadesForm extends Component
{
    public $user;
    public $habilidadesDisponibles = [];
    public $habilidadesSeleccionadas = [];
    public $nuevaHabilidad = '';
    public $categoriaNueva = '';

    public $search = '';
    public $categoriaFiltro = '';

    protected $listeners = ['refreshHabilidades' => 'mount'];

    public function mount()
    {
        $this->user = auth()->user();
        $this->habilidadesDisponibles = Habilidad::where('activo', true)->get();
        
        // Cargar habilidades actuales del usuario
        $this->habilidadesSeleccionadas = $this->user->habilidades()
            ->get()
            ->mapWithKeys(function ($habilidad) {
                return [
                    $habilidad->id => [
                        'id' => $habilidad->id,
                        'nombre' => $habilidad->nombre,
                        'nivel' => $habilidad->pivot->nivel ?? 1,
                        'experiencia_meses' => $habilidad->pivot->experiencia_meses ?? null
                    ]
                ];
            })->toArray();
    }

    public function agregarHabilidad($habilidadId)
    {
        if (!isset($this->habilidadesSeleccionadas[$habilidadId])) {
            $habilidad = Habilidad::find($habilidadId);
            $this->habilidadesSeleccionadas[$habilidadId] = [
                'id' => $habilidad->id,
                'nombre' => $habilidad->nombre,
                'nivel' => 3,
                'experiencia_meses' => null
            ];
        }
    }

    // Método para buscar habilidades
    public function updatedSearch()
    {
        // Filtrar habilidades basado en la búsqueda
        $this->habilidadesDisponibles = Habilidad::query()
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoriaFiltro, function ($query) {
                $query->where('categoria', $this->categoriaFiltro);
            })
            ->orderBy('nombre')
            ->get();
    }

    // Método para cambiar categoría de filtro
    public function updatedCategoriaFiltro()
    {
        $this->updatedSearch(); // Reutilizar la lógica de búsqueda
    }

    public function eliminarHabilidad($habilidadId)
    {
        unset($this->habilidadesSeleccionadas[$habilidadId]);
    }

    public function crearNuevaHabilidad()
    {
        $this->validate([
            'nuevaHabilidad' => 'required|string|max:100',
            'categoriaNueva' => 'nullable|string|max:50'
        ]);

        $habilidad = Habilidad::create([
            'nombre' => $this->nuevaHabilidad,
            'categoria' => $this->categoriaNueva,
            'activo' => true
        ]);

        $this->agregarHabilidad($habilidad->id);
        
        $this->reset(['nuevaHabilidad', 'categoriaNueva']);
        $this->habilidadesDisponibles = Habilidad::where('activo', true)->get();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Habilidad creada y agregada exitosamente!'
        ]);
    }

    public function guardarHabilidades()
    {
        $habilidadesData = [];
        
        foreach ($this->habilidadesSeleccionadas as $habilidad) {
            $habilidadesData[$habilidad['id']] = [
                'nivel' => $habilidad['nivel'],
                'experiencia_meses' => $habilidad['experiencia_meses']
            ];
        }

        $this->user->habilidades()->sync($habilidadesData);
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Habilidades actualizadas correctamente!'
        ]);
        
        $this->emit('refreshProfile');
        $this->dispatchBrowserEvent('close-modal', 'habilidades');
    }

    public function render()
    {
        return view('livewire.profile.habilidades-form');
    }
}