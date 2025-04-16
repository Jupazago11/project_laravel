<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Mostrar mensajes de error -->
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('superadmin.users.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Contraseña</label>
                        <input type="password" name="password" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
                    </div>

                    <!-- Select dinámico para Tipo de Usuario -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Usuario</label>
                        <select name="type_user_id" class="w-full border p-2 rounded" required>
                            <option value="">Seleccione un tipo...</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_user_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select para Estado (Status) -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Estado</label>
                        <select name="status" class="w-full border p-2 rounded" required>
                            <option value="">Seleccione un estado...</option>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
