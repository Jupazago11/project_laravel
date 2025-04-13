@extends('layouts.app')

@section('title', 'Crear Empresa')

@section('content')
<div class="w3-card w3-padding w3-margin">
    <h2>Crear Nueva Empresa</h2>

    @if($errors->any())
        <div class="w3-panel w3-pale-red w3-border">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adminnegocio.store-empresa') }}" method="POST" class="w3-container">
        @csrf

        <label for="nombre" class="w3-text-black"><b>Nombre de la Empresa</b></label>
        <input type="text" name="nombre" id="nombre" 
               class="w3-input w3-border w3-margin-bottom" required>

        <label for="mid" class="w3-text-black"><b>MID</b></label>
        <input type="text" name="mid" id="mid" 
               class="w3-input w3-border w3-margin-bottom" required>

        <label for="direccion" class="w3-text-black"><b>Dirección (opcional)</b></label>
        <input type="text" name="direccion" id="direccion" 
               class="w3-input w3-border w3-margin-bottom">

        <button type="submit" class="w3-button w3-blue">Guardar</button>
    </form>
</div>
@endsection
