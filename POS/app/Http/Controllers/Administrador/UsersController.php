<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\Company;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UsersController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index(Request $request)
    {
        // 1) Parámetros de búsqueda/filtro
        $search       = $request->input('search');
        $statusFilter = $request->input('status_filter');
        $typeFilter   = $request->input('type_filter');

        // 2) Determinar la company del admin logueado
        $companyId = Auth::user()->company_id;

        // 3) Construir la consulta base:
        // - usuarios de esta misma company
        // - excluyendo superusuarios (type_user_id = 1)
        // - ordenados por id asc
        $usersQuery = User::with('typeUser')
            ->where('company_id', $companyId)
            ->where('type_user_id', '>', 1)
            ->orderBy('id', 'asc');

        // 4) Aplicar búsqueda por nombre o email
        if (!empty($search)) {
            $usersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 5) Filtro por estado
        if ($statusFilter !== null && $statusFilter !== '') {
            $usersQuery->where('status', $statusFilter);
        }

        // 6) Filtro por tipo de usuario
        if ($typeFilter !== null && $typeFilter !== '' && $typeFilter > 1) {
            $usersQuery->where('type_user_id', $typeFilter);
        }

        // 7) Paginación y carga de datos auxiliares
        $users     = $usersQuery->paginate(10)->withQueryString();
        $typeUsers = TypeUser::where('id','>',1)->get();

        return view('administrador.users.index', [
            'users'        => $users,
            'search'       => $search,
            'statusFilter' => $statusFilter,
            'typeFilter'   => $typeFilter,
            'typeUsers'    => $typeUsers, 
        ]);
    }


    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        // Obtiene todos los tipos de usuario; si deseas excluir el administrador (por ejemplo, id 0), puedes filtrarlo.
        $types = TypeUser::where('id', '>', 1)->get();
        return view('administrador.users.create', compact('types'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // 1) Validar datos (sin company_id)
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|string|min:4|confirmed',
            'type_user_id' => 'required|exists:type_users,id',
            'status'       => 'required|in:0,1',
        ]);

        // 2) Crear un registro vacío en user_info
        $info = UserInfo::create();

        // 3) Crear el usuario asignándole:
        //    - company_id del usuario autenticado
        //    - user_info_id recién creado
        $user = User::create([
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'password'       => Hash::make($validated['password']),
            'type_user_id'   => $validated['type_user_id'],
            'status'         => $validated['status'],
            'company_id'     => Auth::user()->company_id,
            'user_info_id'   => $info->id,
        ]);

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Usuario creado correctamente.');
        }
    

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        $typeUsers  = TypeUser::all();
        $companies  = Company::all();
        return view('administrador.users.edit', compact('user','typeUsers','companies'));
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

        return redirect()->route('administrador.users.index')
                         ->with('success','Usuario actualizado correctamente.');
    }


    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('administrador.users.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
