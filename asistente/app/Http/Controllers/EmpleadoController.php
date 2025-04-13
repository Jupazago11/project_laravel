<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
{
    /**
     * Verificamos en el constructor el tipo de usuario
     * según el método que se está llamando.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $action = $request->route()->getActionMethod();
            /*
             * Si el método es "create" o "store", 
             * queremos asegurarnos de que sea un AdminNegocio quien crea empleados.
             */
            if (in_array($action, ['create', 'store'])) {
                if (!$user || $user->type !== 'AdminNegocio') {
                    abort(403, 'Acceso denegado: Solo un AdminNegocio puede crear empleados.');
                }
            }
            /*
             * Si el método es "dashboard", 
             * queremos asegurarnos de que sea un Empleado quien acceda al dashboard.
             */
            elseif ($action === 'dashboard') {
                if (!$user || $user->type !== 'Empleado') {
                    abort(403, 'Acceso denegado: Solo un Empleado puede acceder a este dashboard.');
                }
            }

            return $next($request);
        });
    }

    /**
     * Formulario para que el AdminNegocio cree un nuevo empleado.
     */
    public function create()
    {
        // Dado que es AdminNegocio, puede ver sus empresas
        $admin = auth()->user();
        $empresas = $admin->empresas;  // Asumiendo que $admin->empresas es belongsToMany
        $roles = Role::all();

        return view('empleados.create', compact('empresas', 'roles'));
    }

    /**
     * Guarda el nuevo empleado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role_id'  => 'required|exists:roles,id',
            'empresas' => 'required|array', // IDs de empresas
        ]);

        // Crear el usuario con type=Empleado
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('contraseñaSegura'), // O un pass random
            'type'     => 'Empleado',
        ]);

        // Crear registro en tabla empleados
        $empleado = Empleado::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
        ]);

        // Asignar al empleado las empresas seleccionadas
        $user->empresas()->sync($request->empresas);

        return redirect()->back()->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Dashboard de un Empleado, accesible solo para user->type = Empleado.
     */
    public function dashboard()
    {
        $user = auth()->user();
        // Aquí, el constructor ya validó que sea Empleado,
        // pero si quieres, puedes hacer lógica extra para el dashboard.
        return view('empleados.dashboard', compact('user'));
    }
}
