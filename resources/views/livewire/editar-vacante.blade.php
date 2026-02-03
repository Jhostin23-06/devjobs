<form class="space-y-8" wire:submit.prevent='editarVacante' id="form-editar-vacante">

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
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300" />
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
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300" />
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
                    <option value="">-- Selecciona un rango salarial --</option>
                    @foreach ($salarios as $salarioItem)
                    <option value="{{ $salarioItem->id }}" {{ $salario == $salarioItem->id ? 'selected' : '' }}>
                        {{ $salarioItem->salario }}
                    </option>
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
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach ($categorias as $categoriaItem)
                    <option value="{{ $categoriaItem->id }}" {{ $categoria == $categoriaItem->id ? 'selected' : '' }}>
                        {{ $categoriaItem->categoria }}
                    </option>
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
                    class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300" />
                <div class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            @error('ultimo_dia')
            <livewire:mostrar-alerta :message="$message" />
            @enderror
            <p class="text-xs text-gray-500 mt-2">Actualiza la fecha límite para recibir postulaciones</p>
        </div>

        <!-- Imagen -->
        <div class="space-y-3">
            <label class="text-sm font-medium text-gray-700 flex items-center">
                <i class="fas fa-image text-indigo-500 mr-2"></i>
                Logo de la Empresa
            </label>

            <!-- Imagen actual -->
            <div class="mb-4 p-4 border border-gray-200 rounded-xl bg-gray-50">
                <p class="text-sm font-medium text-gray-700 mb-2">Imagen actual:</p>
                <div class="relative w-48 h-32 overflow-hidden rounded-lg border border-gray-300">
                    <img src="{{ asset('storage/vacantes/' . $imagen) }}"
                        alt="{{ 'Imagen Vacante ' . $titulo }}"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Nueva imagen -->
            <div class="relative">
                <input
                    id="imagen_nueva"
                    type="file"
                    wire:model="imagen_nueva"
                    accept="image/*"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </div>

            @if($imagen_nueva)
            <div class="mt-4 p-4 border border-blue-100 rounded-xl bg-blue-50">
                <p class="text-sm font-medium text-blue-700 mb-2">Vista previa de nueva imagen:</p>
                <div class="flex items-start gap-4">
                    <div class="relative w-48 h-32 overflow-hidden rounded-lg border border-blue-300">
                        <img src="{{ $imagen_nueva->temporaryUrl() }}"
                            alt="Vista previa nueva imagen"
                            class="w-full h-full object-cover">
                        <button type="button"
                            wire:click="$set('imagen_nueva', null)"
                            class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-blue-600">La nueva imagen reemplazará la actual al guardar los cambios.</p>
                    </div>
                </div>
            </div>
            @endif

            @error('imagen_nueva')
            <livewire:mostrar-alerta :message="$message" />
            @enderror
            <p class="text-xs text-gray-500 mt-2">Deja vacío para mantener la imagen actual</p>
        </div>
    </div>

    <div class="space-y-3">
        <label class="text-sm font-medium text-gray-700 flex items-center">
            <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
            Descripción del Puesto
        </label>

        <textarea
            id="descripcion"
            name="descripcion"
            wire:model="descripcion"
            rows="15"
            placeholder="Actualiza la descripción del puesto..."
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"
            style="resize: vertical; min-height: 300px;">{{ $descripcion }}</textarea>

        <p class="text-xs text-gray-500">
            Los saltos de línea se convertirán automáticamente en párrafos al mostrar la vacante.
        </p>

        @error('descripcion')
        <livewire:mostrar-alerta :message="$message" />
        @enderror
    </div>

    <!-- Botones de acción -->
    <div class="pt-6 border-t border-gray-200">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="flex gap-4">
                <button type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                    <span wire:loading.remove wire:target="editarVacante">
                        <i class="fas fa-save mr-3"></i>
                        Guardar Cambios
                    </span>
                    <span wire:loading wire:target="editarVacante">
                        <i class="fas fa-spinner fa-spin mr-3"></i>
                        Guardando...
                    </span>
                </button>

                <a href="{{ route('vacantes.index') }}"
                    class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl border border-gray-300 hover:border-gray-400 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-3"></i>
                    Cancelar
                </a>
            </div>

            <div class="mt-4 md:mt-0">
                <a href="{{ route('vacantes.show', $vacante_id) }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                    <i class="fas fa-eye mr-2"></i>
                    Ver vista previa de la vacante
                </a>
            </div>
        </div>
    </div>
