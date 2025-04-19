{{-- resources/views/administrador/categories/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('administrador.categories.update', $category) }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="w-full border p-2 rounded"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Descripción (opcional)</label>
                        <textarea
                            name="description"
                            class="w-full border p-2 rounded"
                            rows="3"
                        >{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Estado</label>
                        <select
                            name="status"
                            class="w-full border p-2 rounded"
                            required
                        >
                            <option value="1" {{ (old('status', $category->status)=='1') ? 'selected':'' }}>
                                Activo
                            </option>
                            <option value="0" {{ (old('status', $category->status)=='0') ? 'selected':'' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
                        >
                            {{ __('Actualizar Categoría') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
