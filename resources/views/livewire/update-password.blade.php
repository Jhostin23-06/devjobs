<div class="p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
        <i class="fas fa-key text-blue-500 mr-2"></i>
        Cambiar Contraseña
    </h3>
    
    <form wire:submit.prevent="actualizarPassword">
        <!-- Información importante -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="text-sm font-medium text-blue-800 mb-2">Requisitos de seguridad:</p>
                    <ul class="text-xs text-blue-700 space-y-1">
                        <li>• Mínimo 8 caracteres</li>
                        <li>• Diferente a tu contraseña actual</li>
                        <li>• Se recomienda usar mayúsculas, minúsculas, números y símbolos</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Contraseña actual -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-500 mr-2"></i>
                    Contraseña Actual *
                </label>
                <div class="relative">
                    <input type="password" 
                           wire:model="current_password"
                           class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                    <div class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                @error('current_password') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Nueva contraseña -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-green-500 mr-2"></i>
                    Nueva Contraseña *
                </label>
                <div class="relative">
                    <input type="password" 
                           wire:model="password"
                           class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                    <div class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                @error('password') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
                
                <!-- Indicador de fortaleza de contraseña -->
                <div class="mt-2">
                    @if($password)
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                @php
                                    $strength = 0;
                                    if (strlen($password) >= 8) $strength++;
                                    if (preg_match('/[A-Z]/', $password)) $strength++;
                                    if (preg_match('/[a-z]/', $password)) $strength++;
                                    if (preg_match('/[0-9]/', $password)) $strength++;
                                    if (preg_match('/[^A-Za-z0-9]/', $password)) $strength++;
                                    
                                    $width = $strength * 20;
                                    $color = match($strength) {
                                        1 => 'bg-red-500',
                                        2 => 'bg-orange-500',
                                        3 => 'bg-yellow-500',
                                        4 => 'bg-green-500',
                                        5 => 'bg-emerald-600',
                                        default => 'bg-gray-200',
                                    };
                                @endphp
                                <div class="h-full {{ $color }} transition-all duration-300" style="width: {{ $width }}%"></div>
                            </div>
                            <span class="text-xs font-medium {{ match($strength) {
                                1 => 'text-red-600',
                                2 => 'text-orange-600',
                                3 => 'text-yellow-600',
                                4 => 'text-green-600',
                                5 => 'text-emerald-700',
                                default => 'text-gray-500',
                            } }}">
                                @switch($strength)
                                    @case(1)
                                        Muy débil
                                        @break
                                    @case(2)
                                        Débil
                                        @break
                                    @case(3)
                                        Regular
                                        @break
                                    @case(4)
                                        Buena
                                        @break
                                    @case(5)
                                        Excelente
                                        @break
                                    @default
                                        Muy débil
                                @endswitch
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Confirmar contraseña -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-blue-500 mr-2"></i>
                    Confirmar Nueva Contraseña *
                </label>
                <div class="relative">
                    <input type="password" 
                           wire:model="password_confirmation"
                           class="w-full px-4 py-3 pl-11 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                    <div class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                @error('password_confirmation') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 mt-8">
            <button type="button" 
                    onclick="closeModal('cambiar-password')"
                    class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium">
                Cancelar
            </button>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50">
                <span wire:loading.remove wire:target="actualizarPassword">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Cambiar Contraseña
                </span>
                <span wire:loading wire:target="actualizarPassword">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Cambiando...
                </span>
            </button>
        </div>
    </form>
</div>