</form>

<style>
    /* Estilos para textarea */
    textarea {
        resize: vertical;
        min-height: 300px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
    }

    textarea:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Estilos para mantener formato */
    #descripcion {
        font-family: 'Courier New', Consolas, monospace;
        line-height: 1.6;
        white-space: pre-wrap;
        /* Respeta espacios y saltos de línea */
        word-wrap: break-word;
        /* Rompe palabras largas */
        overflow-wrap: break-word;
        /* Alternativa moderna */
        tab-size: 4;
        /* Tamaño de tabulación */
        -moz-tab-size: 4;
        -o-tab-size: 4;
    }

    /* Estilo para texto seleccionado */
    #descripcion::selection {
        background-color: rgba(99, 102, 241, 0.3);
    }

    /* Scrollbar personalizado */
    #descripcion::-webkit-scrollbar {
        width: 10px;
    }

    #descripcion::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }

    #descripcion::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 5px;
    }

    #descripcion::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    /* Placeholder estilizado */
    #descripcion::placeholder {
        color: #9ca3af;
        font-style: italic;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
</style>

<script>
    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('descripcion');

        if (textarea) {
            // Ajustar altura inicial
            ajustarAltura(textarea);

            // Actualizar contador
            actualizarContador(textarea);

            // Escuchar cambios para actualizar contador
            textarea.addEventListener('input', function() {
                actualizarContador(this);
            });
        }
    });

    // Función para ajustar altura automáticamente
    function ajustarAltura(textarea) {
        // Reset height to auto to get the correct scrollHeight
        textarea.style.height = 'auto';

        // Set height to scrollHeight (content height)
        const newHeight = Math.max(textarea.scrollHeight, 300); // Mínimo 300px
        textarea.style.height = newHeight + 'px';
    }

    // Función para manejar tabulación
    function manejarTabulacion(event) {
        const textarea = event.target;

        if (event.key === 'Tab') {
            event.preventDefault();

            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;

            // Insertar tabulación (4 espacios)
            textarea.value = textarea.value.substring(0, start) + '    ' + textarea.value.substring(end);

            // Mover cursor después de la tabulación
            textarea.selectionStart = textarea.selectionEnd = start + 4;

            // Disparar evento input para Livewire
            textarea.dispatchEvent(new Event('input', {
                bubbles: true
            }));

            // Ajustar altura
            ajustarAltura(textarea);
        }

        // Actualizar contador
        actualizarContador(textarea);
    }

    // Función para manejar pegado manteniendo formato
    function manejarPegado(event) {
        const textarea = event.target;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;

        // Obtener texto pegado
        const pastedText = (event.clipboardData || window.clipboardData).getData('text');

        // Reemplazar el texto seleccionado
        textarea.value = textarea.value.substring(0, start) + pastedText + textarea.value.substring(end);

        // Mover cursor al final del texto pegado
        textarea.selectionStart = textarea.selectionEnd = start + pastedText.length;

        // Disparar evento input para Livewire
        textarea.dispatchEvent(new Event('input', {
            bubbles: true
        }));

        // Ajustar altura
        ajustarAltura(textarea);

        // Actualizar contador
        actualizarContador(textarea);

        // Prevenir el comportamiento por defecto
        event.preventDefault();
    }

    // Función para actualizar contador de caracteres
    function actualizarContador(textarea) {
        const contador = document.getElementById('contador-caracteres');
        if (contador) {
            contador.textContent = textarea.value.length;
        }
    }

    // Función para convertir texto plano a HTML básico (opcional)
    function convertirTextoAHTML(texto) {
        // Reemplazar saltos de línea
        texto = texto.replace(/\n/g, '<br>');

        // Reemplazar múltiples espacios
        texto = texto.replace(/  /g, ' &nbsp;');

        // Reemplazar tabulaciones
        texto = texto.replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;');

        return texto;
    }

    // Función para convertir HTML a texto plano (opcional)
    function convertirHTMLATexto(html) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        return tempDiv.textContent || tempDiv.innerText || '';
    }
</script>