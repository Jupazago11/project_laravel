<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Editar Company') }}
    </h2>
  </x-slot>

  <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
      @if($errors->any())
        <ul class="mb-4 list-disc text-sm text-red-600">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      @endif

      <form method="POST" action="{{ route('superadmin.companies.update', $company) }}">
        @csrf @method('PUT')
        <div class="mb-4">
          <label class="block text-gray-700">Nombre</label>
          <input type="text" name="name" value="{{ old('name', $company->name) }}"
                 class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">NIT</label>
          <input type="text" name="nit" value="{{ old('nit', $company->nit) }}"
                 class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Dirección</label>
          <input type="text" name="direction" value="{{ old('direction', $company->direction) }}"
                 class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Estado</label>
          <select name="status" class="w-full border p-2 rounded" required>
            <option value="1" {{ old('status', $company->status)=='1'?'selected':'' }}>Activo</option>
            <option value="0" {{ old('status', $company->status)=='0'?'selected':'' }}>Inactivo</option>
          </select>
        </div>

        <div class="flex justify-end">
          <button type="submit"
                  class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Actualizar Company
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
