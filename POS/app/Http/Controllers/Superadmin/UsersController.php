<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\Company;
use App\Models\UserInfo;
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
        // 1) Obtener parámetros de búsqueda y filtros
        $search        = $request->input('search');
        $statusFilter  = $request->input('status_filter');
        $typeFilter    = $request->input('type_filter');
        $companyFilter = $request->input('company_filter');

        // 2) Construir la consulta base (excluyendo superadmins)
        $usersQuery = User::with('typeUser', 'company')
            ->where('type_user_id', '>', 1)
            ->orderBy('id', 'asc');

        // 3) Aplicar filters si vienen
        if (!empty($search)) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($statusFilter !== null && $statusFilter !== '') {
            $usersQuery->where('status', $statusFilter);
        }

        if ($typeFilter !== null && $typeFilter !== '') {
            $usersQuery->where('type_user_id', $typeFilter);
        }

        // Solo filtrar por compañía si se seleccionó una concreta
        if ($companyFilter !== null && $companyFilter !== '') {
            $usersQuery->where('company_id', $companyFilter);
        }

        // 4) Paginación
        $users = $usersQuery->paginate(10);

        // 5) Listas para los selects
        $typeUsers = TypeUser::all();
        $companies = Company::all();

        return view('superadmin.users.index', [
            'users'         => $users,
            'search'        => $search,
            'statusFilter'  => $statusFilter,
            'typeFilter'    => $typeFilter,
            'companyFilter' => $companyFilter,
            'typeUsers'     => $typeUsers,
            'companies'     => $companies,
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
            'company_id'     => 'nullable|exists:company,id',
        ]);

         // 2) Crear un registro vacío en user_info (todos los campos son nullable)
        $info = UserInfo::create([]);

        // 3) Crear el usuario y asignarle el user_info_id recién creado
        $user = User::create([
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'password'       => Hash::make($validated['password']),
            'type_user_id'   => $validated['type_user_id'],
            'status'         => $validated['status'],
            'company_id'     => $validated['company_id'] ?? null,
            'user_info_id'   => $info->id,
        ]);

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
