<div class="p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
        <i class="fas fa-briefcase text-indigo-500 mr-2"></i>
        {{ $editId ? 'Editar' : 'Agregar' }} Experiencia Laboral
    </h3>

    <form wire:submit.prevent="guardarExperiencia">
        <div class="space-y-6">
            <!-- Puesto y Empresa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tie text-indigo-500 mr-2"></i>
                        Puesto / Cargo
                    </label>
                    <input type="text" 
                           wire:model.defer="puesto"
                           placeholder="Ej: Desarrollador Frontend Senior"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('puesto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building text-indigo-500 mr-2"></i>
                        Empresa
                    </label>
                    <input type="text" 
                           wire:model.defer="empresa"
                           placeholder="Ej: Google, Microsoft, Apple"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('empresa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Ubicación -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                    Ubicación
                </label>
                <input type="text" 
                       wire:model.defer="ubicacion"
                       placeholder="Ej: Ciudad, País o Remoto"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                @error('ubicacion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-plus text-indigo-500 mr-2"></i>
                        Fecha de inicio
                    </label>
                    <input type="date" 
                           wire:model.defer="fecha_inicio"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('fecha_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-minus text-indigo-500 mr-2"></i>
                        Fecha de fin
                    </label>
                    <input type="date" 
                           wire:model.defer="fecha_fin"
                           {{ $trabajo_actual ? 'disabled' : '' }}
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 {{ $trabajo_actual ? 'bg-gray-100' : '' }}">
                    @error('fecha_fin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-end">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" 
                                   wire:model="trabajo_actual"
                                   class="sr-only">
                            <div class="block bg-gray-200 w-14 h-8 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform {{ $trabajo_actual ? 'translate-x-6 bg-green-500' : '' }}"></div>
                        </div>
                        <span class="text-gray-700 font-medium">
                            <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                            Trabajo actual
                        </span>
                    </label>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                    Descripción de responsabilidades
                </label>
                <textarea wire:model.defer="descripcion" 
                          rows="4"
                          placeholder="Describe tus responsabilidades, logros y proyectos en este puesto..."
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"></textarea>
                @error('descripcion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 mt-8">
            <button type="button" 
                    onclick="closeModal('experiencia')"
                    class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium">
                Cancelar
            </button>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50">
                <span wire:loading.remove wire:target="guardarExperiencia">
                    <i class="fas fa-save mr-2"></i>
                    {{ $editId ? 'Actualizar' : 'Guardar' }} Experiencia
                </span>
                <span wire:loading wire:target="guardarExperiencia">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Guardando...
                </span>
            </button>
        </div>
    </form>
</div>