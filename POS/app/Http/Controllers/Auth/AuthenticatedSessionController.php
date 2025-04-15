<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Si el usuario es Administrador (type_user_id === 2)
        if ($user->type_user_id === 2) {
            return redirect()->route('admin.dashboard');
        }

        // Para otros roles, redirige al dashboard general
        return redirect()->intended(route('dashboard', false));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        // Si el usuario es Administrador de Negocios, cuyo tipo es 2
        if ($user->type_user_id === 2) {
            return redirect()->route('admin.pre_dashboard');
        }
        
        // Para otros roles, redirige a su dashboard general o según corresponda
        return redirect('/dashboard');
    }

}
