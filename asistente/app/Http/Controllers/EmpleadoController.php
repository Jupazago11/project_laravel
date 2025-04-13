<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function create()
    {
        // El AdminNegocio actual
        $admin = auth()->user();

        // Todas las empresas a las que tiene acceso
        $empresas = $admin->empresas;

        // Roles disponibles para empleados (Cajero, Auxiliar, etc.)
        $roles = Role::all();

        return view('empleados.create', compact('empresas', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role_id'  => 'required|exists:roles,id',
            'empresas' => 'required|array', // array de IDs de empresas
        ]);

        // Creamos el usuario con type = 'Empleado'
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('contraseñaSegura'), // o un pass random
            'type'     => 'Empleado',
        ]);

        // Creamos el registro en la tabla empleados
        $empleado = Empleado::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
        ]);

        // Asociamos el usuario a las empresas seleccionadas
        $user->empresas()->sync($request->empresas);

        return redirect()->back()->with('success', 'Empleado creado correctamente.');
    }
}
