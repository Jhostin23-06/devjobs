<form class="space-y-8" wire:submit.prevent='crearVacante'>
    <!-- Grid de 2 columnas para inputs básicos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Título -->
        <div class="space-y-3">
            <label for="titulo" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-heading text-indigo-500 mr-2"></i>
                Título del Puesto
            </label>
            <div class="relative">
                <input
                    id="titulo"
                    type="text"
                    wire:model="titulo"
                    placeholder="Ej: React Developer Jr"
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"
                    :value="old('titulo')" />
                <div class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
            @error('titulo')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <!-- Empresa -->
        <div class="space-y-3">
            <label for="empresa" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-building text-indigo-500 mr-2"></i>
                Nombre de la Empresa
            </label>
            <div class="relative">
                <input
                    id="empresa"
                    type="text"
                    wire:model="empresa"
                    placeholder="Ej: Google, Microsoft, Netflix"
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"
                    :value="old('empresa')" />
                <div class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-landmark"></i>
                </div>
            </div>
            @error('empresa')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <!-- Salario -->
        <div class="space-y-3">
            <label for="salario" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-money-bill-wave text-indigo-500 mr-2"></i>
                Rango Salarial
            </label>
            <div class="relative">
                <select
                    id="salario"
                    wire:model="salario"
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 appearance-none transition-all duration-300">
                    <option value="" class="text-gray-400">-- Selecciona un rango salarial --</option>
                    @foreach ($salarios as $salarioItem)
                    <option value="{{ $salarioItem->id }}">{{ $salarioItem->salario }}</option>
                    @endforeach
                </select>
                <div class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            @error('salario')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <!-- Categoría -->
        <div class="space-y-3">
            <label for="categoria" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-tag text-indigo-500 mr-2"></i>
                Categoría del Puesto
            </label>
            <div class="relative">
                <select
                    id="categoria"
                    wire:model="categoria"
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 appearance-none transition-all duration-300">
                    <option value="" class="text-gray-400">-- Selecciona una categoría --</option>
                    @foreach ($categorias as $categoriaItem)
                    <option value="{{ $categoriaItem->id }}">{{ $categoriaItem->categoria }}</option>
                    @endforeach
                </select>
                <div class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-filter"></i>
                </div>
                <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            @error('categoria')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <!-- Fecha límite -->
        <div class="space-y-3">
            <label for="ultimo_dia" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-calendar-day text-indigo-500 mr-2"></i>
                Fecha Límite
            </label>
            <div class="relative">
                <input
                    id="ultimo_dia"
                    type="date"
                    wire:model="ultimo_dia"
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"
                    :value="old('ultimo_dia')" />
                <div class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            @error('ultimo_dia')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
            <p class="text-xs text-gray-500 mt-2">Selecciona una fecha realista para recibir postulaciones</p>
        </div>

        <!-- Imagen -->
        <div class="space-y-3">
            <label for="imagen" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-image text-indigo-500 mr-2"></i>
                Logo de la Empresa
            </label>
            <div class="relative">
                <input
                    id="imagen"
                    type="file"
                    wire:model="imagen"
                    accept="image/*"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
            </div>
            
            <!-- Vista previa de imagen -->
            @if($imagen)
            <div class="mt-4 p-4 border border-gray-200 rounded-xl bg-gray-50">
                <p class="text-sm font-medium text-gray-700 mb-2">Vista previa:</p>
                <div class="relative w-32 h-32 overflow-hidden rounded-lg border border-gray-300">
                    <img src="{{ $imagen->temporaryUrl() }}" 
                         alt="Vista previa" 
                         class="w-full h-full object-cover">
                    <button type="button" 
                            wire:click="$set('imagen', null)"
                            class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
            @endif
            
            @error('imagen')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
            <p class="text-xs text-gray-500 mt-2">Recomendado: 500x500px, formato PNG o JPG</p>
        </div>
    </div>

    <!-- Descripción (ancho completo) -->
    <div class="space-y-3" wire:ignore id="editor-container">
        <label for="descripcion" class="text-sm font-medium text-gray-700 flex items-center">
            <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
            Descripción del Puesto
        </label>
        
        <!-- Input hidden para Livewire -->
        <input
            id="descripcion"
            type="hidden"
            wire:model="descripcion"
            x-data
            x-init="
            // Escuchar cambios en Trix y sincronizar con Livewire
            document.addEventListener('trix-change', function(event) {
                if (event.target.getAttribute('input') === 'descripcion') {
                    @this.set('descripcion', event.target.value);
                }
            });
            
            // También sincronizar cuando se inicialice Trix
            document.addEventListener('trix-initialize', function(event) {
                // Cargar contenido inicial si existe
                const initialContent = @this.descripcion;
                if (initialContent) {
                    event.target.editor.loadHTML(initialContent);
                }
            });
        ">

        <!-- Editor Trix con diseño mejorado -->
        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm">
            <trix-editor
                input="descripcion"
                placeholder="Describe las responsabilidades, requisitos, beneficios y todo lo que un candidato debe saber sobre esta posición..."
                class="trix-content min-h-72 p-6 focus:outline-none">
            </trix-editor>
        </div>
        
        <!-- Consejos para la descripción -->
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mt-4">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="text-sm font-medium text-blue-800 mb-2">Consejos para una buena descripción:</p>
                    <ul class="text-xs text-blue-700 space-y-1">
                        <li>• Describe las responsabilidades principales del puesto</li>
                        <li>• Especifica los requisitos mínimos (educación, experiencia)</li>
                        <li>• Menciona las habilidades técnicas y blandas requeridas</li>
                        <li>• Incluye información sobre beneficios y cultura de trabajo</li>
                    </ul>
                </div>
            </div>
        </div>

        @error('descripcion')
            <livewire:mostrar-alerta :message="$message" />
        @enderror
    </div>

    <!-- Botón de envío -->
    <div class="pt-6 border-t border-gray-200">
        <button type="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
            <span wire:loading.remove wire:target="crearVacante">
                <i class="fas fa-rocket mr-3"></i>
                Crear Vacante
            </span>
            <span wire:loading wire:target="crearVacante">
                <i class="fas fa-spinner fa-spin mr-3"></i>
                Publicando...
            </span>
        </button>
        
        <p class="text-xs text-gray-500 mt-4 text-center md:text-left">
            Al publicar esta vacante, aceptas nuestros términos y condiciones.
        </p>
    </div>
