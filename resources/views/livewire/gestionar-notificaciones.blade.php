<div>

    <!-- Tabs -->
    <div class="flex border-b border-gray-200 mb-6">
        <button wire:click="$set('mostrarSoloNoLeidas', false)"
                class="px-4 py-2 font-medium text-sm {{ !$mostrarSoloNoLeidas ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
            Todas ({{ $notificaciones->count() }})
        </button>
        <button wire:click="$set('mostrarSoloNoLeidas', true)"
                class="ml-8 px-4 py-2 font-medium text-sm {{ $mostrarSoloNoLeidas ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
            No leídas ({{ $notificacionesNoLeidas->count() }})
            @if($notificacionesNoLeidas->count() > 0)
            <span class="ml-2 w-2 h-2 bg-red-500 rounded-full inline-block"></span>
            @endif
        </button>
    </div>

    <!-- Notificaciones -->
    <div class="space-y-4">
        @php
            $notificacionesAMostrar = $mostrarSoloNoLeidas 
                ? $notificacionesNoLeidas 
                : $notificaciones;
        @endphp
        
        @forelse ($notificacionesAMostrar as $notificacion)
            @php
                $esNoLeida = is_null($notificacion->read_at);
            @endphp
            
            <div class="bg-white rounded-lg border {{ $esNoLeida ? 'border-l-4 border-l-indigo-500 shadow-sm' : 'border-gray-200' }} p-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 rounded-full {{ $esNoLeida ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-600' }} 
                                        flex items-center justify-center mr-3">
                                <i class="fas fa-user-plus text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    Nuevo candidato en 
                                    <span class="text-indigo-600">{{ $notificacion->data['nombre_vacante'] ?? 'Vacante' }}</span>
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $notificacion->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 ml-4">
                        @if(isset($notificacion->data['id_vacante']))
                        <a href="{{ route('candidatos.index', $notificacion->data['id_vacante']) }}" 
                           class="px-3 py-1 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 transition-colors">
                            Ver candidatos
                        </a>
                        @endif
                        
                        @if($esNoLeida)
                        <!-- ✅ Este llama al método con parámetro -->
                        <button wire:click="marcarComoLeida('{{ $notificacion->id }}')"
                                class="px-3 py-1 border border-gray-300 text-gray-700 text-sm font-medium rounded hover:bg-gray-50 transition-colors">
                            Marcar como leída
                        </button>
                        @else
                        <!-- ✅ Este también llama al método con parámetro -->
                        <button wire:click="marcarComoNoLeida('{{ $notificacion->id }}')"
                                class="px-3 py-1 border border-gray-300 text-gray-700 text-sm font-medium rounded hover:bg-gray-50 transition-colors">
                            Marcar como no leída
                        </button>
                        @endif
                        
                        <!-- ✅ Este también con parámetro -->
                        <button wire:click="eliminarNotificacion('{{ $notificacion->id }}')"
                                class="px-3 py-1 text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                @if($mostrarSoloNoLeidas)
                    No hay notificaciones no leídas
                @else
                    No hay notificaciones
                @endif
            </div>
        @endforelse
    </div>

    <!-- Acciones masivas -->
    @if($notificaciones->count() > 0)
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Mostrando {{ $notificacionesAMostrar->count() }} notificaciones
            </div>
            <div class="flex gap-4">
                @if($notificacionesNoLeidas->count() > 0)
                <!-- ✅ CAMBIADO: Ahora llama al método CORRECTO sin parámetro -->
                <button wire:click="marcarTodasComoLeidas" 
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    <i class="fas fa-check-double mr-1"></i>
                    Marcar todas como leídas
                </button>
                @endif
                
                @if($notificacionesLeidas->count() > 0)
                <!-- ✅ Este NO necesita parámetro -->
                <button wire:click="eliminarTodasLeidas" 
                        class="text-sm text-red-600 hover:text-red-800 font-medium">
                    <i class="fas fa-trash mr-1"></i>
                    Eliminar leídas
                </button>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>