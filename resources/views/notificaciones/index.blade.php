<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                    Mis Notificaciones
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Gestiona todas tus alertas y notificaciones
                </p>
            </div>
        
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mostrar mensajes flash -->
            @if(session('mensaje'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('mensaje') }}
            </div>
            @endif

            <!-- Componente Livewire -->
            <livewire:gestionar-notificaciones />
        </div>
    </div>

    <!-- Estilos adicionales -->
    <style>
        /* Animaciones */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        /* Efecto hover para notificaciones no leídas */
        .hover\:bg-indigo-50\/50:hover {
            background-color: rgba(238, 242, 255, 0.5);
        }

        /* Dropdown de acciones */
        .group-hover\/actions\:block {
            display: block !important;
        }

        /* Transiciones suaves */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .flex-col {
                flex-direction: column;
            }
            
            .gap-6 {
                gap: 1rem;
            }
        }
    </style>

    <!-- Scripts -->
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

            // Notificación de éxito para acciones
            Livewire.on('notificacionMarcada', function(message) {
                // Puedes agregar un toast notification aquí
                console.log(message);
            });
        });
    </script>
</x-app-layout>