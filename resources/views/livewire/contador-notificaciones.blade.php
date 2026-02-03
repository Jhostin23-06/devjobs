@auth
    @can('create', App\Models\Vacante::class)
        <a href="{{ route('notificaciones') }}" 
           class="mr-2 relative w-7 h-7 {{ $contador > 0 ? 'animate-bounce' : '' }} bg-indigo-600 hover:bg-indigo-800 rounded-full flex flex-col justify-center items-center text-sm font-extrabold text-white transition-colors">
            
            @if($contador > 0)
                <span>{{ $contador }}</span>
            @else
                <span class="text-xs">0</span>
            @endif
        </a>
    @endcan
@endauth