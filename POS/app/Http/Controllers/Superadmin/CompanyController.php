<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        // búsqueda opcional
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nit', 'like', "%{$search}%");
        }

        // filtro opcional de estado
        if (null !== ($status = $request->input('status'))) {
            $query->where('status', $status);
        }

        $companies = $query->orderBy('id','asc')->paginate(10)
                           ->withQueryString();

        return view('superadmin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('superadmin.companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:150',
            'nit'       => 'required|string|max:50',
            'direction' => 'required|string|max:200',
            'status'    => 'required|in:0,1',
        ]);

        Company::create($data);

        return redirect()->route('superadmin.companies.index')
                         ->with('success','Company creada correctamente.');
    }

    public function show(Company $company)
    {
        return view('superadmin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('superadmin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:150',
            'nit'       => 'required|string|max:50',
            'direction' => 'required|string|max:200',
            'status'    => 'required|in:0,1',
        ]);

        $company->update($data);

        return redirect()->route('superadmin.companies.index')
                         ->with('success','Company actualizada correctamente.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('superadmin.companies.index')
                         ->with('success','Company eliminada correctamente.');
    }
}
