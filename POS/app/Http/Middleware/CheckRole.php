<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja la solicitud entrante y verifica que el usuario tenga el rol requerido.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $roleRequired El rol requerido, por ejemplo, 'administrador'
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roleRequired)
    {
        // Verifica que el usuario esté autenticado
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Castea a entero el campo type_user_id para comparar numéricamente
        $userType = (int) Auth::user()->type_user_id;

        // Si se requiere el rol 'administrador' y el usuario no tiene el valor 2, se deniega el acceso
        if ($roleRequired === 'administrador' && $userType !== 2) {
            abort(403, 'Acceso reservado solo para Administradores.');
        }

        // Puedes agregar condiciones adicionales para otros roles aquí, por ejemplo:
        // if ($roleRequired === 'empleado' && $userType < 3) { ... }

        return $next($request);
    }
}
