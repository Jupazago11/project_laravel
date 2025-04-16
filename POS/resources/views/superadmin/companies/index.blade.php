<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <!-- Contenedor Principal -->
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <!-- Barra superior: Buscador, Filtro y Botón “Nuevo registro” -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <!-- Search & Filter -->
                <div class="flex items-center gap-4 mb-2 sm:mb-0">
                    <!-- Formulario GET para la búsqueda y filtros -->
                    <form method="GET" action="{{ route('superadmin.companies.index') }}" class="flex gap-4">
                        <!-- Campo de búsqueda -->
                        <div>
                            <input
                                type="text"
                                name="search"
                                placeholder="Buscar"
                                value="{{ $search ?? '' }}"
                                class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300"
                                onchange="this.form.submit()"
                            />
                        </div>

                        <!-- Filtro de estado -->
                        <div>
                            <select
                                name="status_filter"
                                class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300"
                                onchange="this.form.submit()"
                            >
                                <option value="">Estado</option>
                                <option value="1" {{ (isset($statusFilter) && $statusFilter == '1') ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ (isset($statusFilter) && $statusFilter == '0') ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <!-- Botón “Filtrar” (opcional) -->
                        <div>
                            <button
                                type="submit"
                                class="bg-gray-500 text-white rounded-md px-4 py-2 hover:bg-gray-600 transition"
                            >
                                Filtrar
                            </button>
                        </div>
                    </form>

                    <!-- Botón “Nuevo registro” -->
                    <div>
                        <a
                            href="{{ route('superadmin.companies.create') }}"
                            class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition"
                        >
                            Nuevo registro
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabla de Companies -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b border-gray-200">ID</th>
                            <th class="px-4 py-3 border-b border-gray-200">Name</th>
                            <th class="px-4 py-3 border-b border-gray-200">NIT</th>
                            <th class="px-4 py-3 border-b border-gray-200">Address</th>
                            <th class="px-4 py-3 border-b border-gray-200">Status</th>
                            <th class="px-4 py-3 border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($companies as $company)
                            <tr>
                                <td class="px-4 py-3">{{ $company->id }}</td>
                                <td class="px-4 py-3">{{ $company->name }}</td>
                                <td class="px-4 py-3">{{ $company->nit }}</td>
                                <td class="px-4 py-3">{{ $company->direction }}</td>
                                <td class="px-4 py-3">
                                    @if($company->status == 1)
                                        <span class="text-green-600">Activo</span>
                                    @else
                                        <span class="text-gray-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a
                                        href="{{ route('superadmin.companies.edit', $company) }}"
                                        class="text-blue-500 hover:underline"
                                    >
                                        Editar
                                    </a>
                                    <form
                                        action="{{ route('superadmin.companies.destroy', $company) }}"
                                        method="POST"
                                        class="inline-block ml-2"
                                        onsubmit="return confirm('¿Está seguro de eliminar esta compañía?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-red-500 hover:underline"
                                        >
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
