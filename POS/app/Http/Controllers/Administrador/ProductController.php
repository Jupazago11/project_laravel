<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Category;
use App\Models\Provider;
use App\Models\IvaRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected function authorizeCompany(Product $product)
    {
        if ($product->company_id !== Auth::user()->company_id) {
            abort(403, 'No tienes permiso para manipular este producto.');
        }
    }
    public function index(Request $request)
    {
        // 1) Leer los parámetros de entrada
        $search         = $request->input('search');
        $providerFilter = $request->input('provider_filter');
        $categoryFilter = $request->input('category_filter');
        $statusFilter   = $request->input('status_filter');
        $inventoryTrue  = $request->boolean('inventory_true');
        $inventoryFalse = $request->boolean('inventory_false');
        $companyId      = Auth::user()->company_id;

        // 2) Construir la consulta base: solo productos de la misma empresa
        $query = Product::with(['category', 'provider'])
                        ->where('company_id', $companyId);

        // 3) Filtro de búsqueda: si es numérico busca por código, si no por nombre
        if (!empty($search)) {
            if (ctype_digit($search)) {
                $query->where('product_code', 'like', "%{$search}%");
            } else {
                $query->where('name', 'like', "%{$search}%");
            }
        }

        // 4) Filtro por proveedor
        if (!empty($providerFilter)) {
            $query->where('provider_id', $providerFilter);
        }

        // 5) Filtro por categoría
        if (!empty($categoryFilter)) {
            $query->where('category_id', $categoryFilter);
        }

        // 6) Filtro por estado
        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('status', $statusFilter);
        }

        // 7) Filtro por manejo de inventario (checkboxes)
        if ($inventoryTrue && ! $inventoryFalse) {
            $query->where('track_inventory', 1);
        } elseif ($inventoryFalse && ! $inventoryTrue) {
            $query->where('track_inventory', 0);
        }

        // 8) Ejecutar la consulta con paginación y conservar los parámetros en la URL
        $products = $query->orderBy('id', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        // 9) Listados para los selects de filtro (solo activos y de la misma compañía)
        $categories = Category::where('company_id', $companyId)
                            ->where('status', 1)
                            ->orderBy('name')
                            ->get();

        $providers  = Provider::where('company_id', $companyId)
                            ->where('status', 1)
                            ->orderBy('name')
                            ->get();

        // 10) Devolver la vista con *todas* las variables necesarias
        return view('administrador.products.index', [
            'products'        => $products,
            'search'          => $search,
            'providerFilter'  => $providerFilter,
            'categoryFilter'  => $categoryFilter,
            'statusFilter'    => $statusFilter,
            'inventoryTrue'   => $inventoryTrue,
            'inventoryFalse'  => $inventoryFalse,
            'categories'      => $categories,
            'providers'       => $providers,
        ]);
    }


    public function create()
    {
        $companyId = Auth::user()->company_id;

        // Sólo categorías activas de la misma empresa
        $categories = Category::where('company_id', $companyId)
                              ->where('status', 1)
                              ->get();

        // Sólo proveedores activos de la misma empresa
        $providers = Provider::where('company_id', $companyId)
                             ->where('status', 1)
                             ->get();

        // Todas las tarifas de IVA (suponemos que siempre todas vigentes)
        $ivaRates = IvaRate::all();

        return view('administrador.products.create', compact(
            'categories', 'providers', 'ivaRates'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_code'    => [
                'nullable',
                'string',
                'max:50',
                
                Rule::unique('products', 'product_code'),
            ],
            'name'            => 'required|string|max:150',
            'description'     => 'nullable|string',
            'category_id'     => 'required|exists:category,id',
            'provider_id'     => 'required|exists:providers,id',
            'cost'            => 'required|numeric|min:0',
            'iva_rate_id'     => 'required|exists:iva_rates,id',
            'additional_tax'  => 'nullable|numeric|min:0',
            'price_1'         => 'required|numeric|min:0',
            'price_2'         => 'nullable|numeric|min:0',
            'price_3'         => 'nullable|numeric|min:0',
            'track_inventory' => 'boolean',
            'stock'           => 'nullable|integer|min:0',
            // ya no validas status aquí
        ]);

        // siempre asigna al product la misma empresa del usuario que crea
        $data['company_id']     = Auth::user()->company_id;
        $data['track_inventory'] = $request->has('track_inventory');
        
        // fuerza el status a 1 (activo)
        $data['status'] = 1;

        Product::create($data);

        return redirect()
            ->route('administrador.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    

    public function edit(Product $product)
    {
        // 1) Verifico company_id
        $this->authorizeCompany($product);

        // 2) Cargo datos para el formulario
        $companyId  = Auth::user()->company_id;
        $categories = Category::where('company_id', $companyId)->get();
        $providers  = Provider::where('company_id', $companyId)->get();
        $ivaRates   = IvaRate::all();

        return view('administrador.products.edit', compact(
            'product','categories','providers','ivaRates'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeCompany($product);

        // 1) Forzamos track_inventory a 0 o 1
        $request->merge([
            'track_inventory' => (int) $request->input('track_inventory', 0),
        ]);

        // 2) Validamos incluyendo ese campo
        $data = $request->validate([
            'product_code'    => 'nullable|string|max:50',
            'name'            => 'required|string|max:150',
            'description'     => 'nullable|string',
            'category_id'     => 'required|exists:category,id',
            'provider_id'     => 'required|exists:providers,id',
            'cost'            => 'required|numeric|min:0',
            'iva_rate_id'     => 'required|exists:iva_rates,id',
            'additional_tax'  => 'nullable|numeric|min:0',
            'price_1'         => 'required|numeric|min:0',
            'price_2'         => 'nullable|numeric|min:0',
            'price_3'         => 'nullable|numeric|min:0',
            'track_inventory' => 'required|integer|in:0,1',
            'stock'           => 'nullable|integer|min:0',
            // si status debe ser siempre 1, remuévelo de aquí y fílalo abajo
        ]);

        // 3) Fuerza el status si lo necesitas
        $data['status'] = 1;

        // 4) Actualizas sin volver a tocar track_inventory
        $product->update($data);

        return redirect()
            ->route('administrador.products.index')
            ->with('success','Producto actualizado correctamente.');
    }


    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect()->route('administrador.products.index')
                         ->with('success','Producto eliminado correctamente.');
    }
}
