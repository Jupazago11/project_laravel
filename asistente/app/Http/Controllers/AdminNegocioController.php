
<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class AdminNegocioController extends Controller
{
    public function seleccionEmpresa()
    {
        $user = auth()->user();
        $empresas = $user->empresas; // Asumiendo relación belongsToMany

        return view('adminnegocio.seleccion-empresa', compact('empresas'));
    }

    public function crearEmpresaForm()
    {
        return view('adminnegocio.crear-empresa');
    }

    public function storeEmpresa(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'mid'    => 'required|string|max:50',
        ]);

        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'mid'    => $request->mid,
            'direccion' => $request->direccion ?? '',
        ]);

        auth()->user()->empresas()->attach($empresa->id);

        return redirect()->route('adminnegocio.dashboard', $empresa->id);
    }

    public function dashboard(Empresa $empresa)
    {
        $user = auth()->user();

        // Verifica acceso
        if (!$user->empresas->contains($empresa->id)) {
            abort(403, 'No tienes acceso a esta empresa');
        }

        return view('adminnegocio.dashboard', compact('user', 'empresa'));
    }
}
