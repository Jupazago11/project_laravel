@extends('layouts.app')

@section('title', 'Dashboard de Empresa')

@section('content')
<div class="w3-card w3-padding w3-margin">
    <h2>Bienvenido, {{ $user->type }} {{ $user->name }}</h2>
    <p>Estás gestionando la empresa: <strong>{{ $empresa->nombre }}</strong></p>

    <div class="w3-panel w3-light-grey w3-border">
        <p>Esta es la pantalla principal para administrar la empresa seleccionada.</p>
        <ul>
            <li>Gestión de Empleados</li>
            <li>Inventarios</li>
            <li>Ventas</li>
            <!-- y más módulos que vayas agregando -->
        </ul>
    </div>
</div>
@endsection
