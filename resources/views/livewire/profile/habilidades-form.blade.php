<div class="p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
        <i class="fas fa-code text-indigo-500 mr-2"></i>
        Gestionar Habilidades
    </h3>

    <!-- Buscar y agregar habilidades -->
    <div class="mb-8">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-search text-indigo-500 mr-2"></i>
            Buscar Habilidades
        </label>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="md:col-span-2">
                <input type="text" 
                       wire:model.debounce.300ms="search"
                       placeholder="Escribe para buscar habilidades..."
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
            </div>
            <div>
                <select 
                wire:model="categoriaFiltro"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    <option value="">Todas las categorías</option>
                    @foreach(['frontend', 'backend', 'herramientas', 'soft'] as $categoria)
                        <option value="{{ $categoria }}">{{ ucfirst($categoria) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Habilidades disponibles -->
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach($habilidadesDisponibles as $habilidad)
                @if(!isset($habilidadesSeleccionadas[$habilidad->id]))
                    <button type="button"
                            wire:click="agregarHabilidad({{ $habilidad->id }})"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300 flex items-center">
                        <i class="fas fa-plus text-green-500 mr-2"></i>
                        {{ $habilidad->nombre }}
                        @if($habilidad->categoria)
                            <span class="ml-2 text-xs bg-gray-200 px-2 py-1 rounded">
                                {{ $habilidad->categoria }}
                            </span>
                        @endif
                    </button>
                @endif
            @endforeach
        </div>

        <!-- Crear nueva habilidad -->
        <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 mb-6">
            <h4 class="font-medium text-indigo-800 mb-3">
                <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                Crear nueva habilidad
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <input type="text" 
                           wire:model="nuevaHabilidad"
                           placeholder="Nombre de la nueva habilidad"
                           class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                </div>
                <div>
                    <select wire:model="categoriaNueva"
                            class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                        <option value="">Sin categoría</option>
                        <option value="frontend">Frontend</option>
                        <option value="backend">Backend</option>
                        <option value="herramientas">Herramientas</option>
                        <option value="soft">Habilidades blandas</option>
                    </select>
                </div>
            </div>
            <button wire:click="crearNuevaHabilidad"
                    wire:loading.attr="disabled"
                    class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Crear y agregar
            </button>
        </div>
    </div>

    <!-- Habilidades seleccionadas -->
    <div class="mb-8">
        <h4 class="font-medium text-gray-700 mb-4">
            <i class="fas fa-list-check text-indigo-500 mr-2"></i>
            Mis Habilidades ({{ count($habilidadesSeleccionadas) }})
        </h4>

        @if(count($habilidadesSeleccionadas) > 0)
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                @foreach($habilidadesSeleccionadas as $habilidad)
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="font-medium text-gray-900">{{ $habilidad['nombre'] }}</span>
                                @if($habilidadData = $habilidadesDisponibles->firstWhere('id', $habilidad['id']))
                                    @if($habilidadData->categoria)
                                        <span class="ml-2 text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">
                                            {{ $habilidadData->categoria }}
                                        </span>
                                    @endif
                                @endif
                            </div>
                            <button type="button"
                                    wire:click="eliminarHabilidad({{ $habilidad['id'] }})"
                                    class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nivel -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Nivel</label>
                                <div class="flex items-center">
                                    <input type="range" 
                                           wire:model="habilidadesSeleccionadas.{{ $habilidad['id'] }}.nivel"
                                           min="1" 
                                           max="5" 
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                    <span class="ml-3 font-bold text-indigo-600 min-w-8">
                                        {{ $habilidadesSeleccionadas[$habilidad['id']]['nivel'] }}/5
                                    </span>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>Principiante</span>
                                    <span>Experto</span>
                                </div>
                            </div>

                            <!-- Experiencia -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Experiencia (meses)</label>
                                <div class="relative">
                                    <input type="number" 
                                           wire:model="habilidadesSeleccionadas.{{ $habilidad['id'] }}.experiencia_meses"
                                           min="0"
                                           placeholder="Ej: 24"
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200">
                                    <div class="absolute right-3 top-2 text-gray-400">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-xl">
                <i class="fas fa-code text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">No has seleccionado habilidades aún</p>
                <p class="text-sm text-gray-400 mt-1">Busca y agrega habilidades de la lista superior</p>
            </div>
        @endif
    </div>

    <!-- Botones -->
    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
        <button type="button" 
                onclick="closeModal('habilidades')"
                class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium">
            Cancelar
        </button>
        <button type="button"
                wire:click="guardarHabilidades"
                wire:loading.attr="disabled"
                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50">
            <span wire:loading.remove wire:target="guardarHabilidades">
                <i class="fas fa-save mr-2"></i>
                Guardar Habilidades
            </span>
            <span wire:loading wire:target="guardarHabilidades">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Guardando...
            </span>
        </button>
    </div>
</div>