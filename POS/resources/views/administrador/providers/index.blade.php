<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proveedores') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <!-- Barra superior: Buscador, Filtro y Botón “Nuevo registro” -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <!-- Search & Filter -->
                <div class="flex items-center gap-4 mb-2 sm:mb-0">
                    <form method="GET" action="{{ route('administrador.providers.index') }}" class="flex gap-4">
                        <!-- Campo de búsqueda -->
                        <div>
                            <input
                                type="text"
                                name="search"
                                placeholder="Buscar…"
                                value="{{ $search ?? '' }}"
                                class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300"
                                onchange="this.form.submit()"
                            />
                        </div>

                        <!-- Filtro de estado -->
                        <div>
                            <select
                                name="status_filter"
                                class="block w-full border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                                onchange="this.form.submit()"
                            >
                                <option value="">{{ __('Estado') }}</option>
                                <option value="1" {{ (isset($statusFilter) && $statusFilter == '1') ? 'selected' : '' }}>
                                    {{ __('Activo') }}
                                </option>
                                <option value="0" {{ (isset($statusFilter) && $statusFilter == '0') ? 'selected' : '' }}>
                                    {{ __('Inactivo') }}
                                </option>
                            </select>
                        </div>

                        <!-- Botón Filtrar (opcional) -->
                        <div>
                            <button
                                type="submit"
                                class="bg-gray-500 text-white rounded-md px-4 py-2 hover:bg-gray-600 transition"
                            >
                                {{ __('Filtrar') }}
                            </button>
                        </div>
                    </form>
                    <div>
                        <a
                            href="{{ route('administrador.providers.create') }}"
                            class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition"
                        >
                            {{ __('Nuevo proveedor') }}
                        </a>
                    </div>
                </div>

                
            </div>

            <!-- Tabla de Proveedores -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b border-gray-200">ID</th>
                            <th class="px-4 py-3 border-b border-gray-200">Nombre</th>
                            <th class="px-4 py-3 border-b border-gray-200">NIT</th>
                            <th class="px-4 py-3 border-b border-gray-200">Dirección</th>
                            <th class="px-4 py-3 border-b border-gray-200">Contacto</th>
                            <th class="px-4 py-3 border-b border-gray-200">Empleado</th>
                            <th class="px-4 py-3 border-b border-gray-200">Teléfono</th>
                            <th class="px-4 py-3 border-b border-gray-200">Estado</th>
                            <th class="px-4 py-3 border-b border-gray-200">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($providers as $provider)
                            <tr>
                                <td class="px-4 py-3">{{ $provider->id }}</td>
                                <td class="px-4 py-3">{{ $provider->name }}</td>
                                <td class="px-4 py-3">{{ $provider->nit ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $provider->address ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $provider->contact ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $provider->employee_name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $provider->employee_phone ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($provider->status == 1)
                                        <span class="text-green-600">{{ __('Activo') }}</span>
                                    @else
                                        <span class="text-gray-500">{{ __('Inactivo') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a
                                        href="{{ route('administrador.providers.edit', $provider) }}"
                                        class="text-blue-500 hover:underline mr-3"
                                    >
                                        {{ __('Editar') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $providers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
