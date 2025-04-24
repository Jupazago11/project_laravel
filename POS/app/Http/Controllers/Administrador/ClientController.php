<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Lista los clientes de la misma compañía, con filtro por nombre y estado.
     */
    public function index(Request $request)
    {
        $search       = $request->input('search');
        $statusFilter = $request->input('status_filter');
        $companyId    = Auth::user()->company_id;

        $query = Client::where('company_id', $companyId);

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('status', $statusFilter);
        }

        $clients = $query->orderBy('name')
                         ->paginate(10)
                         ->withQueryString();

        return view('administrador.clients.index', [
            'clients'      => $clients,
            'search'       => $search,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('administrador.clients.create');
    }

    /**
     * Almacena un nuevo cliente, asignándole la compañía del admin.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'identification' => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:255',
            'credit_limit'   => 'required|numeric|min:0',
            'current_balance'=> 'nullable|numeric|min:0',
            'status'         => 'required|in:0,1',
        ]);

        Client::create(array_merge($data, [
            'company_id'      => Auth::user()->company_id,
            'current_balance' => $data['current_balance'] ?? 0,
        ]));

        return redirect()->route('administrador.clients.index')
                         ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un cliente.
     */
    public function edit(Client $client)
    {
        return view('administrador.clients.edit', compact('client'));
    }

    /**
     * Actualiza los datos de un cliente.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'identification' => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:255',
            'credit_limit'   => 'required|numeric|min:0',
            'current_balance'=> 'required|numeric|min:0',
            'status'         => 'required|in:0,1',
        ]);

        $client->update($data);

        return redirect()->route('administrador.clients.index')
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('administrador.clients.index')
                         ->with('success', 'Cliente eliminado correctamente.');
    }
}
