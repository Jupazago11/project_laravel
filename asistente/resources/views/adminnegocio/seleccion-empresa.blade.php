@extends('layouts.app') 
{{-- Asumiendo que tienes un layout base con W3.CSS o tu CSS preferido --}}

@section('title', 'Seleccionar Empresa')

@section('content')
<div class="w3-card w3-padding w3-margin">
    <h2>Seleccione una Empresa o Cree una Nueva</h2>

    @if($empresas->count() === 0)
        <p>No tienes empresas registradas.</p>
        <a href="{{ route('adminnegocio.crear-empresa') }}" class="w3-button w3-green">
            Crear Nueva Empresa
        </a>
    @else
        <ul class="w3-ul">
            @foreach($empresas as $empresa)
                <li>
                    <strong>{{ $empresa->nombre }}</strong>
                    <br>
                    <a href="{{ route('adminnegocio.dashboard', $empresa->id) }}" 
                       class="w3-button w3-blue w3-small">
                       Continuar
                    </a>
                </li>
            @endforeach
        </ul>
        <hr>
        <a href="{{ route('adminnegocio.crear-empresa') }}" class="w3-button w3-green">
            Crear Otra Empresa
        </a>
    @endif
</div>
@endsection
