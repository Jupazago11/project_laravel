<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $search       = $request->input('search');
        $statusFilter = $request->input('status_filter');

        $companyId = Auth::user()->company_id;

        $query = Provider::with('company')
            ->where('company_id', $companyId)
            ->orderBy('name', 'asc');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('status', $statusFilter);
        }

        $providers = $query->paginate(10);

        return view('administrador.providers.index', compact('providers','search','statusFilter'));
    }

    public function create()
    {
        return view('administrador.providers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:150',
            'nit'           => 'nullable|string|max:50',
            'address'       => 'nullable|string|max:200',
            'contact_name'  => 'nullable|string|max:150',
            'contact_phone' => 'nullable|string|max:20',
            'status'        => 'required|in:0,1',
        ]);

        $data['company_id'] = Auth::user()->company_id;

        Provider::create($data);

        return redirect()->route('administrador.providers.index')
                         ->with('success','Proveedor creado correctamente.');
    }

    public function edit(Provider $provider)
    {
        return view('administrador.providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:150',
            'nit'           => 'nullable|string|max:50',
            'address'       => 'nullable|string|max:200',
            'contact_name'  => 'nullable|string|max:150',
            'contact_phone' => 'nullable|string|max:20',
            'status'        => 'required|in:0,1',
        ]);

        $provider->update($data);

        return redirect()->route('administrador.providers.index')
                         ->with('success','Proveedor actualizado correctamente.');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();

        return redirect()->route('administrador.providers.index')
                         ->with('success','Proveedor eliminado correctamente.');
    }
}
