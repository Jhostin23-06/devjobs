<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">

    <livewire:filtrar-vacantes />

    <!-- Lista de vacantes con el mismo diseño -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header del listado -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Vacantes Disponibles</h2>
                    <p class="text-gray-600 mt-1">
                        <span class="font-semibold text-indigo-600">{{ $vacantes->total() }}</span> oportunidades encontradas
                    </p>
                </div>
                
                <!-- Ordenamiento -->
                <div class="inline-flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200">
                    <i class="fas fa-sort text-gray-400"></i>
                    <select class="bg-transparent border-none text-gray-700 font-medium focus:outline-none focus:ring-0 text-sm">
                        <option>Ordenar por: Más recientes</option>
                        <option>Salario más alto</option>
                        <option>Próximo a vencer</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Grid de vacantes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse ($vacantes as $vacante)
                <!-- Tarjeta de vacante - Mismo estilo que show -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 group hover:border-indigo-200">
                    <!-- Banner superior con gradiente -->
                    <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                    
                    <div class="p-6">
                        <!-- Header con logo y empresa -->
                        <div class="flex items-start gap-4 mb-4">
                            <!-- Logo empresa -->
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-md">
                                    @if($vacante->imagen)
                                    <img src="{{ asset('storage/vacantes/' . $vacante->imagen) }}"
                                        alt="{{'Logo ' . $vacante->empresa}}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                        <span class="text-lg font-bold text-indigo-600">
                                            {{ substr($vacante->empresa, 0, 2) }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Información básica -->
                            <div class="flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors mb-1">
                                    <a href="{{ route('vacantes.show', $vacante->id) }}" class="hover:underline">
                                        {{ Str::limit($vacante->titulo, 50) }}
                                    </a>
                                </h3>
                                
                                <div class="flex items-center text-gray-600">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center mr-2">
                                            <i class="fas fa-building text-indigo-500 text-xs"></i>
                                        </div>
                                        <span class="font-medium text-sm">{{ $vacante->empresa }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Badge de nuevo si es reciente -->
                            @if($vacante->created_at->diffInDays(now()) < 3)
                            <span class="inline-flex items-center text-xs font-bold px-2 py-1 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 text-white">
                                <i class="fas fa-bolt mr-1"></i>Nuevo
                            </span>
                            @endif
                        </div>

                        <!-- Badges informativos -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                <i class="fas fa-tag text-xs"></i>
                                {{ $vacante->categoria->categoria }}
                            </span>
                            
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                <i class="fas fa-money-bill-wave text-xs"></i>
                                {{ $vacante->salario->salario }}
                            </span>
                            
                            @if($vacante->ultimo_dia->diffInDays(now()) < 7)
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                <i class="fas fa-clock text-xs"></i>
                                Vence pronto
                            </span>
                            @endif
                        </div>

                        <!-- Descripción breve -->
                        <div class="mb-4">
                            <p class="text-gray-600 text-sm line-clamp-2">
                                {{ Str::limit(strip_tags($vacante->descripcion), 120) }}
                            </p>
                        </div>

                        <!-- Footer con fecha y botón -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <span>Hasta: {{ $vacante->ultimo_dia->format('d/m/Y') }}</span>
                                </div>
                                
                                <div class="hidden sm:flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>{{ $vacante->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('vacantes.show', $vacante->id) }}"
                               class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2 px-4 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 text-sm">
                                <span>Ver detalles</span>
                                <i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Estado vacío -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No se encontraron vacantes</h3>
                        <p class="text-gray-600 mb-6">
                            No hay vacantes disponibles en este momento.
                        </p>
                        <a href="{{ route('vacantes.index') }}" 
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2 px-6 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            <i class="fas fa-redo"></i>
                            Recargar
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($vacantes->hasPages())
        <div class="mt-8">
            {{ $vacantes->links() }}
        </div>
        @endif

        <!-- CTA para reclutadores - Mismo estilo que show -->
        <div class="mt-12 bg-gradient-to-r from-gray-900 to-black rounded-2xl overflow-hidden shadow-xl">
            <div class="relative p-8 text-center">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -mt-32 -mr-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full -mb-24 -ml-24"></div>
                </div>
                
                <div class="relative">
                    <h3 class="text-2xl font-bold text-white mb-4">
                        ¿Eres reclutador?
                    </h3>
                    <p class="text-gray-300 mb-6 max-w-md mx-auto">
                        Publica tus vacantes y encuentra al talento ideal
                    </p>
                    
                    @auth
                        @can('create', App\Models\Vacante::class)
                        <a href="{{ route('vacantes.create') }}"
                           class="group inline-flex items-center gap-2 bg-white text-gray-900 font-bold py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            <i class="fas fa-plus-circle"></i>
                            <span>Crear vacante</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        @endcan
                    @else
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            <i class="fas fa-user-plus"></i>
                            <span>Crear cuenta</span>
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white font-semibold py-3 px-6 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Iniciar sesión</span>
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos para mantener consistencia -->
<style>
    /* Estilos para truncar texto a múltiples líneas */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Estilos para la paginación */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 0.125rem;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.25rem;
        height: 2.25rem;
        padding: 0 0.5rem;
        border-radius: 0.75rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .pagination a {
        background-color: white;
        border: 1px solid #e5e7eb;
        color: #4b5563;
    }

    .pagination a:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .pagination .active span {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        box-shadow: 0 2px 4px rgba(99, 102, 241, 0.3);
    }

    /* Animaciones consistentes */
    .group:hover .group-hover\:scale-105 {
        transform: scale(1.05);
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }
        
        .p-8 {
            padding: 1.5rem;
        }
        
        .text-4xl {
            font-size: 2rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
        
        .gap-4 {
            gap: 1rem;
        }
    }

    /* Efectos de hover mejorados */
    .hover\:-translate-y-0\.5:hover {
        transform: translateY(-0.125rem);
    }

    /* Mejora en los badges */
    .border-blue-100 {
        border-color: rgba(191, 219, 254, 0.5);
    }

    .border-green-100 {
        border-color: rgba(209, 250, 229, 0.5);
    }

    .border-amber-100 {
        border-color: rgba(254, 243, 199, 0.5);
    }
</style>