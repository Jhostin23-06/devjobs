<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                    Candidatos de la Vacante
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Revisa y gestiona las postulaciones recibidas
                </p>
            </div>
            <a href="{{ route('vacantes.index') }}"
                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium">
                <i class="fas fa-arrow-left"></i>
                Volver a vacantes
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header de la vacante -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl shadow-sm p-6 mb-8 border border-indigo-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $vacante->titulo }}
                        </h1>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-building text-indigo-500 mr-2"></i>
                            <span class="font-medium">{{ $vacante->empresa }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-users text-purple-500 mr-2"></i>
                            <span>{{ $vacante->candidatos->count() }} candidatos</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-600">{{ $vacante->candidatos->count() }}</div>
                            <div class="text-sm text-gray-600">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ $vacante->candidatos->where('created_at', '>=', now()->subDays(7))->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Esta semana</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-amber-600">
                                {{ $vacante->candidatos->where('created_at', '>=', now()->subDays(1))->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Hoy</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de candidatos -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header de la tabla -->
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">
                            <i class="fas fa-user-friends mr-2 text-indigo-600"></i>
                            Candidatos Postulados
                        </h3>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-6">
                    @forelse ($vacante->candidatos as $candidato)
                    <div class="group bg-white hover:bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100 hover:border-indigo-200 transition-all duration-300">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <!-- Información del candidato -->
                            <div class="flex items-start gap-4 flex-grow">
                                <!-- Avatar -->
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center text-lg font-bold text-indigo-600">
                                        {{ substr($candidato->user->name, 0, 1) }}
                                    </div>
                                    <!-- Badge de nuevo si es reciente -->
                                    @if($candidato->created_at->diffInDays(now()) < 2)
                                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-bolt text-white text-xs"></i>
                                        </span>
                                        @endif
                                </div>

                                <!-- Detalles -->
                                <div class="flex-grow">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-lg group-hover:text-indigo-600 transition-colors">
                                                {{ $candidato->user->name }}
                                            </h4>
                                            <div class="flex items-center text-gray-600 mt-1">
                                                <i class="fas fa-envelope text-gray-400 text-sm mr-2"></i>
                                                <span class="text-sm">{{ $candidato->user->email }}</span>
                                            </div>
                                        </div>

                                        <!-- Información adicional -->
                                        <div class="flex flex-wrap gap-3">
                                            <div class="flex items-center text-gray-500 text-sm">
                                                <i class="fas fa-calendar-alt mr-2"></i>
                                                <span>Postuló: {{ $candidato->created_at->diffForHumans() }}</span>
                                            </div>

                                            @if($candidato->vistas > 0)
                                            <div class="flex items-center text-amber-600 text-sm">
                                                <i class="fas fa-eye mr-2"></i>
                                                <span>Visto {{ $candidato->vistas }} veces</span>
                                            </div>
                                            @endif


                                            <!-- Acciones -->
                                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                                <!-- Ver CV -->
                                                <a
                                                    href="{{ asset('storage/cv/' . $candidato->cv ) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    wire:click="addView({{ $candidato->id }})"
                                                    class="group/btn inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                                                    <i class="fas fa-file-pdf group-hover/btn:scale-110 transition-transform"></i>
                                                    <span>Ver CV</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Habilidades o tags (puedes agregar si tienes) -->
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-file-pdf mr-1"></i>
                                            CV disponible
                                        </span>

                                        @if($candidato->created_at->diffInHours(now()) < 24)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Postulación reciente
                                            </span>
                                            @endif
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                    @empty
                    <!-- Estado vacío -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-friends text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-3">No hay candidatos aún</h3>
                        <p class="text-gray-600 max-w-md mx-auto mb-8">
                            Aún no han llegado postulaciones para esta vacante.
                            Compártela para atraer más talento.
                        </p>
                        <div class="flex gap-4 justify-center">
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-share-alt"></i>
                                Compartir vacante
                            </button>
                            <a href="{{ route('vacantes.edit', $vacante->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-edit"></i>
                                Editar vacante
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Footer con paginación si es necesario -->
                @if($vacante->candidatos->count() > 0)
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="text-sm text-gray-600">
                            Mostrando <span class="font-semibold">{{ $vacante->candidatos->count() }}</span> de
                            <span class="font-semibold">{{ $vacante->candidatos->count() }}</span> candidatos
                        </div>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Estilos adicionales -->
    <style>
        /* Animaciones */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Transiciones suaves */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Dropdown de acciones */
        .group-hover\/actions\:block {
            display: block !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .flex-col {
                flex-direction: column;
            }

            .gap-8 {
                gap: 1.5rem;
            }
        }
    </style>

    <!-- Script para dropdown de acciones -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alternar dropdown de acciones
            document.querySelectorAll('[data-action-dropdown]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    dropdown.classList.toggle('hidden');
                });
            });

            // Cerrar dropdowns al hacer clic fuera
            document.addEventListener('click', function() {
                document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            });
        });
    </script>
</x-app-layout>