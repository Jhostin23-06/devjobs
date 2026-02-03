<div wire:key="postulacion-form">
    @if (session()->has('mensaje'))
    <!-- Mensaje de éxito mejorado -->
    <div class="mb-6 animate-fade-in">
        <div class="bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 rounded-r-lg p-6 shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-emerald-900 mb-1">¡Postulación enviada!</h4>
                    <p class="text-emerald-800">{{ session('mensaje') }}</p>
                    <p class="text-sm text-emerald-700 mt-2">
                        <i class="fas fa-clock mr-1"></i>
                        Te contactaremos pronto
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Formulario de postulación -->
    <!-- El formulario SIEMPRE está presente, pero si hay mensaje de éxito, lo deshabilitamos -->
    <form wire:submit.prevent='postularme' class="space-y-6"
        @if(session()->has('mensaje'))
        style="opacity: 0.6; pointer-events: none;"
        @endif>
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <!-- Encabezado del formulario -->
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-file-pdf text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Sube tu currículum</h4>
                    <p class="text-sm text-gray-600">Archivo PDF (máximo 5MB)</p>
                </div>
            </div>

            <!-- Campo de archivo mejorado -->
            <div class="space-y-3">
                <div class="relative group">
                    <input
                        id="cv"
                        type="file"
                        wire:model="cv"
                        accept=".pdf"
                        class="hidden"
                        @if(session()->has('mensaje')) disabled @endif />

                    <!-- Área de arrastrar y soltar -->
                    <label for="cv"
                        class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-300 group-hover:border-indigo-400">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4">
                            <div class="w-16 h-16 mb-4 rounded-full bg-gradient-to-r from-indigo-100 to-blue-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-cloud-upload-alt text-2xl text-indigo-600"></i>
                            </div>
                            <p class="mb-2 text-sm text-gray-700">
                                <span class="font-semibold">Haz clic para subir</span> o arrastra tu archivo
                            </p>
                            <p class="text-xs text-gray-500">
                                Solo archivos PDF (máx. 5MB)
                            </p>
                            @if(!session()->has('mensaje'))
                            <div class="mt-4">
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                                    <i class="fas fa-folder-open"></i>
                                    Seleccionar archivo
                                </span>
                            </div>
                            @endif
                        </div>
                    </label>
                </div>

                <!-- Información del archivo seleccionado -->
                @if($cv && !session()->has('mensaje'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200 animate-fade-in">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-file-pdf text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $cv->getClientOriginalName() }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ number_format($cv->getSize() / 1024, 2) }} KB
                                </p>
                            </div>
                        </div>
                        <button
                            type="button"
                            wire:click="$set('cv', null)"
                            class="w-10 h-10 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition-colors flex items-center justify-center"
                            title="Eliminar archivo">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif
            </div>

            <!-- Errores de validación - SIEMPRE visible si hay error -->
            @error('cv')
            <div class="mt-4 animate-shake">
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-r-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @enderror
        </div>

        <!-- Botón de envío -->
        @if(!session()->has('mensaje'))
        <div class="text-center">
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="group relative inline-flex items-center justify-center gap-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-8 rounded-xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto min-w-[200px]">
                <!-- Spinner durante carga -->
                <span wire:loading wire:target="postularme" class="absolute left-4">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>

                <!-- Icono y texto -->
                <span wire:loading.remove wire:target="postularme">
                    <i class="fas fa-paper-plane"></i>
                </span>

                <span>
                    <span wire:loading.remove wire:target="postularme">Enviar Postulación</span>
                    <span wire:loading wire:target="postularme">Procesando...</span>
                </span>

                <!-- Flecha animada -->
                <span wire:loading.remove wire:target="postularme" class="group-hover:translate-x-1 transition-transform">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </button>
        </div>
        @endif

        <!-- Error de sesión -->
        @if (session()->has('error'))
        <div class="mt-4 animate-fade-in">
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-r-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-red-900 mb-1">¡Ups! Algo salió mal</h4>
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </form>
</div>

<!-- Estilos y animaciones -->
<style>
    /* Animaciones */
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        10%,
        30%,
        50%,
        70%,
        90% {
            transform: translateX(-5px);
        }

        20%,
        40%,
        60%,
        80% {
            transform: translateX(5px);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }

    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }

    /* Mejoras para el input file */
    input[type="file"]:focus+label {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Transiciones suaves */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* Efecto hover en el área de drop */
    label:hover {
        background-color: #f9fafb;
        border-color: #a5b4fc;
    }

    /* Mejoras responsive */
    @media (max-width: 768px) {
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }

        .md\:grid-cols-3 {
            grid-template-columns: 1fr;
        }

        .p-8 {
            padding: 1.5rem;
        }

        .w-96 {
            width: 100%;
        }
    }

    /* Estilo para el botón deshabilitado */
    button:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }
</style>

<script>
    // Mejorar la experiencia de arrastrar y soltar
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('cv');
        const dropArea = fileInput?.nextElementSibling;

        if (dropArea) {
            // Prevenir comportamientos por defecto
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Efectos visuales al arrastrar
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
            }

            function unhighlight() {
                dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
            }

            // Manejar archivos soltados
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    // Disparar evento change para que Livewire lo detecte
                    const event = new Event('change', {
                        bubbles: true
                    });
                    fileInput.dispatchEvent(event);
                }
            }
        }

        // Mostrar nombre del archivo seleccionado
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    console.log('Archivo seleccionado:', fileName);
                }
            });
        }
    });
</script>