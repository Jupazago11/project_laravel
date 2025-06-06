<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('administrador.clients.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-gray-700">Nombre <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full border p-2 rounded"
                            required
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Identificación</label>
                            <input
                                type="text"
                                name="identification"
                                value="{{ old('identification') }}"
                                class="w-full border p-2 rounded"
                            />
                        </div>
                        <div>
                            <label class="block text-gray-700">Teléfono</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full border p-2 rounded"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700">Dirección</label>
                        <input
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            class="w-full border p-2 rounded"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Límite de Crédito <span class="text-red-500">*</span></label>
                            <input
                                type="number"
                                step="0.01"
                                name="credit_limit"
                                value="{{ old('credit_limit', 0) }}"
                                class="w-full border p-2 rounded"
                                required
                            />
                        </div>
                        <div>
                            <label class="block text-gray-700">Saldo Actual</label>
                            <input
                                type="number"
                                step="0.01"
                                readonly
                                name="current_balance"
                                value="{{ old('current_balance', 0) }}"
                                class="w-full p-2 rounded w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700">Estado <span class="text-red-500">*</span></label>
                        <select
                            name="status"
                            class="w-full border p-2 rounded"
                            required
                        >
                            <option value="1" {{ old('status','1')=='1'?'selected':'' }}>Activo</option>
                            <option value="0" {{ old('status')=='0'?'selected':'' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                        >Crear Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
