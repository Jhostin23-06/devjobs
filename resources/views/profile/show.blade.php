<x-app-layout>

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Encabezado -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <!-- Foto de perfil -->
                <div class="mb-4 md:mb-0 md:mr-6">
                    @if(auth()->user()->foto_perfil)
                        <img src="{{ asset('storage/fotos_perfil/' . auth()->user()->foto_perfil) }}" 
                             alt="Foto de perfil" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-blue-100">
                    @else
                        <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-4xl text-blue-600 font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Información básica -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                    @if(auth()->user()->titulo_profesional)
                        <p class="text-xl text-blue-600 mt-2">{{ auth()->user()->titulo_profesional }}</p>
                    @endif
                    
                    <div class="mt-4 flex flex-wrap gap-4">
                        @if(auth()->user()->email)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-envelope mr-2"></i>
                                {{ auth()->user()->email }}
                            </div>
                        @endif
                        
                        @if(auth()->user()->telefono)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-phone mr-2"></i>
                                {{ auth()->user()->telefono }}
                            </div>
                        @endif
                        
                        @if(auth()->user()->ciudad)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ auth()->user()->ciudad }}, {{ auth()->user()->pais }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Redes sociales -->
                    @if(auth()->user()->linkedin || auth()->user()->github || auth()->user()->website)
                        <div class="mt-4 flex gap-3">
                            @if(auth()->user()->linkedin)
                                <a href="{{ auth()->user()->linkedin }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                                    <i class="fab fa-linkedin text-xl"></i>
                                </a>
                            @endif
                            @if(auth()->user()->github)
                                <a href="{{ auth()->user()->github }}" target="_blank" class="text-gray-800 hover:text-black">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                            @endif
                            @if(auth()->user()->website)
                                <a href="{{ auth()->user()->website }}" target="_blank" class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-globe text-xl"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                
                <!-- Botón editar -->
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('profile.edit') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-edit mr-2"></i> Editar Perfil
                    </a>
                </div>
            </div>
            
            <!-- Biografía -->
            @if(auth()->user()->biografia)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Sobre mí</h2>
                    <p class="text-gray-700 leading-relaxed">{{ auth()->user()->biografia }}</p>
                </div>
            @endif
        </div>
        
        <!-- Secciones de perfil -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Habilidades -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Habilidades</h2>
                    <a href="{{ route('profile.edit') }}#habilidades" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-plus mr-1"></i> Editar
                    </a>
                </div>
                
                @if(auth()->user()->habilidades->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach(auth()->user()->habilidades as $habilidad)
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                {{ $habilidad->nombre }}
                                <span class="text-xs text-blue-600 ml-1">
                                    (Nivel: {{ $habilidad->pivot->nivel }}/5)
                                </span>
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No has agregado habilidades aún.</p>
                @endif
            </div>
            
            <!-- Experiencia -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Experiencia Laboral</h2>
                    <button onclick="mostrarModalExperiencia()" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-plus mr-1"></i> Agregar
                    </button>
                </div>
                
                @if(auth()->user()->experiencias->count() > 0)
                    <div class="space-y-4">
                        @foreach(auth()->user()->experiencias as $experiencia)
                            <div class="border-l-4 border-blue-500 pl-4 py-2">
                                <h3 class="font-semibold text-gray-800">{{ $experiencia->puesto }}</h3>
                                <p class="text-gray-600">{{ $experiencia->empresa }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($experiencia->fecha_inicio)->format('M Y') }} - 
                                    @if($experiencia->trabajo_actual)
                                        Presente
                                    @elseif($experiencia->fecha_fin)
                                        {{ \Carbon\Carbon::parse($experiencia->fecha_fin)->format('M Y') }}
                                    @endif
                                </p>
                                @if($experiencia->descripcion)
                                    <p class="text-gray-700 mt-2">{{ Str::limit($experiencia->descripcion, 150) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No has agregado experiencia laboral.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar experiencia (puedes hacerlo similar para educación) -->
<div id="modalExperiencia" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Agregar Experiencia</h3>
            <button onclick="cerrarModalExperiencia()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="{{ route('profile.storeExperiencia') }}" method="POST">
            @csrf
            <!-- Campos del formulario -->
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function mostrarModalExperiencia() {
    document.getElementById('modalExperiencia').classList.remove('hidden');
}

function cerrarModalExperiencia() {
    document.getElementById('modalExperiencia').classList.add('hidden');
}
</script>
@endpush

</x-app-layout>