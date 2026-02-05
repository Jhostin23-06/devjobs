@props(['name', 'maxWidth' => '2xl'])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div id="modal-{{ $name }}" 
     class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 hidden"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
         onclick="closeModal('{{ $name }}')"></div>

    <div class="flex items-center justify-center min-h-fit">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
function openModal(modalName) {
    const modal = document.getElementById('modal-' + modalName);
    if (modal) {
        modal.classList.remove('hidden');
        // IMPORTANTE: Prevenir scroll del body cuando el modal está abierto
        document.body.classList.add('overflow-hidden');
        console.log('Modal abierto:', modalName);
    }
}

function closeModal(modalName) {
    const modal = document.getElementById('modal-' + modalName);
    if (modal) {
        modal.classList.add('hidden');
        // IMPORTANTE: Restaurar el scroll del body
        document.body.classList.remove('overflow-hidden');
        console.log('Modal cerrado y scroll restaurado:', modalName);
    }
}

// Para Livewire
window.addEventListener('open-modal', (event) => {
    openModal(event.detail);
});

window.addEventListener('close-modal', (event) => {
    closeModal(event.detail);
});

// Cerrar con Escape
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        // Cerrar todos los modales
        document.querySelectorAll('[id^="modal-"]').forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.classList.remove('overflow-hidden');
    }
});
</script>