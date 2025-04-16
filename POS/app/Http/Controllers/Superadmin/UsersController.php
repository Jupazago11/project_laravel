<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TypeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index(Request $request)
    {
        // Obtener los valores de búsqueda y filtro (si existen)
        $search = $request->input('search');
        $statusFilter = $request->input('status_filter');

        // Iniciamos la consulta con la relación typeUser
        $usersQuery = User::with('typeUser')
            ->where('type_user_id', '>', 0) // Excluimos superusuarios
            ->orderBy('id', 'asc');

        // Búsqueda por nombre o email
        if (!empty($search)) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro de estado
        if ($statusFilter !== null && $statusFilter !== '') {
            $usersQuery->where('status', $statusFilter);
        }

        // Paginamos
        $users = $usersQuery->paginate(10);

        // Retornamos la vista con la info necesaria
        return view('superadmin.users.index', [
            'users' => $users,
            'search' => $search,
            'statusFilter' => $statusFilter,
        ]);
    }


    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        // Obtiene todos los tipos de usuario; si deseas excluir el Superadmin (por ejemplo, id 0), puedes filtrarlo.
        $types = TypeUser::where('id', '>', 0)->get();
        return view('superadmin.users.create', compact('types'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos ingresados
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            // Puedes validar otros campos, por ejemplo: type_user_id, status, etc.
        ]);

        // Crear el usuario; recuerda encriptar la contraseña
        $user = new User();
        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        
        // Puedes establecer otros campos, por ejemplo:
        // $user->type_user_id = $request->input('type_user_id'); 
        // Por ejemplo, para registrar un usuario de cualquier tipo, lo definirás según convenga.

        $user->save();

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    /**
     * Actualiza los datos de un usuario.
     */
    public function update(Request $request, User $user)
    {
        // Validar los datos
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // Sólo actualizar la contraseña si se ingresó un valor
        if(!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
