<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
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

                <form method="POST" action="{{ route('superadmin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Contraseña (déjala en blanco para conservar la actual)</label>
                        <input type="password" name="password" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="w-full border p-2 rounded">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
