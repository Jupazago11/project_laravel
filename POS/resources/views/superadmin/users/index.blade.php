<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Useddrs') }}
        </h2>
    </x-slot>

    <!-- Contenedor Principal -->
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <!-- Barra superior: Buscador, Filtro y Botón “Nuevo registro” -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <!-- Search & Filter -->
                <div class="flex items-center gap-4 mb-2 sm:mb-0">
                    <!-- Formulario GET para la búsqueda y filtros -->
                    <form method="GET" action="{{ route('superadmin.users.index') }}" class="flex gap-4">
                        <!-- Campo de búsqueda -->
                        <div>
                            <input
                                type="text"
                                name="search"
                                placeholder="Buscar"
                                value="{{ $search ?? '' }}"
                                class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300" 
                                onchange="this.form.submit()"
                            />
                        </div>

                        <!-- Filtro de estado -->
                        <div>
                            <select
                                name="status_filter"
                                class="block w-full border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                                onchange="this.form.submit()"
                            >
                                <option value="">Estado</option>
                                <option value="1" {{ isset($statusFilter) && $statusFilter == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ isset($statusFilter) && $statusFilter == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <!-- Filtro de tipo de usuario -->
                        <div>
                            <select
                                name="type_filter"
                                class="block w-full border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                                onchange="this.form.submit()"
                            >
                                <option value="">Tipo de Usuario</option>
                                @foreach($typeUsers as $t)
                                    <option value="{{ $t->id }}" {{ (isset($typeFilter) && $typeFilter == $t->id) ? 'selected' : '' }}>
                                        {{ $t->type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de company -->
                        <div>
                            <select
                                name="company_filter"
                                class="block w-full border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring focus:ring-blue-300 appearance-none"
                                onchange="this.form.submit()"
                            >
                                <option value="">Todas las empresas</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ (isset($companyFilter) && $companyFilter == $company->id) ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botón “Filter” (opcional, ya que onchange envía el form) -->
                        <div>
                            <button
                                type="submit"
                                class="bg-gray-500 text-white rounded-md px-4 py-2 hover:bg-gray-600 transition"
                            >
                                Filtrar
                            </button>
                        </div>
                    </form>
                    <!-- Botón “Nuevo registro” con estilo original de W3CSS -->
                    <div>
                        <a href="{{ route('superadmin.users.create') }}" class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition">
                            Nuevo registro
                        </a>
                    </div>
                </div>

                
            </div>

            <!-- Tabla de Usuarios -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b border-gray-200">ID</th>
                            <th class="px-4 py-3 border-b border-gray-200">Name</th>
                            <th class="px-4 py-3 border-b border-gray-200">Email</th>
                            <th class="px-4 py-3 border-b border-gray-200">Type</th>
                            <th class="px-4 py-3 border-b border-gray-200">Company</th>
                            <th class="px-4 py-3 border-b border-gray-200">Status</th>
                            <th class="px-4 py-3 border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-3">{{ $user->id }}</td>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->typeUser ? $user->typeUser->type : 'N/A' }}</td>
                                <td class="px-4 py-3">{{ optional($user->company)->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($user->status == 1)
                                        <span class="text-green-600">Activo</span>
                                    @else
                                        <span class="text-gray-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('superadmin.users.edit', $user) }}" class="text-blue-500 hover:underline">
                                        Editar
                                    </a>
                                    <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-red-500 hover:underline"
                                            onclick="return confirm('¿Está seguro de eliminar este usuario?')"
                                        >
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
