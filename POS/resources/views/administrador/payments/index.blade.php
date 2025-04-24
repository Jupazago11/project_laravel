<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Pagos de ') }} {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">

            <div class="flex justify-between items-center mb-4">
                <form method="GET"
                      action="{{ route('administrador.payments.index', $client) }}"
                      class="flex gap-2">
                    <input type="date"
                           name="from"
                           value="{{ request('from') }}"
                           class="border border-gray-300 rounded-md px-3 py-2"
                           onchange="this.form.submit()"
                           placeholder="Desde" />
                    <input type="date"
                           name="to"
                           value="{{ request('to') }}"
                           class="border border-gray-300 rounded-md px-3 py-2"
                           onchange="this.form.submit()"
                           placeholder="Hasta" />
                    <button type="submit"
                            class="bg-gray-500 text-white rounded-md px-4 py-2 hover:bg-gray-600">
                        Filtrar
                    </button>
                </form>

                <a href="{{ route('administrador.payments.create', $client) }}"
                   class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600">
                    Registrar abono
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border-b">#</th>
                            <th class="px-4 py-2 border-b">Fecha</th>
                            <th class="px-4 py-2 border-b">Monto</th>
                            <th class="px-4 py-2 border-b">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr>
                                <td class="px-4 py-2">{{ $payment->id }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">${{ number_format($payment->amount, 2, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('administrador.payments.edit', [$client, $payment]) }}"
                                       class="text-blue-500 hover:underline mr-4">
                                        Editar
                                    </a>
                                    <form action="{{ route('administrador.payments.destroy', [$client, $payment]) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Eliminar este abono?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                                    No hay abonos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
