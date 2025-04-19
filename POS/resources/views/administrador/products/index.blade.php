<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <!-- Barra superior: Filtros + Nuevo registro -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <!-- Filtros -->
                <form method="GET" action="{{ route('administrador.products.index') }}" class="flex flex-wrap gap-4 items-center mb-4 sm:mb-0">
                    <!-- Búsqueda libre (name o code) -->
                    <div>
                        <input
                            type="text"
                            name="search"
                            placeholder="Buscar nombre o código"
                            value="{{ $search ?? '' }}"
                            class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300"
                        />
                    </div>

                    <!-- Filtro Proveedor -->
                    <div>
                        <select
                            name="provider_filter"
                            onchange="this.form.submit()"
                            class="border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                        >
                            <option value="">{{ __('Todos los proveedores') }}</option>
                            @foreach($providers as $prov)
                                <option value="{{ $prov->id }}" {{ (isset($providerFilter) && $providerFilter == $prov->id) ? 'selected' : '' }}>
                                    {{ $prov->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro Categoría -->
                    <div>
                        <select
                            name="category_filter"
                            onchange="this.form.submit()"
                            class="border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                        >
                            <option value="">{{ __('Todas las categorías') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (isset($categoryFilter) && $categoryFilter == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro Estado -->
                    <div>
                        <select
                            name="status_filter"
                            onchange="this.form.submit()"
                            class="border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                        >
                            <option value="">{{ __('Todos los estados') }}</option>
                            <option value="1" {{ (isset($statusFilter) && $statusFilter == '1') ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ (isset($statusFilter) && $statusFilter == '0') ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <!-- Filtros Inventario -->
                    <div class="flex items-center gap-2">
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="inventory_true"
                                class="form-checkbox"
                                value="1"
                                {{ !empty($inventoryTrue) && !$inventoryFalse ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            />
                            <span class="ml-1">Con inventario</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="inventory_false"
                                class="form-checkbox"
                                value="1"
                                {{ !empty($inventoryFalse) && !$inventoryTrue ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            />
                            <span class="ml-1">Sin inventario</span>
                        </label>
                    </div>

                    <!-- Botón Filtrar -->
                    <div>
                        <button
                            type="submit"
                            class="bg-gray-500 text-white rounded-md px-4 py-2 hover:bg-gray-600 transition"
                        >
                            {{ __('Filtrar') }}
                        </button>
                    </div>
                </form>

                <!-- Botón Nuevo Registro -->
                <div>
                    <a
                        href="{{ route('administrador.products.create') }}"
                        class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition"
                    >
                        {{ __('Nuevo registro') }}
                    </a>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b border-gray-200">ID</th>
                            <th class="px-4 py-3 border-b border-gray-200">Código</th>
                            <th class="px-4 py-3 border-b border-gray-200">Nombre</th>
                            <th class="px-4 py-3 border-b border-gray-200">Categoría</th>
                            <th class="px-4 py-3 border-b border-gray-200">Proveedor</th>
                            <th class="px-4 py-3 border-b border-gray-200">Inventario</th>
                            <th class="px-4 py-3 border-b border-gray-200">Status</th>
                            <th class="px-4 py-3 border-b border-gray-200">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-3">{{ $product->id }}</td>
                                <td class="px-4 py-3">{{ $product->product_code }}</td>
                                <td class="px-4 py-3">{{ $product->name }}</td>
                                <td class="px-4 py-3">{{ optional($product->category)->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ optional($product->provider)->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($product->track_inventory)
                                        <span class="text-green-600">Sí</span>
                                    @else
                                        <span class="text-gray-500">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($product->status)
                                        <span class="text-green-600">Activo</span>
                                    @else
                                        <span class="text-gray-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a
                                        href="{{ route('administrador.products.edit', $product) }}"
                                        class="text-blue-500 hover:underline mr-4"
                                    >
                                        Editar
                                    </a>
                                    <form
                                        action="{{ route('administrador.products.destroy', $product) }}"
                                        method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
