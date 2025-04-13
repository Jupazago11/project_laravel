@extends('layouts.app')

@section('title', 'Crear Empleado')

@section('content')
<div class="w3-card w3-margin w3-padding">
    <h2>Crear Empleado</h2>

    @if(session('success'))
        <div class="w3-panel w3-pale-green w3-border">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="w3-panel w3-pale-red w3-border">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('empleados.store') }}" method="POST" class="w3-container">
        @csrf

        <label for="name"><b>Nombre</b></label>
        <input type="text" name="name" id="name" class="w3-input w3-border w3-margin-bottom" required>

        <label for="email"><b>Correo</b></label>
        <input type="email" name="email" id="email" class="w3-input w3-border w3-margin-bottom" required>

        <label for="role_id"><b>Rol</b></label>
        <select name="role_id" id="role_id" class="w3-select w3-border w3-margin-bottom" required>
            <option value="" disabled selected>Selecciona un rol</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
            @endforeach
        </select>

        <p><b>Empresas a las que tendrá acceso:</b></p>
        @foreach($empresas as $empresa)
            <label class="w3-block">
                <input type="checkbox" name="empresas[]" value="{{ $empresa->id }}" 
                       class="w3-check">
                {{ $empresa->nombre }}
            </label>
        @endforeach

        <button type="submit" class="w3-button w3-blue w3-margin-top">Guardar</button>
    </form>
</div>
@endsection
