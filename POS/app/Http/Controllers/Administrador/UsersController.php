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
        // 1) Recoger filtros
        $search        = $request->input('search');
        $statusFilter  = $request->input('status_filter');
        $typeFilter    = $request->input('type_filter');
        $companyFilter = $request->input('company_filter');

        // 2) Sólo usuarios de la misma company que el admin
        $companyId = Auth::user()->company_id;

        // 3) Construir la consulta base
        $query = User::with(['typeUser', 'company'])
            ->where('company_id', $companyId)
            ->where('type_user_id', '>', 1)
            ->orderBy('id', 'asc');

        // 4) Aplicar filtros opcionales
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('status', $statusFilter);
        }

        if ($typeFilter !== null && $typeFilter !== '') {
            $query->where('type_user_id', $typeFilter);
        }

        if ($companyFilter !== null && $companyFilter !== '') {
            $query->where('company_id', $companyFilter);
        }

        // 5) Ejecutar paginación (y conservar query string)
        $users = $query->paginate(10)
                       ->appends($request->except('page'));

        // 6) Datos para los selects
        $typeUsers = TypeUser::where('id','>',1)->get();
        // Si quieres que el admin sólo vea su empresa en el filtro:
        // $companies = Company::where('id', $companyId)->get();
        // O para ver todas las de su grupo:
        $companies = Company::where('id', $companyId)->get();

        // 7) Renderizar la vista de Administrador
        return view('administrador.users.index', compact(
            'users',
            'search',
            'statusFilter',
            'typeFilter',
            'companyFilter',
            'typeUsers',
            'companies'
        ));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        // Asegurarnos de cargar la relación info
        $user->load('info');

        $typeUsers = TypeUser::all();
        $companies = Company::all();

        return view('administrador.users.edit', compact('user', 'typeUsers', 'companies'));
    }

    /**
     * Actualiza los datos de un usuario y su info relacionada.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            // Campos de users
            'name'           => ['required','string','max:255'],
            'email'          => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'password'       => ['nullable','string','confirmed','min:4'],
            'type_user_id'   => ['required','exists:type_users,id'],
            'status'         => ['required','boolean'],
            'company_id'     => ['nullable','exists:company,id'],

            // Campos de user_info
            'identification'      => ['nullable','string','max:20'],
            'cellphone'           => ['nullable','string','max:20'],
            'birth_date'          => ['nullable','date'],
            'eps'                 => ['nullable','string','max:50'],
            'compensation_box'    => ['nullable','string','max:50'],
            'arl'                 => ['nullable','string','max:50'],
            'pension'             => ['nullable','string','max:50'],
            'salary'              => ['nullable','numeric'],
            'hire_date'           => ['nullable','date'],
            'contract_type'       => ['nullable','string','max:30'],
            'contract_duration'   => ['nullable','integer'],
            'contract_date'       => ['nullable','date'],
            'observation'         => ['nullable','string'],
        ]);

        // Si llegan datos de contraseña, la actualizamos
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Guardamos los datos de users
        $user->fill([
            'name'           => $data['name'],
            'email'          => $data['email'],
            'type_user_id'   => $data['type_user_id'],
            'status'         => $data['status'],
            'company_id'     => $data['company_id'],
        ])->save();

        // Si no existe aún info, crearlo
        if (! $user->info) {
            $user->info()->create([]);
        }

        // Guardamos los datos de user_info
        $user->info->update([
            'identification'    => $data['identification']      ?? null,
            'cellphone'         => $data['cellphone']           ?? null,
            'birth_date'        => $data['birth_date']          ?? null,
            'eps'               => $data['eps']                 ?? null,
            'compensation_box'  => $data['compensation_box']    ?? null,
            'arl'               => $data['arl']                 ?? null,
            'pension'           => $data['pension']             ?? null,
            'salary'            => $data['salary']              ?? null,
            'hire_date'         => $data['hire_date']           ?? null,
            'contract_type'     => $data['contract_type']       ?? null,
            'contract_duration' => $data['contract_duration']   ?? null,
            'contract_date'     => $data['contract_date']       ?? null,
            'observation'       => $data['observation']         ?? null,
        ]);

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function create()
    {
        // Traigo los tipos de usuario (sin superadmin, id=1)
        $typeUsers = TypeUser::where('id','>',1)->get();

        // Traigo las compañías (para asignar)
        $companies = Company::all();

        return view('administrador.users.create', compact('typeUsers','companies'));
    }

    public function store(Request $request)
    {
        // 1) Valida SOLO lo que el admin introduce:
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|string|min:4|confirmed',
            'type_user_id'  => 'required|exists:type_users,id',
            'status'        => 'required|in:0,1',
        ]);

        // 2) Crea el registro vacío en user_info:
        $info = UserInfo::create();

        // 3) Crea el usuario, forzando la misma empresa del admin logueado:
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
}
