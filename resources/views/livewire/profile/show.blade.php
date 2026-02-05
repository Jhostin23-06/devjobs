<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Encabezado del perfil -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Foto de perfil -->
            <div class="relative group">
                <div class="w-40 h-40 rounded-2xl overflow-hidden border-4 border-indigo-100">
                    @if($user->foto_perfil)
                    <img src="{{ asset('storage/fotos_perfil/' . $user->foto_perfil) }}"
                        alt="Foto de perfil"
                        class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                        <span class="text-5xl font-bold text-indigo-600">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Información básica -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>

                @if($user->titulo_profesional)
                <p class="text-lg text-indigo-600 font-semibold mb-3">{{ $user->titulo_profesional }}</p>
                @endif

                <!-- Redes sociales -->
                <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-4">
                    @if($user->email)
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                        <span class="text-sm">{{ $user->email }}</span>
                    </div>
                    @endif

                    @if($user->telefono)
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone text-indigo-500 mr-2"></i>
                        <span class="text-sm">{{ $user->telefono }}</span>
                    </div>
                    @endif

                    @if($user->ciudad)
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                        <span class="text-sm">{{ $user->ciudad }}{{ $user->pais ? ', ' . $user->pais : '' }}</span>
                    </div>
                    @endif
                </div>

                <!-- Enlaces redes sociales -->
                <div class="flex gap-3 justify-center md:justify-start">
                    @if($user->linkedin)
                    <a href="{{ $user->linkedin }}" target="_blank"
                        class="text-gray-600 hover:text-blue-700 transition-colors duration-300">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                    @endif
                    @if($user->github)
                    <a href="{{ $user->github }}" target="_blank"
                        class="text-gray-600 hover:text-gray-900 transition-colors duration-300">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    @endif
                    @if($user->twitter)
                    <a href="{{ $user->twitter }}" target="_blank"
                        class="text-gray-600 hover:text-blue-400 transition-colors duration-300">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    @endif
                    @if($user->website)
                    <a href="{{ $user->website }}" target="_blank"
                        class="text-gray-600 hover:text-green-600 transition-colors duration-300">
                        <i class="fas fa-globe text-xl"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col gap-3">
                <button onclick="openModal('editar-perfil')"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Perfil
                </button>

                <button
                    onclick="openModal('cambiar-password')"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                    <i class="fas fa-key mr-2"></i>
                    Cambiar Contraseña
                </button>
            </div>
        </div>

        <!-- Biografía -->
        @if($user->biografia)
        <div class="mt-8 pt-8 border-t border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user-circle text-indigo-500 mr-3"></i>
                Sobre mí
            </h2>
            <p class="text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-xl border border-gray-100">
                {{ $user->biografia }}
            </p>
        </div>
        @endif
    </div>

    <!-- Grid de secciones -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Sección de Habilidades - VERSIÓN MEJORADA -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-code text-indigo-500 mr-3"></i>
                    Mis Habilidades
                </h2>
                <button onclick="openModal('habilidades')"
                    class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg font-medium hover:bg-indigo-200 transition-colors duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Gestionar
                </button>
            </div>

            @if(count($habilidades) > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($habilidades as $habilidad)
                @php
                $nivel = $habilidad->pivot->nivel ?? 1;
                $nivelColor = $nivel >= 4 ? 'green' : ($nivel >= 3 ? 'blue' : 'amber');
                $nivelText = $nivel >= 4 ? 'Avanzado' : ($nivel >= 3 ? 'Intermedio' : 'Básico');
                @endphp

                <div class="relative group skill-card" data-level="{{ $nivelText }}">
                    <div class="bg-gray-50 hover:bg-white p-4 rounded-xl border border-gray-100 hover:border-indigo-200 transition-all duration-300 shadow-sm hover:shadow-md">
                        <!-- Header de la habilidad -->
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-semibold text-gray-800 text-sm truncate">{{ $habilidad->nombre }}</span>
                            <span class="text-xs font-bold px-2 py-1 rounded-full bg-{{ $nivelColor }}-100 text-{{ $nivelColor }}-700">
                                {{ $nivel }}/5
                            </span>
                        </div>

                        <!-- Barra de progreso compacta -->
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                            <div class="bg-gradient-to-r from-{{ $nivelColor }}-500 to-{{ $nivelColor }}-400 h-1.5 rounded-full"
                                style="width: {{ ($nivel / 5) * 100 }}%"></div>
                        </div>

                        <!-- Info adicional -->
                        <div class="flex justify-between items-center text-xs text-gray-500 mt-1">
                            <span class="truncate">{{ $nivelText }}</span>
                            @if($habilidad->pivot->experiencia_meses)
                            <span class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $habilidad->pivot->experiencia_meses }}m
                            </span>
                            @endif
                        </div>

                        <!-- Tooltip con detalles -->
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-900 text-white text-xs rounded py-2 px-3 whitespace-nowrap">
                                <div class="font-semibold">{{ $habilidad->nombre }}</div>
                                <div>Nivel: {{ $nivelText }} ({{ $nivel }}/5)</div>
                                @if($habilidad->pivot->experiencia_meses)
                                <div>Experiencia: {{ $habilidad->pivot->experiencia_meses }} meses</div>
                                @endif
                            </div>
                            <div class="w-3 h-3 bg-gray-900 transform rotate-45 absolute bottom-0 left-1/2 -translate-x-1/2 -mb-1.5"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contador -->
            <div class="text-center mt-4 text-sm text-gray-500">
                <span class="font-medium">{{ count($habilidades) }}</span> habilidades mostradas
            </div>

            @else
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-code text-2xl text-indigo-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No has agregado habilidades aún</h3>
                <p class="text-gray-500 mb-4">Agrega tus habilidades para destacar tu perfil profesional</p>
                <button onclick="openModal('habilidades')"
                    class="px-5 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg font-medium hover:from-indigo-600 hover:to-purple-600 transition-all duration-300 flex items-center mx-auto">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar Habilidades
                </button>
            </div>
            @endif
        </div>

        <!-- Sección de Experiencia -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-briefcase text-indigo-500 mr-3"></i>
                    Experiencia Laboral
                </h2>
                <button onclick="openModal('experiencia')"
                    class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg font-medium hover:bg-indigo-200 transition-colors duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar
                </button>
            </div>

            @if(count($experiencias) > 0)
            <div class="space-y-6">
                @foreach($experiencias as $experiencia)
                <div class="relative pl-8 pb-6 border-l-2 border-indigo-200">
                    <div class="absolute -left-2 top-0 w-4 h-4 bg-indigo-500 rounded-full border-4 border-white"></div>
                    <div class="mb-2">
                        <h3 class="font-bold text-lg text-gray-900">{{ $experiencia->puesto }}</h3>
                        <p class="text-gray-700 font-medium">{{ $experiencia->empresa }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="far fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($experiencia->fecha_inicio)->format('M Y') }} -
                            @if($experiencia->trabajo_actual)
                            <span class="text-green-600 font-semibold">Presente</span>
                            @elseif($experiencia->fecha_fin)
                            {{ \Carbon\Carbon::parse($experiencia->fecha_fin)->format('M Y') }}
                            @endif
                        </p>
                        @if($experiencia->ubicacion)
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $experiencia->ubicacion }}
                        </p>
                        @endif
                    </div>
                    @if($experiencia->descripcion)
                    <p class="text-gray-600 text-sm bg-gray-50 p-4 rounded-lg border border-gray-100">
                        {{ $experiencia->descripcion }}
                    </p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-briefcase text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">No has agregado experiencia laboral</p>
                <button onclick="openModal('experiencia')"
                    class="mt-4 px-4 py-2 text-indigo-600 font-medium hover:text-indigo-700">
                    Agrega tu primera experiencia
                </button>
            </div>
            @endif
        </div>

        <!-- Sección de Educación -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-graduation-cap text-indigo-500 mr-3"></i>
                    Educación
                </h2>
                <button onclick="openModal('educacion')"
                    class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg font-medium hover:bg-indigo-200 transition-colors duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar
                </button>
            </div>

            @if(count($educaciones) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($educaciones as $educacion)
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-2xl border border-indigo-100">
                    <div class="mb-4">
                        <h3 class="font-bold text-lg text-gray-900">{{ $educacion->titulo }}</h3>
                        <p class="text-gray-700 font-medium">{{ $educacion->institucion }}</p>
                        @if($educacion->campo_estudio)
                        <p class="text-gray-600 text-sm">{{ $educacion->campo_estudio }}</p>
                        @endif
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="far fa-calendar mr-2"></i>
                        {{ \Carbon\Carbon::parse($educacion->fecha_inicio)->format('M Y') }} -
                        @if($educacion->estudiando_actualmente)
                        <span class="text-green-600 font-semibold ml-1">Presente</span>
                        @elseif($educacion->fecha_fin)
                        {{ \Carbon\Carbon::parse($educacion->fecha_fin)->format('M Y') }}
                        @endif
                    </div>
                    @if($educacion->descripcion)
                    <p class="text-gray-600 text-sm mt-3 border-t border-gray-200 pt-3">
                        {{ Str::limit($educacion->descripcion, 150) }}
                    </p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-graduation-cap text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">No has agregado formación académica</p>
                <button onclick="openModal('educacion')"
                    class="mt-4 px-4 py-2 text-indigo-600 font-medium hover:text-indigo-700">
                    Agrega tu primera educación
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- MODALES PARA LOS FORMULARIOS -->

    <!-- Modal para Habilidades -->
    <x-modal name="habilidades" maxWidth="4xl">
        <livewire:profile.habilidades-form />
    </x-modal>

    <!-- Modal para Experiencia -->
    <x-modal name="experiencia" maxWidth="2xl">
        <livewire:profile.experiencia-form />
    </x-modal>

    <!-- Modal para Educación -->
    <x-modal name="educacion" maxWidth="2xl">
        <livewire:profile.educacion-form />
    </x-modal>

    <x-modal name="editar-perfil" maxWidth="4xl">
        <livewire:profile.edit />
    </x-modal>

    <!-- Modal para Cambiar Contraseña -->
    <x-modal name="cambiar-password" maxWidth="2xl">
        <livewire:profile.update-password />
    </x-modal>

</div>


@push('styles')
<style>
    /* Animaciones suaves */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* Gradientes personalizados */
    .bg-gradient-to-br {
        background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
    }

    /* Barras de progreso */
    .h-2\.5 {
        height: 0.625rem;
    }

    /* Tamaños de fuente responsivos */
    @media (max-width: 640px) {
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-5xl {
            font-size: 3rem;
            line-height: 1;
        }
    }
    
</style>
@endpush