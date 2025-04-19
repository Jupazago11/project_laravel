<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Proveedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                {{-- Mostrar errores de validación --}}
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-sm text-red-600 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('administrador.providers.store') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required
                        />
                    </div>

                    {{-- NIT --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">NIT (opcional)</label>
                        <input
                            type="text"
                            name="nit"
                            value="{{ old('nit') }}"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                        />
                    </div>

                    {{-- Dirección --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Dirección (opcional)</label>
                        <input
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                        />
                    </div>

                    {{-- Contacto --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Contacto (opcional)</label>
                        <input
                            type="text"
                            name="contact"
                            value="{{ old('contact') }}"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                        />
                    </div>

                    {{-- Empleado Responsable --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Empleado Responsable (opcional)</label>
                        <input
                            type="text"
                            name="employee_name"
                            value="{{ old('employee_name') }}"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                        />
                    </div>

                    {{-- Teléfono Empleado --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Teléfono del Empleado (opcional)</label>
                        <input
                            type="text"
                            name="employee_phone"
                            value="{{ old('employee_phone') }}"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                        />
                    </div>

                    {{-- Estado --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Estado</label>
                        <select
                            name="status"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required
                        >
                            <option value="" disabled>{{ __('Seleccione un estado...') }}</option>
                            <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>
                                {{ __('Activo') }}
                            </option>
                            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                {{ __('Inactivo') }}
                            </option>
                        </select>
                    </div>

                    {{-- Botón Crear --}}
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition"
                        >
                            {{ __('Crear Proveedor') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
