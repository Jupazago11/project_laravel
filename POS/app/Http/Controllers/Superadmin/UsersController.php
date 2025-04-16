<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda y filtros
        $search = $request->input('search');
        $statusFilter = $request->input('status_filter');
        $typeFilter = $request->input('type_filter');

        // Construir la consulta base
        $usersQuery = User::with('typeUser')
            // Si deseas excluir superusuarios, ajusta el filtro, por ejemplo: 
            ->where('type_user_id', '>', 1)
            ->orderBy('id', 'asc');

        // Filtrar por búsqueda (nombre o email)
        if (!empty($search)) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtrar por estado
        if ($statusFilter !== null && $statusFilter !== '') {
            $usersQuery->where('status', $statusFilter);
        }

        // Filtrar por tipo de usuario
        if ($typeFilter !== null && $typeFilter !== '') {
            $usersQuery->where('type_user_id', $typeFilter);
        }

        // Paginación
        $users = $usersQuery->paginate(10);

        // Obtener la lista de tipos de usuario para el select
        $typeUsers = TypeUser::all();

        return view('superadmin.users.index', [
            'users' => $users,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'typeFilter' => $typeFilter,
            'typeUsers' => $typeUsers,
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
            'password' => 'required|string|min:4|confirmed',
            'type_user_id' => 'required|integer',
            'status'       => 'required|in:0,1', // 0 o 1
        ]);

        // Crear el usuario; recuerda encriptar la contraseña
        $user = new User();
        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->type_user_id = $validated['type_user_id'];
        $user->status       = $validated['status'];
        $user->save();

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        $typeUsers  = TypeUser::all();
        $companies  = Company::all();
        return view('superadmin.users.edit', compact('user','typeUsers','companies'));
    }

    /**
     * Actualiza los datos de un usuario.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'           => ['required','string','max:255'],
            'email'          => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'password'       => ['nullable','string','confirmed','min:4'],
            'type_user_id'   => ['required','exists:type_users,id'],
            'status'         => ['required','boolean'],
            'company_id'     => ['nullable','exists:company,id'],
        ]);

        // Si viene contraseña: la hasheamos
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Asignamos el resto de campos
        $user->fill([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'type_user_id' => $data['type_user_id'],
            'status'       => $data['status'],
            'company_id'   => $data['company_id'],
        ])->save();

        return redirect()->route('superadmin.users.index')
                         ->with('success','Usuario actualizado correctamente.');
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
