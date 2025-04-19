<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Proveedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('administrador.providers.update', $provider) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-gray-700">Nombre</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $provider->name) }}"
                                class="w-full border p-2 rounded"
                                required
                            >
                        </div>

                        <!-- NIT -->
                        <div>
                            <label class="block text-gray-700">NIT</label>
                            <input
                                type="text"
                                name="nit"
                                value="{{ old('nit', $provider->nit) }}"
                                class="w-full border p-2 rounded"
                            >
                        </div>

                        <!-- Dirección -->
                        <div>
                            <label class="block text-gray-700">Dirección</label>
                            <input
                                type="text"
                                name="address"
                                value="{{ old('address', $provider->address) }}"
                                class="w-full border p-2 rounded"
                            >
                        </div>

                        <!-- Contacto -->
                        <div>
                            <label class="block text-gray-700">Contacto</label>
                            <input
                                type="text"
                                name="contact"
                                value="{{ old('contact', $provider->contact) }}"
                                class="w-full border p-2 rounded"
                            >
                        </div>

                        <!-- Nombre Empleado -->
                        <div>
                            <label class="block text-gray-700">Nombre de contacto interno</label>
                            <input
                                type="text"
                                name="employee_name"
                                value="{{ old('employee_name', $provider->employee_name) }}"
                                class="w-full border p-2 rounded"
                            >
                        </div>

                        <!-- Teléfono Empleado -->
                        <div>
                            <label class="block text-gray-700">Teléfono de contacto interno</label>
                            <input
                                type="text"
                                name="employee_phone"
                                value="{{ old('employee_phone', $provider->employee_phone) }}"
                                class="w-full border p-2 rounded"
                            >
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-gray-700">Estado</label>
                            <select
                                name="status"
                                class="w-full border p-2 rounded"
                                required
                            >
                                <option value="1" {{ old('status', $provider->status) == '1' ? 'selected' : '' }}>
                                    Activo
                                </option>
                                <option value="0" {{ old('status', $provider->status) == '0' ? 'selected' : '' }}>
                                    Inactivo
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
