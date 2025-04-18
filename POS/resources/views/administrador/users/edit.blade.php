<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Editar Usuario') }}
    </h2>
  </x-slot>

  <div class="py-8 max-w-3xl mx-auto" x-data="{ step: 1 }" x-cloak>
    <!-- NAV PESTAÑAS -->
    <div class="mb-6 border-b border-gray-200">
      <nav class="-mb-px flex space-x-8">
        <button
          type="button"
          @click="step = 1"
          class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
          :class="step === 1
            ? 'border-blue-600 text-blue-600'
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        >
          Usuario
        </button>
        <button
          type="button"
          @click="step = 2"
          class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
          :class="step === 2
            ? 'border-blue-600 text-blue-600'
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
        >
          Adicional
        </button>
      </nav>
    </div>

    <form method="POST" action="{{ route('administrador.users.update', $user) }}">
      @csrf @method('PUT')

      <!-- PASO 1: DATOS DEL USUARIO -->
      <div x-show="step === 1" x-transition class="space-y-4">
        <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
          <h3 class="text-lg font-medium">Datos del Usuario</h3>

          <!-- Nombre -->
          <div>
            <label class="block text-gray-700">Nombre</label>
            <input name="name" type="text"
                   value="{{ old('name', $user->name) }}"
                   class="w-full border rounded px-3 py-2" required>
          </div>

          <!-- Email -->
          <div>
            <label class="block text-gray-700">Email</label>
            <input name="email" type="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full border rounded px-3 py-2" required>
          </div>

          <!-- Contraseña -->
          <div>
            <label class="block text-gray-700">Contraseña (dejala en blanco para no cambiar)</label>
            <input name="password" type="password"
                   class="w-full border rounded px-3 py-2">
          </div>

          <!-- Confirmar Contraseña -->
          <div>
            <label class="block text-gray-700">Confirmar Contraseña</label>
            <input name="password_confirmation" type="password"
                   class="w-full border rounded px-3 py-2">
          </div>

          <!-- Tipo de Usuario -->
          <div>
            <label class="block text-gray-700">Tipo de Usuario</label>
            <select name="type_user_id"
                    class="w-full border rounded px-3 py-2">
              @foreach($typeUsers as $type)
                @if($type->id > 1)
                  <option value="{{ $type->id }}"
                    {{ old('type_user_id', $user->type_user_id) == $type->id ? 'selected' : '' }}>
                    {{ $type->type }}
                  </option>
                @endif
              @endforeach
            </select>
          </div>

          <!-- Estado -->
          <div>
            <label class="block text-gray-700">Estado</label>
            <select name="status"
                    class="w-full border rounded px-3 py-2">
              <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>

          <!-- Compañía -->
          <div>
            <label class="block text-gray-700">Compañía</label>
            <select name="company_id"
                    class="w-full border rounded px-3 py-2">
              @foreach($companies as $c)
                <option value="{{ $c->id }}"
                  {{ old('company_id', $user->company_id) == $c->id ? 'selected' : '' }}>
                  {{ $c->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <!-- PASO 2: INFORMACIÓN ADICIONAL -->
      <div x-show="step === 2" x-transition class="space-y-4">
        <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
          <h3 class="text-lg font-medium">Información Adicional</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-gray-700">Identificación</label>
              <input name="identification" type="text"
                     value="{{ old('identification', $user->info->identification) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Celular</label>
              <input name="cellphone" type="text"
                     value="{{ old('cellphone', $user->info->cellphone) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Fecha de Nacimiento</label>
              <input name="birth_date" type="date"
                     value="{{ old('birth_date', $user->info->birth_date) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">EPS</label>
              <input name="eps" type="text"
                     value="{{ old('eps', $user->info->eps) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Caja de Compensación</label>
              <input name="compensation_box" type="text"
                     value="{{ old('compensation_box', $user->info->compensation_box) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">ARL</label>
              <input name="arl" type="text"
                     value="{{ old('arl', $user->info->arl) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Pensión</label>
              <input name="pension" type="text"
                     value="{{ old('pension', $user->info->pension) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Salario</label>
              <input name="salary" type="number" step="0.01"
                     value="{{ old('salary', $user->info->salary) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Fecha de Ingreso</label>
              <input name="hire_date" type="date"
                     value="{{ old('hire_date', $user->info->hire_date) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Tipo de Contrato</label>
              <input name="contract_type" type="text"
                     value="{{ old('contract_type', $user->info->contract_type) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div>
              <label class="block text-gray-700">Duración Contrato (meses)</label>
              <input name="contract_duration" type="number"
                     value="{{ old('contract_duration', $user->info->contract_duration) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div class="sm:col-span-2">
              <label class="block text-gray-700">Fecha de Vigencia</label>
              <input name="contract_date" type="date"
                     value="{{ old('contract_date', $user->info->contract_date) }}"
                     class="w-full border rounded px-3 py-2">
            </div>

            <div class="sm:col-span-2">
              <label class="block text-gray-700">Observación</label>
              <textarea name="observation"
                        class="w-full border rounded px-3 py-2"
                        rows="3">{{ old('observation', $user->info->observation) }}</textarea>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!-- BOTONES -->
      <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                Actualizar Usuario
            </button>
        </div>
    </form>
  </div>
</x-app-layout>
