{{-- resources/views/administrador/clients/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <!-- Botón Nuevo Cliente -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('administrador.clients.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Nuevo Cliente
                </a>
            </div>

            <!-- Tabla de Clientes -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b border-gray-200">ID</th>
                            <th class="px-4 py-3 border-b border-gray-200">Nombre</th>
                            <th class="px-4 py-3 border-b border-gray-200">Identificación</th>
                            <th class="px-4 py-3 border-b border-gray-200">Email</th>
                            <th class="px-4 py-3 border-b border-gray-200">Teléfono</th>
                            <th class="px-4 py-3 border-b border-gray-200">Estado</th>
                            <th class="px-4 py-3 border-b border-gray-200">Acciones</th>
                            <th class="px-4 py-3 border-b border-gray-200">Pagos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($clients as $client)
                            <tr>
                                <td class="px-4 py-3">{{ $client->id }}</td>
                                <td class="px-4 py-3">{{ $client->name }}</td>
                                <td class="px-4 py-3">{{ $client->identification ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $client->email ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $client->phone ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($client->status)
                                        <span class="text-green-600">Activo</span>
                                    @else
                                        <span class="text-gray-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('administrador.clients.edit', $client) }}"
                                       class="text-blue-500 hover:underline mr-4">
                                        Editar
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('administrador.payments.index', $client) }}"
                                       class="text-indigo-600 hover:underline">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
