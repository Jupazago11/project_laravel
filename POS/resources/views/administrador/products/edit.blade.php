{{-- resources/views/administrador/products/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto">
                {{-- ERRORES --}}
                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('administrador.products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-6 gap-x-4 gap-y-2 text-left">

                        {{-- Código de Producto --}}
                        <div class="col-start-1 col-span-2">
                            <label class="block text-gray-700">Código de Producto</label>
                            <input
                                type="text"
                                name="product_code"
                                value="{{ old('product_code', $product->product_code) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />

                            <div class="mb-4">
                            <label class="block text-gray-700">Estado</label>
                            <select
                                name="status"
                                class="w-full border p-2 rounded"
                                required
                            >
                                <option value="1" {{ (old('status', $product->status)=='1') ? 'selected':'' }}>
                                    Activo
                                </option>
                                <option value="0" {{ (old('status', $product->status)=='0') ? 'selected':'' }}>
                                    Inactivo
                                </option>
                            </select>
                        </div>
                        </div>

                        {{-- Tarifa de IVA --}}
                        <div class="col-start-3 col-span-3">
                            <label class="block text-gray-700 font-medium mb-1">Tarifa de IVA</label>
                            @foreach($ivaRates as $iva)
                                <div class="flex items-center mb-1">
                                    <input
                                        type="radio"
                                        id="iva_{{ $iva->id }}"
                                        name="iva_rate_id"
                                        value="{{ $iva->id }}"
                                        data-rate="{{ $iva->rate }}"
                                        {{ old('iva_rate_id', $product->iva_rate_id) == $iva->id ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                    />
                                    <label for="iva_{{ $iva->id }}" class="ml-2 text-gray-800 text-sm">
                                        <span class="font-medium">{{ $iva->name }}</span>
                                        <span class="text-gray-600">— {{ $iva->description }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Botón Crear --}}
                        <div class="col-start-6 col-span-1 flex justify-end items-end">
                            <button
                                type="submit"
                                class="bg-blue-500 text-white font-medium px-6 py-2 rounded-md hover:bg-blue-600 transition"
                            >
                                Actualizar Producto
                            </button>
                        </div>

                        {{-- Nombre --}}
                        <div class="col-span-2 col-start-1">
                            <label class="block text-gray-700">Nombre</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        {{-- Tarifa INC --}}
                        <div class="col-span-2 col-start-3">
                            <label class="block text-gray-700">Tarifa INC (%)</label>
                            <input
                                type="number"
                                name="inc_rate"
                                step="1.00"
                                id="inc"
                                value="{{ old('inc_rate', $product->inc_rate) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        {{-- Descripción --}}
                        <div class="col-span-2 col-start-1">
                            <label class="block text-gray-700">Descripción</label>
                            <textarea
                                name="description"
                                rows="1"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            >{{ old('description', $product->description) }}</textarea>
                        </div>

                        {{-- Impuesto Adicional --}}
                        <div class="col-start-3 col-span-2">
                            <label class="block text-gray-700">Impuesto Adicional - Valor en pesos</label>
                            <input
                                type="number"
                                name="additional_tax"
                                step="1.00"
                                id="additional_tax"
                                value="{{ old('additional_tax', $product->additional_tax) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        {{-- Costo + Impuestos --}}
                        <div class="col-span-2 col-start-5">
                            <label class="block text-gray-700">Costo + Impuestos</label>
                            <input
                                type="text"
                                id="cost_with_taxes"
                                readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"
                            />
                        </div>

                        {{-- Categoría --}}
                        <div class="col-span-2 col-start-1">
                            <label class="block text-gray-700">Categoría</label>
                            <select
                                name="category_id"
                                required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">Seleccione una categoría…</option>
                                @foreach($categories as $cat)
                                    <option
                                        value="{{ $cat->id }}"
                                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}
                                    >
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Costo --}}
                        <div class="col-span-2 col-start-3">
                            <label class="block text-gray-700">Costo</label>
                            <input
                                type="number"
                                name="cost"
                                step="1.00"
                                id="cost"
                                value="{{ old('cost', $product->cost) }}"
                                required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        {{-- Proveedor --}}
                        <div class="col-span-2 col-start-1">
                            <label class="block text-gray-700">Proveedor</label>
                            <select
                                name="provider_id"
                                required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">Seleccione un proveedor…</option>
                                @foreach($providers as $prov)
                                    <option
                                        value="{{ $prov->id }}"
                                        {{ old('provider_id', $product->provider_id) == $prov->id ? 'selected' : '' }}
                                    >
                                        {{ $prov->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Precio de Venta 1 y Utilidad --}}
                        <div class="col-span-2 col-start-3">
                            <label class="block text-gray-700">Precio de Venta 1</label>
                            <input
                                type="number"
                                name="price_1"
                                step="1.00"
                                value="{{ old('price_1', $product->price_1) }}"
                                required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="col-span-2 col-start-5">
                            <label class="block text-gray-700">Utilidad Precio 1 (%)</label>
                            <input
                                type="text"
                                id="profit_1"
                                readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"
                            />
                        </div>

                        {{-- Manejo de Inventario --}}
                        <div class="col-span-2 col-start-1">
                        <label class="block text-gray-700">Manejar inventario</label>
                        <div class="flex items-center mt-1">
                            <label class="inline-flex items-center mr-4">
                            <input
                                type="radio"
                                name="track_inventory"
                                value="1"
                                {{ old('track_inventory', $product->track_inventory) == 1 ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                            />
                            <span class="ml-2 text-gray-700">Sí</span>
                            </label>
                            <label class="inline-flex items-center">
                            <input
                                type="radio"
                                name="track_inventory"
                                value="0"
                                {{ old('track_inventory', $product->track_inventory) == 0 ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                            />
                            <span class="ml-2 text-gray-700">No</span>
                            </label>
                        </div>
                        </div>

                        {{--< Precio de Venta 2 y Utilidad --}}
                        <div class="col-span-2 col-start-3">
                            <label class="block text-gray-700">Precio de Venta 2</label>
                            <input
                                type="number"
                                name="price_2"
                                step="1.00"
                                value="{{ old('price_2', $product->price_2) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="col-span-2 col-start-5">
                            <label class="block text-gray-700">Utilidad Precio 2 (%)</label>
                            <input
                                type="text"
                                id="profit_2"
                                readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"
                            />
                        </div>

                        {{-- Stock --}}
                        <div class="col-span-2 col-start-1">
                            <label class="block text-gray-700">Stock</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                value="{{ old('stock', $product->stock) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md"
                            />
                            @error('stock')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Precio de Venta 3 y Utilidad --}}
                        <div class="col-span-2 col-start-3">
                            <label class="block text-gray-700">Precio de Venta 3</label>
                            <input
                                type="number"
                                name="price_3"
                                step="1.00"
                                value="{{ old('price_3', $product->price_3) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="col-span-2 col-start-5">
                            <label class="block text-gray-700">Utilidad Precio 3 (%)</label>
                            <input
                                type="text"
                                id="profit_3"
                                readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"
                            />
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Campos base
  const costInput        = document.getElementById('cost');
  const ivaRadios        = document.querySelectorAll('input[name="iva_rate_id"]');
  const incInput         = document.getElementById('inc');
  const additionalInput  = document.getElementById('additional_tax');
  const resultInput      = document.getElementById('cost_with_taxes');

  // Precios y utilidades
  const price1Input      = document.querySelector('input[name="price_1"]');
  const profit1Input     = document.getElementById('profit_1');
  const price2Input      = document.querySelector('input[name="price_2"]');
  const profit2Input     = document.getElementById('profit_2');
  const price3Input      = document.querySelector('input[name="price_3"]');
  const profit3Input     = document.getElementById('profit_3');

  // Inventario
  const trackInventory   = document.getElementById('track_inventory');
  const stockInput       = document.getElementById('stock');

  // Obtiene el % de IVA desde data-rate del radio seleccionado
  function getIvaPercent() {
    const sel = document.querySelector('input[name="iva_rate_id"]:checked');
    return sel ? (parseFloat(sel.dataset.rate) || 0) / 100 : 0;
  }

  // Formatea con separadores de miles y sin decimales
  function formatNumber(n) {
    return n.toLocaleString('es-CO', {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    });
  }

  // Calcula el costo + impuestos y actualiza utilidades
  function calculateAll() {
    const cost       = parseFloat(costInput.value)        || 0;
    const ivaPct     = getIvaPercent();
    const incPct     = (parseFloat(incInput.value)        || 0) / 100;
    const additional = parseFloat(additionalInput.value)  || 0;

    // fórmula aditiva
    const total = cost + cost * ivaPct + cost * incPct + additional;
    resultInput.value = isNaN(total)
      ? ''
      : formatNumber(total);

    updateProfits(total);
  }

  // Calcula % de utilidad para cada precio si es > 0
  function updateProfits(base) {
    if (base <= 0) {
      profit1Input.value = '';
      profit2Input.value = '';
      profit3Input.value = '';
      return;
    }
    [[price1Input, profit1Input],
     [price2Input, profit2Input],
     [price3Input, profit3Input]
    ].forEach(([priceEl, outEl]) => {
      const p = parseFloat(priceEl.value) || 0;
      if (p > 0) {
        const pct = ((p - base) / base) * 100;
        outEl.value = pct.toFixed(2) + '%';
      } else {
        outEl.value = '';
      }
    });
  }

  // Habilita o deshabilita edición de stock según checkbox
  function toggleStockEditable() {
    stockInput.readOnly = !trackInventory.checked;
  }

  // Listeners
  costInput.addEventListener('input',      calculateAll);
  ivaRadios.forEach(r => r.addEventListener('change', calculateAll));
  incInput.addEventListener('input',       calculateAll);
  additionalInput.addEventListener('input',calculateAll);

  price1Input.addEventListener('input',    calculateAll);
  price2Input.addEventListener('input',    calculateAll);
  price3Input.addEventListener('input',    calculateAll);

  trackInventory.addEventListener('change', toggleStockEditable);

  // Inicializar estado al cargar la página
  toggleStockEditable();
  calculateAll();
});
</script>
