<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
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

                <form method="POST"
                      action="{{ route('administrador.products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        {{-- Repite exactamente los mismos campos que en create.blade.php, --}}
                        {{-- pero usando old(..., $product->campo) para rellenar --}}
                        <div>
                            <label class="block text-gray-700">Código</label>
                            <input type="text" name="product_code"
                                   value="{{ old('product_code', $product->product_code) }}"
                                   class="w-full border p-2 rounded">
                        </div>
                        {{-- ...y así sucesivamente para todos los inputs/selects... --}}
                        {{-- Ejemplo: --}}
                        <div>
                            <label class="block text-gray-700">Nombre</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $product->name) }}"
                                   class="w-full border p-2 rounded" required>
                        </div>
                        {{-- Categoría: --}}
                        <div>
                            <label class="block text-gray-700">Categoría</label>
                            <select name="category_id" class="w-full border p-2 rounded" required>
                                <option value="">Seleccione…</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                      {{ old('category_id', $product->category_id)==$cat->id?'selected':'' }}>
                                      {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- y así para proveedor, costo, iva_rate_id, prices, stock, status… --}}
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __('Actualizar Producto') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