</form>

<style>
    /* Estilos mejorados para Trix Editor */
    .trix-content {
        min-height: 300px;
        font-size: 16px;
        line-height: 1.6;
        color: #374151;
    }
    
    .trix-content:focus {
        outline: none;
    }
    
    .trix-content h1 {
        font-size: 1.875rem;
        font-weight: bold;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .trix-content h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
    }
    
    .trix-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .trix-content ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .trix-content li {
        margin-bottom: 0.25rem;
    }
    
    .trix-button {
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 8px;
    }
    
    .trix-button:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    
    /* Estilos para placeholders */
    trix-editor[placeholder]:empty:before {
        content: attr(placeholder);
        color: #9ca3af;
        font-style: italic;
    }
    
    trix-editor[placeholder]:empty:focus:before {
        color: #6b7280;
    }
    
    /* Estilos para inputs con error */
    .border-red-300 {
        border-color: #fca5a5;
    }
    
    .focus\:border-red-500:focus {
        border-color: #ef4444;
    }
    
    .focus\:ring-red-200:focus {
        --tw-ring-color: rgba(254, 202, 202, 0.5);
    }
    
    /* Animación para el botón de carga */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
</style>

<!-- Script para mejorar la experiencia de Trix -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Asegurar que Trix esté disponible
        if (typeof Trix !== 'undefined') {
            // Configurar Trix para que sea más amigable
            Trix.config.toolbar = {
                getDefaultHTML: function() {
                    return '';
                }
            };
            
            // Agregar placeholder personalizado
            const trixEditor = document.querySelector('trix-editor');
            if (trixEditor) {
                trixEditor.addEventListener('trix-initialize', function() {
                    this.editor.insertHTML('<p></p>');
                });
            }
        }
        
        // Validación en tiempo real de fecha
        const fechaInput = document.getElementById('ultimo_dia');
        if (fechaInput) {
            const today = new Date().toISOString().split('T')[0];
            fechaInput.setAttribute('min', today);
        }
    });
</script>