<x-app-layout> 
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <a href="{{ route('superadmin.users.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-gray-800">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <!-- Mostrar el tipo de usuario usando la relación -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $user->typeUser ? $user->typeUser->type : 'No asignado' }}
                                        </td>
                                        <!-- Mostrar el estado del usuario, usando una lógica simple -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->status == 1)
                                                Activo
                                            @else
                                                Inactivo
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- Enlace para editar usando <img> para icono -->
                                            <a href="{{ route('superadmin.users.edit', $user) }}" class="inline-flex items-center text-blue-600 hover:underline">
                                                <img src="https://unpkg.com/heroicons@1.0.6/outline/pencil-alt.svg" alt="Editar" class="h-5 w-5 mr-1">
                                                Editar
                                            </a>
                                            
                                            <!-- Formulario para eliminar usando <img> para icono -->
                                            <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center text-red-600 hover:underline" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                    <img src="https://unpkg.com/heroicons@1.0.6/outline/trash.svg" alt="Eliminar" class="h-5 w-5 mr-1">
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
        </div>
    </div>
</x-app-layout>
