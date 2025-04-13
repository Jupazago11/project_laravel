<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNegocioController extends Controller
{
    /**
     * Verificamos en el constructor que el usuario sea un AdminNegocio.
     * Si no cumple, lanzamos error 403 (acceso denegado).
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->type !== 'AdminNegocio') {
                abort(403, 'Acceso denegado');
            }
            return $next($request);
        });
    }

    public function seleccionEmpresa()
    {
        $user = auth()->user();
        // Obtenemos las empresas que el AdminNegocio tenga registradas
        $empresas = $user->empresas; // Asumiendo relación belongsToMany en tu modelo User

        return view('adminnegocio.seleccion-empresa', compact('empresas'));
    }

    public function crearEmpresaForm()
    {
        // Muestra la vista con el formulario para crear una nueva empresa
        return view('adminnegocio.crear-empresa');
    }

    public function storeEmpresa(Request $request)
    {
        // Validar campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'mid'    => 'required|string|max:50',
        ]);

        // Crear la nueva empresa
        $empresa = Empresa::create([
            'nombre'    => $request->nombre,
            'mid'       => $request->mid,
            'direccion' => $request->direccion ?? '',
        ]);

        // Asociar la nueva empresa al usuario (AdminNegocio) actual
        auth()->user()->empresas()->attach($empresa->id);

        // Redirigir al dashboard de esa empresa
        return redirect()->route('adminnegocio.dashboard', $empresa->id);
    }

    public function dashboard(Empresa $empresa)
    {
        $user = auth()->user();

        // Verifica que el usuario tenga acceso a esta empresa
        if (!$user->empresas->contains($empresa->id)) {
            abort(403, 'No tienes acceso a esta empresa');
        }

        // Cargamos la vista de dashboard, pasando $user y $empresa
        return view('adminnegocio.dashboard', compact('user', 'empresa'));
    }
}

