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

            <div class="grid grid-cols-6 gap-x-4 gap-y-2 text-left">
                <div class="col-start-1 col-span-2">
                    <label class="block text-gray-700">Código de Producto</label>
                        <input
                            type="text" name="product_code"
                            value="{{ old('product_code') }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    >
            </div>

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

            <div class="col-start-6 col-span-1" >
            {{-- BOTÓN SUBMIT --}}
                <div class="col-start-6 col-span-1 flex justify-end items-end">
                    <button
                        type="submit"
                        class="bg-blue-500 text-white font-medium px-6 py-2 rounded-md hover:bg-blue-600 transition"
                    >
                        Crear <br> Producto
                    </button>
                </div>
            </div>

            <div class="col-start-1 col-span-2">
                <label class="block text-gray-700">Nombre</label>
                    <input
                        type="text" name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    >
            </div>

            <div class="col-span-2 col-start-3">
            <label class="block text-gray-700">Tarifa INC (%)</label>
                <input
                    type="number" name="inc_rate" step="1.00" id="inc"
                    value="{{ old('inc_rate', '0') }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            

            
            <div class="col-span-2 col-start-1"><label class="block text-gray-700">Descripción</label>
                <textarea
                    name="description"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    rows="1"
                >{{ old('description') }}</textarea>
            </div>

            <div class="col-start-3 col-span-2">
                <label class="block text-gray-700">Impuesto Adicional - Valor en pesos</label>
                    <input
                        type="number" name="additional_tax" step="1.00" id="additional_tax"
                        value="{{ old('additional_tax', '0') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    >
            </div>

            <div class="col-span-2 col-start-5">
                <label class="block text-gray-700">Costo + Impuestos</label>
                <input type="number" id="cost_with_taxes" readonly
                       class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            </div>


            

            <div class="col-span-2 col-start-1"><label class="block text-gray-700">Categoría</label>
                <select
                    name="category_id"
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

            <div class="col-span-2 col-start-3">
                <label class="block text-gray-700">Costo</label>
                <input
                    type="number" name="cost" step="1.00" id="cost"
                    value="{{ old('cost', '0') }}"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <div class="col-span-2 col-start-1">
                <label class="block text-gray-700">Proveedor</label>
                <select
                    name="provider_id"
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

            <div class="col-span-2 col-start-3">
                <label class="block text-gray-700">Precio de Venta 1</label>
                <input
                    type="number" name="price_1" step="1"
                    value="{{ old('price_1', '0') }}"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="col-span-2 col-start-5">
                <label class="block text-gray-700">Utilidad Precio 1 (%)</label>
                <input type="text" id="profit_1" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            </div>

            <div class="col-span-2 col-start-1">
                {{-- Siempre enviamos un 0 por defecto --}}
                <input type="hidden" name="track_inventory" value="0">
                
                {{-- Si el usuario lo marca, enviamos un 1 --}}
                <input
                    type="checkbox"
                    name="track_inventory"
                    id="track_inventory"
                    value="1"
                    class="h-4 w-4"
                >
                <label for="track_inventory" class="ml-2 text-gray-700">
                    Manejar inventario
                </label>
            </div>

            <div class="col-span-2 col-start-3">
                <label class="block text-gray-700">Precio de Venta 2</label>
                <input
                    type="number" name="price_2" step="1.00"
                    value="{{ old('price_2', '0') }}"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="col-span-2 col-start-5">
                <label class="block text-gray-700">Utilidad Precio 2 (%)</label>
                <input type="text" id="profit_2" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            </div>

            <div class="col-span-2 col-start-1">
            <label class="block text-gray-700">Stock</label>
                <input
                type="number" name="stock" id="stock"
                value="0"
                class="mt-1 block w-full border-gray-300 rounded-md"
                />
                @error('stock')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-span-2 col-start-3">
                <label class="block text-gray-700">Precio de Venta 3</label>
                <input
                    type="number" name="price_3" step="1.00"
                    value="{{ old('price_3', '0') }}"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="col-span-2 col-start-5">
                <label class="block text-gray-700">Utilidad Precio 3 (%)</label>
                <input type="text" id="profit_3" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            </div>

        </div>
        
                <input type="hidden" name="status" value="1">
        
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const costInput        = document.getElementById('cost');
  const ivaRadios        = document.querySelectorAll('input[name="iva_rate_id"]');
  const incInput         = document.getElementById('inc');
  const additionalInput  = document.getElementById('additional_tax');
  const resultInput      = document.getElementById('cost_with_taxes');

  const price1Input      = document.querySelector('input[name="price_1"]');
  const profit1Input     = document.getElementById('profit_1');
  const price2Input      = document.querySelector('input[name="price_2"]');
  const profit2Input     = document.getElementById('profit_2');
  const price3Input      = document.querySelector('input[name="price_3"]');
  const profit3Input     = document.getElementById('profit_3');

  function getIvaPercent() {
    const sel = document.querySelector('input[name="iva_rate_id"]:checked');
    return sel ? (parseFloat(sel.dataset.rate) || 0) / 100 : 0;
  }

  function calculateCostWithTaxes() {
    const cost       = parseFloat(costInput.value)        || 0;
    const ivaPct     = getIvaPercent();
    const incPct     = (parseFloat(incInput.value)        || 0) / 100;
    const additional = parseFloat(additionalInput.value)  || 0;

    // Total base numérico
    const total = cost + cost * ivaPct + cost * incPct + additional;

    // Formatea con miles y sin decimales
    resultInput.value = isNaN(total)
      ? ''
      : total.toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 });

    updateProfits(total);
  }

  function updateProfits(base) {
    // si base no es positivo, limpias y sales
    if (base <= 0) {
      profit1Input.value = '';
      profit2Input.value = '';
      profit3Input.value = '';
      return;
    }

    const calcProfit = (priceEl, outEl) => {
      const p = parseFloat(priceEl.value) || 0;
      // sólo calculas si el precio es mayor que cero
      if (p <= 0) {
        outEl.value = '';
        return;
      }
      const pct = ((p - base) / base) * 100;
      outEl.value = pct.toFixed(2) + '%';
    };

    calcProfit(price1Input, profit1Input);
    calcProfit(price2Input, profit2Input);
    calcProfit(price3Input, profit3Input);
  }

  // Disparadores
  costInput.addEventListener('input',      calculateCostWithTaxes);
  ivaRadios.forEach(r => r.addEventListener('change', calculateCostWithTaxes));
  incInput.addEventListener('input',       calculateCostWithTaxes);
  additionalInput.addEventListener('input',calculateCostWithTaxes);

  price1Input.addEventListener('input',    calculateCostWithTaxes);
  price2Input.addEventListener('input',    calculateCostWithTaxes);
  price3Input.addEventListener('input',    calculateCostWithTaxes);

  // cálculo inicial
  calculateCostWithTaxes();
});
</script>

