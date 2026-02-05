<x-app-layout>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Encabezado del perfil -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Foto de perfil -->
                <div class="relative">
                    <div class="w-40 h-40 rounded-2xl overflow-hidden border-4 border-indigo-100">
                        @if($usuario->foto_perfil)
                        <img src="{{ asset('storage/fotos_perfil/' . $usuario->foto_perfil) }}"
                            alt="Foto de perfil de {{ $usuario->name }}"
                            class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                            <span class="text-5xl font-bold text-indigo-600">
                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Badge de perfil público/privado -->
                    <div class="absolute -top-2 -right-2">
                        @if($usuario->perfil_publico)
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <i class="fas fa-globe-americas mr-1"></i> Público
                        </span>
                        @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                            <i class="fas fa-lock mr-1"></i> Privado
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Información básica -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $usuario->name }}</h1>

                            @if($usuario->titulo_profesional)
                            <p class="text-lg text-indigo-600 font-semibold mb-3">{{ $usuario->titulo_profesional }}</p>
                            @endif

                            <!-- Ubicación -->
                            @if($usuario->ciudad)
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                                <span class="text-sm">{{ $usuario->ciudad }}{{ $usuario->pais ? ', ' . $usuario->pais : '' }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Botón de contacto (para reclutadores) -->
                        @if(auth()->check() && auth()->user()->rol === 'reclutador' && !$esMiPerfil)
                        <div>
                            <button onclick="openModal('contactar-{{ $usuario->id }}')"
                                class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg font-medium hover:from-green-600 hover:to-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                Contactar
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- Redes sociales -->
                    <div class="flex gap-3 justify-center md:justify-start mt-4">
                        @if($usuario->linkedin)
                        <a href="{{ $usuario->linkedin }}" target="_blank"
                            class="text-gray-600 hover:text-blue-700 transition-colors duration-300"
                            title="LinkedIn">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        @endif
                        @if($usuario->github)
                        <a href="{{ $usuario->github }}" target="_blank"
                            class="text-gray-600 hover:text-gray-900 transition-colors duration-300"
                            title="GitHub">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                        @endif
                        @if($usuario->twitter)
                        <a href="{{ $usuario->twitter }}" target="_blank"
                            class="text-gray-600 hover:text-blue-400 transition-colors duration-300"
                            title="Twitter/X">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        @endif
                        @if($usuario->website)
                        <a href="{{ $usuario->website }}" target="_blank"
                            class="text-gray-600 hover:text-green-600 transition-colors duration-300"
                            title="Sitio Web">
                            <i class="fas fa-globe text-xl"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Biografía -->
            @if($usuario->biografia)
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-indigo-500 mr-3"></i>
                    Sobre mí
                </h2>
                <p class="text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-xl border border-gray-100">
                    {{ $usuario->biografia }}
                </p>
            </div>
            @endif
        </div>

        <!-- Grid de secciones -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Sección de Habilidades -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-code text-indigo-500 mr-3"></i>
                    Habilidades
                </h2>

                @if($usuario->habilidades->count() > 0)

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($usuario->habilidades as $habilidad)
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
                    <span class="font-medium">{{ $usuario->habilidades->count() }}</span> habilidades mostradas
                </div>

                @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-code text-2xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No se han agregado habilidades</h3>
                    <p class="text-gray-500">Este perfil aún no ha agregado habilidades técnicas o profesionales</p>
                </div>
                @endif
            </div>

            <!-- Sección de Experiencia -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-briefcase text-indigo-500 mr-3"></i>
                    Experiencia Laboral
                </h2>

                @if($usuario->experiencias->count() > 0)
                <div class="space-y-6">
                    @foreach($usuario->experiencias->sortByDesc('fecha_inicio') as $experiencia)
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
                    <p class="text-gray-500">No se ha agregado experiencia laboral</p>
                </div>
                @endif
            </div>

            <!-- Sección de Educación -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-graduation-cap text-indigo-500 mr-3"></i>
                    Educación
                </h2>

                @if($usuario->educaciones->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($usuario->educaciones->sortByDesc('fecha_inicio') as $educacion)
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
                    <p class="text-gray-500">No se ha agregado formación académica</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>