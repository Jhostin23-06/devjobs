<?php

namespace App\Http\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;
use App\Models\Vacante;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class EditarVacante extends Component
{
    public $vacante_id;
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    use WithFileUploads;

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen_nueva' => 'nullable|image|max:1024',
    ];

    public function mount(Vacante $vacante)
    {
        $this->vacante_id = $vacante->id;
        $this->titulo = $vacante->titulo;
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
        $this->empresa = $vacante->empresa;
        $this->ultimo_dia = Carbon::parse($vacante->ultimo_dia)->format('Y-m-d');
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function editarVacante() 
    {
        // Agregar log para debug
        Log::info('=== INICIANDO EDICIÓN DE VACANTE ===');
        Log::info('ID Vacante:', [$this->vacante_id]);
        Log::info('Descripción recibida (primeros 100 chars):', [substr($this->descripcion, 0, 100)]);
        Log::info('Longitud descripción:', [strlen($this->descripcion)]);
        
        $datos = $this->validate();
        
        Log::info('Datos validados correctamente');

        // Si hay una nueva imagen
        if($this->imagen_nueva) {
            Log::info('Nueva imagen detectada');
            $imagen = $this->imagen_nueva->store('public/vacantes');
            $datos['imagen'] = str_replace('public/vacantes/', '', $imagen);
        }

        // Encontrar la vacante a editar
        $vacante = Vacante::find($this->vacante_id);

        // Asignar los valores
        $vacante->titulo = $datos['titulo'];
        $vacante->salario_id = $datos['salario'];
        $vacante->categoria_id = $datos['categoria'];
        $vacante->empresa = $datos['empresa'];
        $vacante->ultimo_dia = $datos['ultimo_dia'];
        $vacante->descripcion = $datos['descripcion']; // Usar directamente $this->descripcion
        $vacante->imagen = $datos['imagen'] ?? $vacante->imagen;

        Log::info('Guardando vacante...');

        // Guardar la vacante
        $vacante->save();

        Log::info('Vacante guardada exitosamente');

        // redireccionar
        session()->flash('mensaje', 'La Vacante se actualizó Correctamente');

        return redirect()->route('vacantes.index');
    }

    // Agregar este método para debug si es necesario
    public function updatedDescripcion($value)
    {
        Log::info('Descripción actualizada en tiempo real:', [substr($value, 0, 50)]);
    }

    public function render()
    {
        // Consultar BD
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.editar-vacante', [
            'salarios' => $salarios,
            'categorias' => $categorias
        ]);
    }
}