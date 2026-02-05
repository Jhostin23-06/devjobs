<div class="p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
        <i class="fas fa-edit text-indigo-500 mr-2"></i>
        Editar Información del Perfil
    </h3>

    <form wire:submit.prevent="actualizarPerfil" id="edit-profile-form">
        <!-- Foto de perfil -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-4">
                <i class="fas fa-camera text-indigo-500 mr-2"></i>
                Foto de Perfil
            </label>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Vista previa -->
                <div class="relative">
                    <div class="w-32 h-32 rounded-2xl overflow-hidden border-4 border-indigo-100">
                        @if($user->foto_perfil)
                        <img src="{{ asset('storage/fotos_perfil/' . $user->foto_perfil) }}"
                            alt="Foto de perfil"
                            class="w-full h-full object-cover">
                        @elseif($foto_perfil)
                        <img src="{{ $foto_perfil->temporaryUrl() }}"
                            alt="Vista previa"
                            class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                            <span class="text-3xl font-bold text-indigo-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    @if($user->foto_perfil)
                    <button type="button"
                        wire:click="eliminarFotoPerfil"
                        onclick="return confirm('¿Estás seguro de eliminar tu foto de perfil?')"
                        class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors duration-300">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                    @endif
                </div>

                <!-- Upload de foto -->
                <div class="flex-1">
                    <label class="block mb-3">
                        <input type="file"
                            wire:model="foto_perfil"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-3 file:px-4
                                      file:rounded-xl file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100
                                      cursor-pointer">
                    </label>
                    @error('foto_perfil')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500">Recomendado: 500x500px, formato PNG o JPG (max 2MB)</p>

                    @if($foto_perfil)
                    <button type="button"
                        wire:click="$set('foto_perfil', null)"
                        class="mt-3 px-3 py-1 text-sm text-red-600 hover:text-red-800 flex items-center">
                        <i class="fas fa-times mr-1"></i>
                        Cancelar subida
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas fa-eye text-indigo-500 mr-2"></i>
                Visibilidad del Perfil
            </h4>

            <div class="space-y-3">
                <!-- Username único -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-at text-indigo-500 mr-2"></i>
                        Nombre de usuario (para tu perfil público)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">https://devjobs-app.domcloud.dev/perfiles/</span>
                        </div>
                        <input type="text"
                            wire:model.defer="username"
                            placeholder="tu-usuario"
                            class="w-full px-4 py-3 pl-48 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    </div>
                    @error('username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500 mt-2">
                        Este será tu enlace público: <span class="font-medium">https://devjobs-app.domcloud.dev/perfiles/<span x-text="$wire.username || 'tu-usuario'"></span></span>
                    </p>
                </div>

                <!-- Visibilidad -->
                <div>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox"
                                wire:model.defer="perfil_publico"
                                class="sr-only">
                            <div class="block bg-gray-200 w-14 h-8 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform {{ $perfil_publico ? 'translate-x-6 bg-green-500' : '' }}"></div>
                        </div>
                        <div>
                            <span class="text-gray-700 font-medium">
                                Perfil público
                            </span>
                            <p class="text-sm text-gray-500">
                                {{ $perfil_publico ? 'Tu perfil es visible para todos' : 'Tu perfil es privado, solo tú puedes verlo' }}
                            </p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Información básica -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Columna izquierda -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-indigo-500 mr-2"></i>
                        Nombre Completo *
                    </label>
                    <input type="text"
                        wire:model.defer="name"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                        Correo Electrónico *
                    </label>
                    <input type="email"
                        wire:model.defer="email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone text-indigo-500 mr-2"></i>
                        Teléfono
                    </label>
                    <input type="tel"
                        wire:model.defer="telefono"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('telefono') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                        Dirección
                    </label>
                    <input type="text"
                        wire:model.defer="direccion"
                        placeholder="Calle, número, departamento"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('direccion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Columna derecha -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tie text-indigo-500 mr-2"></i>
                        Título Profesional
                    </label>
                    <input type="text"
                        wire:model.defer="titulo_profesional"
                        placeholder="Ej: Desarrollador Full Stack, Diseñador UX/UI"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('titulo_profesional') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building text-indigo-500 mr-2"></i>
                        Ubicación
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <input type="text"
                                wire:model.defer="ciudad"
                                placeholder="Ciudad"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                            @error('ciudad') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <input type="text"
                                wire:model.defer="pais"
                                placeholder="País"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                            @error('pais') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-link text-indigo-500 mr-2"></i>
                        Sitio Web
                    </label>
                    <input type="url"
                        wire:model.defer="website"
                        placeholder="https://tu-sitio-web.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('website') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Biografía -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                Biografía
            </label>
            <textarea wire:model.defer="biografia"
                rows="4"
                placeholder="Cuéntanos sobre ti, tu experiencia, intereses profesionales..."
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"></textarea>
            @error('biografia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            <p class="text-xs text-gray-500 mt-2">Máximo 1000 caracteres</p>
        </div>

        <!-- Redes sociales -->
        <div class="mb-8">
            <h4 class="font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas fa-share-alt text-indigo-500 mr-2"></i>
                Redes Sociales
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-linkedin text-blue-600 mr-2"></i>
                        LinkedIn
                    </label>
                    <input type="url"
                        wire:model.defer="linkedin"
                        placeholder="https://linkedin.com/in/tu-usuario"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('linkedin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-github text-gray-800 mr-2"></i>
                        GitHub
                    </label>
                    <input type="url"
                        wire:model.defer="github"
                        placeholder="https://github.com/tu-usuario"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('github') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-twitter text-blue-400 mr-2"></i>
                        Twitter / X
                    </label>
                    <input type="url"
                        wire:model.defer="twitter"
                        placeholder="https://twitter.com/tu-usuario"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300">
                    @error('twitter') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-instagram text-pink-600 mr-2"></i>
                        Instagram (opcional)
                    </label>
                    <input type="url"
                        placeholder="https://instagram.com/tu-usuario"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300"
                        disabled>
                    <p class="text-xs text-gray-500 mt-1">Próximamente</p>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <button type="button"
                onclick="closeModal('editar-perfil')"
                class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium">
                Cancelar
            </button>
            <button type="submit"
                wire:loading.attr="disabled"
                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50">
                <span wire:loading.remove wire:target="actualizarPerfil">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cambios
                </span>
                <span wire:loading wire:target="actualizarPerfil">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Guardando...
                </span>
            </button>
        </div>
    </form>
</div>