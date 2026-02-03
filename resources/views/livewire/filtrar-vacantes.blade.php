<div class="bg-white py-8 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent='leerDatosFormulario' class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div class="relative">
                    <input 
                        id="termino"
                        type="text"
                        placeholder="Buscar por palabra clave..."
                        class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        wire:model.debounce.500ms="termino"
                    />
                    <div class="absolute left-3 top-3.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>

                <!-- Categoría -->
                <div class="relative">
                    <select 
                        wire:model="categoria" 
                        class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 appearance-none"
                    >
                        <option value="">Todas las categorías</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->categoria }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-3.5 text-gray-400">
                        <i class="fas fa-filter"></i>
                    </div>
                </div>

                <!-- Salario -->
                <div class="relative">
                    <select 
                        wire:model="salario" 
                        class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 appearance-none"
                    >
                        <option value="">Todos los salarios</option>
                        @foreach ($salarios as $sal)
                            <option value="{{ $sal->id }}">{{ $sal->salario }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-3.5 text-gray-400">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>

                <!-- Botón -->
                <button 
                    type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2"
                >
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
            </div>

            <!-- Filtros activos -->
            @if($termino || $categoria || $salario)
            <div class="flex flex-wrap gap-2 pt-2">
                @if($termino)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
                    {{ $termino }}
                    <button type="button" wire:click="$set('termino', '')" class="ml-1 hover:text-red-500">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </span>
                @endif
                
                @if($categoria)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800">
                    {{ $categorias->firstWhere('id', $categoria)->categoria ?? '' }}
                    <button type="button" wire:click="$set('categoria', '')" class="ml-1 hover:text-red-500">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </span>
                @endif
                
                @if($salario)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                    {{ $salarios->firstWhere('id', $salario)->salario ?? '' }}
                    <button type="button" wire:click="$set('salario', '')" class="ml-1 hover:text-red-500">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </span>
                @endif
                
                <button 
                    type="button"
                    wire:click="limpiarFiltros"
                    class="text-sm text-gray-600 hover:text-gray-900 ml-2"
                >
                    Limpiar todos
                </button>
            </div>
            @endif
        </form>
    </div>
</div>