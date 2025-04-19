<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Mostrar la lista de categorías de la misma compañía del admin.
     */
    public function index(Request $request)
    {
        $search       = $request->input('search');
        $statusFilter = $request->input('status_filter');
        $companyId    = Auth::user()->company_id;

        $query = Category::where('company_id', $companyId)
                         ->orderBy('id', 'asc');

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('status', $statusFilter);
        }

        $categories = $query->paginate(10);

        return view('administrador.categories.index', compact(
            'categories', 'search', 'statusFilter'
        ));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('administrador.categories.create');
    }

    /**
     * Almacenar nueva categoría.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        Category::create([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'description' => $data['description'],
            'status'      => $data['status'],
            'company_id'  => Auth::user()->company_id,
        ]);

        return redirect()
            ->route('administrador.categories.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Category $category)
    {
        $this->authorizeCompany($category);

        return view('administrador.categories.edit', compact('category'));
    }

    /**
     * Actualizar categoría.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorizeCompany($category);

        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        $category->update([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'description' => $data['description'],
            'status'      => $data['status'],
        ]);

        return redirect()
            ->route('administrador.categories.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Eliminar categoría.
     */
    public function destroy(Category $category)
    {
        $this->authorizeCompany($category);

        $category->delete();

        return redirect()
            ->route('administrador.categories.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    /**
     * Abortar si la categoría no pertenece a la compañía del admin.
     */
    protected function authorizeCompany(Category $category)
    {
        if ($category->company_id !== Auth::user()->company_id) {
            abort(403, 'No tienes permiso para manipular esta categoría.');
        }
    }
}
