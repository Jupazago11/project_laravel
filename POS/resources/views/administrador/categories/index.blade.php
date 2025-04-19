<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorías') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            {{-- Barra superior: búsqueda, filtro de estado, botón “Nuevo” --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                {{-- Buscador y filtro de estado --}}
                <div class="flex items-center gap-4 mb-2 sm:mb-0">
                    <form method="GET" action="{{ route('administrador.categories.index') }}" class="flex gap-4">
                        <input
                            type="text"
                            name="search"
                            placeholder="Buscar por nombre…"
                            value="{{ $search ?? '' }}"
                            class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300"
                        />

                        <select
                            name="status_filter"
                            class="border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                            onchange="this.form.submit()"
                        >
                            <option value="">{{ __('Todos los estados') }}</option>
                            <option value="1" {{ (isset($statusFilter) && $statusFilter=='1') ? 'selected':'' }}>
                                {{ __('Activo') }}
                            </option>
                            <option value="0" {{ (isset($statusFilter) && $statusFilter=='0') ? 'selected':'' }}>
                                {{ __('Inactivo') }}
                            </option>
                        </select>

                        <button
                            type="submit"
                            class="bg-gray-500 text-white rounded-md px-4 py-2 hover:bg-gray-600 transition"
                        >
                            {{ __('Filtrar') }}
                        </button>
                    </form>
                    <div>
                    <a
                        href="{{ route('administrador.categories.create') }}"
                        class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition"
                    >
                        {{ __('Nueva categoría') }}
                    </a>
                    </div>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b">ID</th>
                            <th class="px-4 py-3 border-b">Nombre</th>
                            <th class="px-4 py-3 border-b">Descripción</th>
                            <th class="px-4 py-3 border-b">Estado</th>
                            <th class="px-4 py-3 border-b">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                            <tr>
                                <td class="px-4 py-3">{{ $category->id }}</td>
                                <td class="px-4 py-3">{{ $category->name }}</td>
                                <td class="px-4 py-3">{{ Str::limit($category->description, 50, '…') }}</td>
                                <td class="px-4 py-3">
                                    @if($category->status)
                                        <span class="text-green-600">Activo</span>
                                    @else
                                        <span class="text-gray-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a
                                        href="{{ route('administrador.categories.edit', $category) }}"
                                        class="text-blue-500 hover:underline mr-4"
                                    >
                                        {{ __('Editar') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $categories->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
