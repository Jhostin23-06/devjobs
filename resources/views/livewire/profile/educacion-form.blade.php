<div class="p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
        <i class="fas fa-graduation-cap text-indigo-500 mr-2"></i>
        {{ $editId ? 'Editar' : 'Agregar' }} Educación
    </h3>

    <form wire:submit.prevent="guardarEducacion">
        <div class="space-y-6">
            <!-- Institución y Título -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-university text-indigo-500 mr-2"></i>
                        Institución Educativa
                    </label>
                    <input type="text" 
                           wire:model="institucion"
                           placeholder="Ej: Universidad Nacional, Instituto Tecnológico"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('institucion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-award text-indigo-500 mr-2"></i>
                        Título Obtenido
                    </label>
                    <input type="text" 
                           wire:model="titulo"
                           placeholder="Ej: Ingeniería de Software, Licenciatura en..."
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Campo de estudio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-book-open text-indigo-500 mr-2"></i>
                    Campo de Estudio
                </label>
                <input type="text" 
                       wire:model="campo_estudio"
                       placeholder="Ej: Ciencias de la Computación, Desarrollo Web, Data Science"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                @error('campo_estudio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-plus text-indigo-500 mr-2"></i>
                        Fecha de inicio
                    </label>
                    <input type="date" 
                           wire:model="fecha_inicio"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('fecha_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-minus text-indigo-500 mr-2"></i>
                        Fecha de fin
                    </label>
                    <input type="date" 
                           wire:model="fecha_fin"
                           {{ $estudiando_actualmente ? 'disabled' : '' }}
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 {{ $estudiando_actualmente ? 'bg-gray-100' : '' }}">
                    @error('fecha_fin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-end">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" 
                                   wire:model="estudiando_actualmente"
                                   class="sr-only">
                            <div class="block bg-gray-200 w-14 h-8 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform {{ $estudiando_actualmente ? 'translate-x-6 bg-green-500' : '' }}"></div>
                        </div>
                        <span class="text-gray-700 font-medium">
                            <i class="fas fa-user-graduate text-green-500 mr-2"></i>
                            Estudiando actualmente
                        </span>
                    </label>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                    Descripción adicional
                </label>
                <textarea wire:model="descripcion" 
                          rows="4"
                          placeholder="Describe logros académicos, proyectos relevantes, menciones honoríficas..."
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"></textarea>
                @error('descripcion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 mt-8">
            <button type="button" 
                    onclick="closeModal('educacion')"
                    class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium">
                Cancelar
            </button>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50">
                <span wire:loading.remove wire:target="guardarEducacion">
                    <i class="fas fa-save mr-2"></i>
                    {{ $editId ? 'Actualizar' : 'Guardar' }} Educación
                </span>
                <span wire:loading wire:target="guardarEducacion">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Guardando...
                </span>
            </button>
        </div>
    </form>
</div>