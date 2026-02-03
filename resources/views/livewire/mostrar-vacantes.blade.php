<div>

    <!-- Lista de vacantes -->
    <div class="space-y-6">
        @forelse ($vacantes as $vacante)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 hover:border-indigo-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <!-- Header de la vacante -->
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                        <!-- Información principal -->
                        <div class="flex-1 mb-4 lg:mb-0 lg:pr-6">
                            <!-- Título y empresa -->
                            <div class="mb-4">
                                <a href="{{ route('vacantes.show', $vacante->id ) }}" 
                                   class="text-2xl font-bold text-gray-900 hover:text-indigo-600 transition-colors block mb-2">
                                    {{ $vacante->titulo }}
                                </a>
                                <div class="flex items-center text-gray-600">
                                    <div class="w-25 h-20 rounded-lg bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center mr-3">
                                        @if($vacante->imagen)
                                            <img src="{{ asset('storage/vacantes/' . $vacante->imagen ) }}" 
                                                 alt="{{'Logo ' . $vacante->empresa}}" 
                                                 class="w-25 h-20 rounded-lg object-cover">
                                        @else
                                            <span class="text-xs font-bold text-indigo-600">{{ substr($vacante->empresa, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-800">{{ $vacante->empresa }}</span>
                                        <div class="flex items-center text-sm text-gray-500 mt-1">
                                            <i class="fas fa-calendar-day mr-2"></i>
                                            <span>Publicado: {{ $vacante->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Badges de información -->
                            <div class="flex flex-wrap gap-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                    <i class="fas fa-tag mr-2"></i>
                                    {{ $vacante->categoria->categoria }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                    <i class="fas fa-money-bill-wave mr-2"></i>
                                    {{ $vacante->salario->salario }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-amber-100 text-amber-800">
                                    <i class="fas fa-clock mr-2"></i>
                                    Vence: {{ $vacante->ultimo_dia->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Estadísticas y acciones -->
                        <div class="border-t lg:border-t-0 lg:border-l border-gray-200 pt-4 lg:pt-0 lg:pl-6">
                            <!-- Contador de candidatos -->
                            <div class="mb-4">
                                <a href="{{ route('candidatos.index', $vacante) }}"
                                   class="group flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl hover:from-slate-100 hover:to-slate-200 transition-all">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">{{ $vacante->candidatos->count() }}</div>
                                            <div class="text-sm text-gray-600">Candidatos</div>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                                </a>
                            </div>

                            <!-- Acciones -->
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('vacantes.edit', $vacante->id) }}"
                                   class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-xl transition-all duration-300 hover:shadow-md">
                                    <i class="fas fa-edit"></i>
                                    <span class="font-medium">Editar</span>
                                </a>
                                
                                <button wire:click="$emit('mostrarAlerta', {{ $vacante->id }})"
                                        class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-xl transition-all duration-300 hover:shadow-md">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="font-medium">Eliminar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con tiempo restante -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            <span class="text-sm">
                                @if($vacante->ultimo_dia->isFuture())
                                    <span class="font-medium text-green-600">
                                        {{ $vacante->ultimo_dia->diffForHumans(['parts' => 2]) }} restantes
                                    </span>
                                @else
                                    <span class="font-medium text-red-600">
                                        Expirada hace {{ $vacante->ultimo_dia->diffForHumans(['parts' => 2]) }}
                                    </span>
                                @endif
                            </span>
                        </div>
                        <a href="{{ route('vacantes.show', $vacante->id ) }}"
                           class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                            Ver detalles
                            <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <!-- Estado vacío -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No hay vacantes publicadas</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Comienza creando tu primera vacante para encontrar al candidato ideal para tu equipo.
                </p>
                <a href="{{ route('vacantes.create') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-plus"></i>
                    Crear mi primera vacante
                </a>
            </div>
        @endforelse
    </div>

    <!-- Paginación mejorada -->
    @if($vacantes->hasPages())
        <div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600">
                        Mostrando <span class="font-bold">{{ $vacantes->firstItem() }}</span> 
                        a <span class="font-bold">{{ $vacantes->lastItem() }}</span> 
                        de <span class="font-bold">{{ $vacantes->total() }}</span> vacantes
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    {{ $vacantes->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        Livewire.on('mostrarAlerta', vacanteId => {
            Swal.fire({
                title: '<div class="text-2xl font-bold text-gray-900 mb-2">¿Eliminar Vacante?</div>',
                html: '<div class="text-gray-600 mb-6">Esta acción no se puede deshacer. Se eliminarán todos los datos asociados.</div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<div class="flex items-center justify-center"><i class="fas fa-trash-alt mr-2"></i> Sí, eliminar</div>',
                cancelButtonText: '<div class="flex items-center justify-center"><i class="fas fa-times mr-2"></i> Cancelar</div>',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    title: 'mb-0',
                    htmlContainer: 'mb-0',
                    confirmButton: 'btn-swal-confirm',
                    cancelButton: 'btn-swal-cancel',
                    actions: 'mt-6'
                },
                didOpen: () => {
                    // Asegurar que los botones sean visibles
                    const confirmBtn = document.querySelector('.swal2-confirm');
                    const cancelBtn = document.querySelector('.swal2-cancel');
                    
                    if (confirmBtn) {
                        confirmBtn.style.opacity = '1';
                        confirmBtn.style.visibility = 'visible';
                    }
                    
                    if (cancelBtn) {
                        cancelBtn.style.opacity = '1';
                        cancelBtn.style.visibility = 'visible';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('eliminarVacante', vacanteId);
                    
                    Swal.fire({
                        title: '<div class="text-xl font-bold text-green-600">¡Eliminado!</div>',
                        html: '<div class="text-gray-600">La vacante ha sido eliminada correctamente.</div>',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                    });
                }
            });
        });
    </script>
@endpush

<style>
    /* Estilos para la paginación de Tailwind */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin: 0 4px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-color: #6366f1;
    }
    
    .page-item .page-link:hover:not(.active) {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Estilos para SweetAlert2 */
    .btn-confirm {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
    }
    
    .btn-cancel {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
    }

    /* Estilos explícitos */
    .btn-swal-confirm {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        color: white !important;
        padding: 12px 28px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        border: none !important;
        min-width: 140px !important;
        height: 48px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        opacity: 1 !important;
        visibility: visible !important;
        transition: all 0.3s ease !important;
    }
    
    .btn-swal-confirm:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 15px rgba(239, 68, 68, 0.3) !important;
    }
    
    .btn-swal-cancel {
        background: linear-gradient(135deg, #6b7280, #4b5563) !important;
        color: white !important;
        padding: 12px 28px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        border: none !important;
        min-width: 140px !important;
        height: 48px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        opacity: 1 !important;
        visibility: visible !important;
        transition: all 0.3s ease !important;
    }
    
    .btn-swal-cancel:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 15px rgba(107, 114, 128, 0.3) !important;
    }
    
    /* Modal */
    .swal2-popup {
        padding: 2.5rem !important;
        border-radius: 20px !important;
        max-width: 500px !important;
        width: 90% !important;
    }
    
    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .bg-white {
        animation: fadeIn 0.5s ease-out;
    }
</style>