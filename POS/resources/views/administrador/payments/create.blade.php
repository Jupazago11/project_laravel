<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar abono para ') }} {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-md mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('administrador.clients.payments.store', $client) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700">Monto</label>
                    <input type="number"
                           name="amount"
                           step="0.01"
                           value="{{ old('amount') }}"
                           class="w-full border p-2 rounded"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Fecha de abono</label>
                    <input type="date"
                           name="payment_date"
                           value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                           class="w-full border p-2 rounded"
                           required>
                </div>

                {{-- Si gestionas facturas, podrías incluir aquí un select de invoices --}}
                {{--  
                <div class="mb-4">
                    <label class="block text-gray-700">Factura (opcional)</label>
                    <input type="text" name="invoice_id" value="{{ old('invoice_id') }}"
                           class="w-full border p-2 rounded">
                </div>
                --}}

                <div class="flex justify-end">
                    <a href="{{ route('administrador.clients.payments.index', $client) }}"
                       class="mr-4 px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Guardar abono
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
