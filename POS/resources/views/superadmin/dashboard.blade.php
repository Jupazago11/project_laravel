<x-app-layout>
<x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Mensaje por defecto --}}
                    {{ __('You\'re logged in!') }}
                    
                    {{-- Nuevo bloque para el saludo personalizado --}}
                    <div class="mt-6">
                        <p class="mb-2">
                            Hola, <span class="font-bold">{{ Auth::user()->name }}</span>
                        </p>
                        <p>
                            Tu tipo de usuario es: 
                            <span class="font-bold">
                                @if(Auth::user()->typeUser)
                                    {{ Auth::user()->typeUser->type }}
                                @else
                                    No asignado
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
