<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Verificar que sea superadmin
        if (!Auth::check() || Auth::user()->type !== 'SuperAdmin') {
            abort(403, 'Acceso denegado');
        }

        // Lógica de superadmin...
        return view('superadmin.dashboard');
    }
}
