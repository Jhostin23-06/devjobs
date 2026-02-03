<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header de la vacante -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="p-6">
                <!-- Ruta de navegación -->
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('vacantes.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600">
                                <i class="fas fa-home mr-2"></i>
                                Vacantes
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">{{ $vacante->titulo }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Información principal -->
                <div class="flex flex-col md:flex-row md:items-start md:space-x-6">
                    <!-- Logo empresa - AHORA MÁS GRANDE -->
                    <div class="flex-shrink-0 mb-4 md:mb-0">
                        <div class="w-52 h-36 rounded-lg bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center mr-3">
                            @if($vacante->imagen)
                            <img src="{{ asset('storage/vacantes/' . $vacante->imagen ) }}"
                                alt="{{'Logo ' . $vacante->empresa}}"
                                class="w-52 h-36 rounded-lg object-cover">
                            @else
                            <span class="text-xs font-bold text-indigo-600">{{ substr($vacante->empresa, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Detalles principales -->
                    <div class="flex-grow">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                            <div class="flex-grow">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $vacante->titulo }}</h1>
                                <div class="flex items-center text-gray-600 mb-4">
                                    <i class="fas fa-building mr-2"></i>
                                    <span class="font-medium">{{ $vacante->empresa }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>Remoto</span>
                                </div>
                            </div>

                        </div>

                        <!-- Badges informativos -->
                        <div class="flex flex-wrap gap-3 mb-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-bolt mr-2"></i>
                                Nuevo puesto
                            </span>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-clock mr-2"></i>
                                Vence: {{ $vacante->ultimo_dia->format('d/m/Y') }}
                            </span>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                {{ $vacante->salario->salario }}
                            </span>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                <i class="fas fa-tag mr-2"></i>
                                {{ $vacante->categoria->categoria }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna izquierda - Descripción + Guest/Postulación -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Descripción del puesto -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-indigo-600"></i>
                        Descripción del Puesto
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($vacante->descripcion)) !!}
                    </div>
                </div>
            </div>



            <!-- Columna derecha - Solo detalles y compartir -->
            <div class="space-y-6">
                <!-- Panel de detalles -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Detalles de la Vacante</h3>

                    <div class="space-y-4">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-calendar-alt text-indigo-600 w-6"></i>
                            <span class="ml-3">Publicado: {{ $vacante->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-clock text-indigo-600 w-6"></i>
                            <span class="ml-3">Vence: {{ $vacante->ultimo_dia->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-money-bill-wave text-indigo-600 w-6"></i>
                            <span class="ml-3">{{ $vacante->salario->salario }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-tag text-indigo-600 w-6"></i>
                            <span class="ml-3">{{ $vacante->categoria->categoria }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-briefcase text-indigo-600 w-6"></i>
                            <span class="ml-3">Tiempo completo</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt text-indigo-600 w-6"></i>
                            <span class="ml-3">Remoto (Perú)</span>
                        </div>
                    </div>
                </div>

                <!-- Compartir -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Compartir esta vacante</h3>
                    <div class="flex space-x-3">
                        <button class="flex-1 flex flex-col items-center justify-center p-3 rounded-lg border border-gray-300 hover:bg-gray-50 transition hover:shadow-md">
                            <i class="fab fa-linkedin text-blue-600 text-xl mb-2"></i>
                            <span class="text-sm font-medium">LinkedIn</span>
                        </button>
                        <button class="flex-1 flex flex-col items-center justify-center p-3 rounded-lg border border-gray-300 hover:bg-gray-50 transition hover:shadow-md">
                            <i class="fab fa-twitter text-blue-400 text-xl mb-2"></i>
                            <span class="text-sm font-medium">Twitter</span>
                        </button>
                        <button class="flex-1 flex flex-col items-center justify-center p-3 rounded-lg border border-gray-300 hover:bg-gray-50 transition hover:shadow-md">
                            <i class="fas fa-envelope text-red-500 text-xl mb-2"></i>
                            <span class="text-sm font-medium">Email</span>
                        </button>
                    </div>
                </div>

            </div>


        </div>

        <!-- Sección de Guest/Postulación - AHORA DEBAJO DE DESCRIPCIÓN -->
        <div class="bg-gradient-to-r bg-white rounded-xl shadow-lg p-6 text-slate-800 mt-5">
            <div class="text-center mb-4">
                <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-briefcase text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">¿Te interesa este puesto?</h3>
                <p class="text-slate-700">Postula ahora y sé parte de nuestro equipo</p>
            </div>

            @guest
            <div class="space-y-4 flex flex-col items-center">
                <a href="{{ route('register') }}" class=" bg-slate-100 text-indigo-600 font-bold py-4 px-4 rounded-xl text-center hover:bg-gray-100 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-user-plus mr-2"></i>
                    Crear cuenta y postular
                </a>
                <div class="pt-2">
                    <p class="text-sm text-indigo-600 mb-3">¿Ya tienes una cuenta?</p>
                    <a href="{{ route('login') }}" class="block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-xl text-center border border-indigo-400 transition duration-300 hover:shadow-md">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Iniciar sesión
                    </a>
                </div>
            </div>
            @else
            <!-- Para usuarios autenticados que no son reclutadores -->
            @cannot('create', App\Models\Vacante::class)
            <div class="mt-4">
                <livewire:postular-vacante :vacante="$vacante" />
            </div>
            @else
            <!-- Mensaje para reclutadores -->
            <div class="text-center py-4">
                <p class="text-indigo-200">
                    <i class="fas fa-info-circle mr-2"></i>
                    Esta es tu vacante publicada
                </p>
            </div>
            @endcannot
            @endguest
        </div>
    </div>
</div>

<!-- Agregar FontAwesome CDN en tu layout principal si no lo tienes -->
<style>
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .prose ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .prose li {
        margin-bottom: 0.25rem;
    }

    .btn-favorite:hover i {
        color: #ef4444;
    }

    .btn-share:hover i {
        color: #0a66c2;
    }

    /* Mejoras para el diseño responsive */
    @media (max-width: 768px) {
        .flex-col.md\:flex-row {
            flex-direction: column;
        }

        .md\:space-x-6 {
            margin-left: 0;
        }

        .w-32,
        .h-32 {
            width: 120px;
            height: 120px;
        }

        .w-28,
        .h-28 {
            width: 100px;
            height: 100px;
        }
    }
</style>