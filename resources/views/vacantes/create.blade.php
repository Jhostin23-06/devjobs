<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Nueva Vacante') }}
            </h2>
            <a href="{{ route('vacantes.index') }}" 
               class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a vacantes
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Contenedor del formulario -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <!-- Header del formulario -->
                <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">
                    <div class="flex items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Detalles de la Vacante</h3>
                            <p class="text-gray-600 text-sm">Todos los campos son obligatorios</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario mejorado -->
                <div class="p-8">
                    <livewire:crear-vacante />
                </div>
            </div>

        </div>
    </div>
</x-app-layout>