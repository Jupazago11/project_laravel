{{-- resources/views/administrador/products/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="relative overflow-x-auto">
                        <table class="w-full text-left rtl:text-right">
                            <thead class="text-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Información del producto
                                    </th>
                                    <th scope="col col-span-2" class="px-6 py-3">
                                    Costo e impuesto
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white">
                                    <th scope="row" class="px-6 py-4">
                                        Apple MacBook Pro 17"
                                    </th>
                                    <td scope="row" class="px-6 py-4">
                                        1
                                    </td>
                                    <td scope="row" class="px-6 py-4">
                                        $2999
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <th scope="row" class="px-6 py-4">
                                        Microsoft Surface Pro
                                    </th>
                                    <td scope="row" class="px-6 py-4">
                                        1
                                    </td>
                                    <td scope="row" class="px-6 py-4">
                                        $1999
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <th scope="row" class="px-6 py-4">
                                        Magic Mouse 2
                                    </th>
                                    <td scope="row" class="px-6 py-4">
                                    1
                                    </td>
                                    <td scope="row" class="px-6 py-4">
                                        $99
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-white">
                                    <th scope="row" class="px-6 py-3">Total</th>
                                    <td scope="row" class="px-6 py-3">3</td>
                                    <td scope="row" class="px-6 py-3">21,000</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- ERRORES --}}
                @if ($errors->any())
                    <div class="mb-6">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('administrador.products.store') }}">
                    @csrf

                    {{-- forzamos la empresa del admin --}}
                    <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- COLUMNA 1: IDENTIFICACIÓN Y RELACIONES --}}
                        <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información del producto</h3>
                            {{-- Código --}}
                            <div>
                                <label class="block text-gray-700">Código de Producto</label>
                                <input
                                    type="text" name="product_code"
                                    value="{{ old('product_code') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Nombre --}}
                            <div>
                                <label class="block text-gray-700">Nombre</label>
                                <input
                                    type="text" name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Descripción --}}
                            <div>
                                <label class="block text-gray-700">Descripción</label>
                                <textarea
                                    name="description"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    rows="3"
                                >{{ old('description') }}</textarea>
                            </div>

                            {{-- Categoría --}}
                            <div>
                                <label class="block text-gray-700">Categoría</label>
                                <select
                                    name="category_id"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Seleccione una categoría…</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Proveedor --}}
                            <div>
                                <label class="block text-gray-700">Proveedor</label>
                                <select
                                    name="provider_id"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Seleccione un proveedor…</option>
                                    @foreach($providers as $prov)
                                        <option value="{{ $prov->id }}"
                                            {{ old('provider_id') == $prov->id ? 'selected' : '' }}>
                                            {{ $prov->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Inventario y Stock --}}
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="track_inventory" id="track_inventory" class="h-4 w-4">
                                <label for="track_inventory" class="ml-2 text-gray-700">Manejar inventario</label>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700">Stock</label>
                                <input
                                type="number" name="stock" id="stock"
                                value="{{ old('stock') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md"
                                />
                                @error('stock')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- COLUMNA 2: COSTOS, IMPUESTOS Y PRECIOS --}}

                        <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Costo e impuesto</h3>
                        {{-- Tarifa IVA (radio) --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Tarifa de IVA</label>
                                @foreach($ivaRates as $iva)
                                    <div class="flex items-center mb-1">
                                        <input
                                            type="radio"
                                            id="iva_{{ $iva->id }}"
                                            name="iva_rate_id"
                                            value="{{ $iva->id }}"
                                            {{ old('iva_rate_id') == $iva->id ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                        >
                                        <label for="iva_{{ $iva->id }}" class="ml-2 text-gray-800 text-sm">
                                            <span class="font-medium">{{ $iva->name }}</span>
                                            <span class="text-gray-600">— {{ $iva->description }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            
                            

                            {{-- INC Rate --}}
                            <div>
                                <label class="block text-gray-700">Tarifa INC (%)</label>
                                <input
                                    type="number" name="inc_rate" step="1.00"
                                    value="{{ old('inc_rate', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Impuesto Adicional --}}
                            <div>
                                <label class="block text-gray-700">Impuesto Adicional - Valor en pesos</label>
                                <input
                                    type="number" name="additional_tax" step="1.00"
                                    value="{{ old('additional_tax', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            {{-- Costo --}}
                            <div>
                                <label class="block text-gray-700">Costo</label>
                                <input
                                    type="number" name="cost" step="1.00"
                                    value="{{ old('cost', '0') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Precio 1 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 1</label>
                                <input
                                    type="number" name="price_1" step="1.00"
                                    value="{{ old('price_1', '0') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Precio 2 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 2</label>
                                <input
                                    type="number" name="price_2" step="1.00"
                                    value="{{ old('price_2', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Precio 3 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 3</label>
                                <input
                                    type="number" name="price_3" step="1.00"
                                    value="{{ old('price_3', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                        </div>

                        {{-- Columna 3: Precios y Stock --}}
                    <div>
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Precios y Existencias</h3>
                        <br><br><br><br><br><br>
                        {{-- Precio 1 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 1</label>
                                <input
                                    type="number" name="price_1" step="1.00"
                                    value="{{ old('price_1', '0') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Precio 2 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 2</label>
                                <input
                                    type="number" name="price_2" step="1.00"
                                    value="{{ old('price_2', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>

                            {{-- Precio 3 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 3</label>
                                <input
                                    type="hidden" name="price_3" step="1.00" 
                                    value="{{ old('price_3', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            {{-- Precio 1 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 1</label>
                                <input
                                    type="number" name="price_3" step="1.00"
                                    value="{{ old('price_3', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            {{-- Precio 2 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 2</label>
                                <input
                                    type="number" name="price_3" step="1.00"
                                    value="{{ old('price_3', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            {{-- Precio 3 --}}
                            <div>
                                <label class="block text-gray-700">Precio de Venta 3</label>
                                <input
                                    type="number" name="price_3" step="1.00"
                                    value="{{ old('price_3', '0') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            


                    
                    </div>

                    

                    


                    {{-- BOTÓN SUBMIT --}}
                    <div class="flex justify-end mt-6">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white font-medium px-6 py-2 rounded-md hover:bg-blue-600 transition"
                        >
                            Crear Producto
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
