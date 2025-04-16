<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Errores --}}
                @if($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('superadmin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nombre</label>
                        <input id="name" type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input id="email" type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" />
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">
                            Contraseña (déjala en blanco para conservar la actual)
                        </label>
                        <input id="password" type="password"
                               name="password"
                               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" />
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password"
                               name="password_confirmation"
                               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" />
                    </div>

                    {{-- Tipo de Usuario --}}
                    <div class="mb-4">
                        <label for="type_user_id" class="block text-gray-700">Tipo de Usuario</label>
                        <select id="type_user_id" name="type_user_id" required
                                class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                            @foreach($typeUsers as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('type_user_id', $user->type_user_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Estado --}}
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700">Estado</label>
                        <select id="status" name="status" required
                                class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                            <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    {{-- Compañía --}}
                    <div class="mb-4">
                        <label for="company_id" class="block text-gray-700">Compañía</label>
                        <select id="company_id" name="company_id"
                                class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                            <option value="">— Ninguna —</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botón de envío --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
