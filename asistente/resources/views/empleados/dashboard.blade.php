@extends('layouts.app')

@section('content')
<div class="w3-card w3-padding w3-margin">
    <h2>Bienvenido, {{ $roleName }} {{ $user->name }}</h2>

    <p>Empresas a las que tienes acceso:</p>
    <ul>
        @foreach($user->empresas as $emp)
            <li>{{ $emp->nombre }}</li>
        @endforeach
    </ul>

    <p>Aquí puedes agregar enlaces a los módulos que cada rol necesite: Caja, Inventarios, etc.</p>
</div>
@endsection
