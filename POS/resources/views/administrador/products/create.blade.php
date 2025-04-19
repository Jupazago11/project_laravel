<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        <ul class="list-disc ps-5">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('administrador.products.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label class="block text-gray-700">Código</label>
                            <input type="text" name="product_code"
                                   value="{{ old('product_code') }}"
                                   class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label class="block text-gray-700">Nombre</label>
                            <input type="text" name="name"
                                   value="{{ old('name') }}"
                                   class="w-full border p-2 rounded" required>
                        </div>

                        <div>
                            <label class="block text-gray-700">Descripción</label>
                            <textarea name="description"
                                      class="w-full border p-2 rounded"
                                      rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700">Categoría</label>
                            <select name="category_id" class="w-full border p-2 rounded" required>
                                <option value="">Seleccione…</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                      {{ old('category_id')==$cat->id?'selected':'' }}>
                                      {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700">Proveedor</label>
                            <select name="provider_id" class="w-full border p-2 rounded" required>
                                <option value="">Seleccione…</option>
                                @foreach($providers as $prov)
                                    <option value="{{ $prov->id }}"
                                      {{ old('provider_id')==$prov->id?'selected':'' }}>
                                      {{ $prov->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700">Costo</label>
                            <input type="number" step="0.01" name="cost"
                                   value="{{ old('cost','0') }}"
                                   class="w-full border p-2 rounded" required>
                        </div>

                        <div>
                            <label class="block text-gray-700">Tarifa IVA</label>
                            <select name="iva_rate_id" class="w-full border p-2 rounded" required>
                                <option value="">Seleccione…</option>
                                @foreach($ivaRates as $rate)
                                    <option value="{{ $rate->id }}"
                                      {{ old('iva_rate_id')==$rate->id?'selected':'' }}>
                                      {{ $rate->rate }} %
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700">Imp. Adicional</label>
                            <input type="number" step="0.01" name="additional_tax"
                                   value="{{ old('additional_tax','0') }}"
                                   class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label class="block text-gray-700">Precio 1</label>
                            <input type="number" step="0.01" name="price_1"
                                   value="{{ old('price_1','0') }}"
                                   class="w-full border p-2 rounded" required>
                        </div>

                        <div>
                            <label class="block text-gray-700">Precio 2</label>
                            <input type="number" step="0.01" name="price_2"
                                   value="{{ old('price_2') }}"
                                   class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label class="block text-gray-700">Precio 3</label>
                            <input type="number" step="0.01" name="price_3"
                                   value="{{ old('price_3') }}"
                                   class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="track_inventory"
                                       class="form-checkbox"
                                       {{ old('track_inventory')?'checked':'' }}>
                                <span class="ms-2">Controlar inventario</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-gray-700">Stock</label>
                            <input type="number" name="stock"
                                   value="{{ old('stock','0') }}"
                                   class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label class="block text-gray-700">Estado</label>
                            <select name="status" class="w-full border p-2 rounded" required>
                                <option value="1" {{ old('status','1')=='1'?'selected':'' }}>Activo</option>
                                <option value="0" {{ old('status')=='0'?'selected':'' }}>Inactivo</option>
                            </select>
                        </div>

                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __('Crear Producto') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
