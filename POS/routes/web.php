<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
    return view('info');
});

// Dashboard genérico (por defecto, para usuarios sin redirección específica)
Route::get('/dashboard/superadmin', function () {
    return view('superadmin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para el módulo "Users" en el dashboard del Super Admin
Route::get('/superadmin/users', function () {
    return view('superadmin.users');
})->name('superadmin.users');



// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para el Dashboard de Administradores (tipo Administrador, type_user_id === 2)
// y para el Dashboard de Empleados (type_user_id >= 3)
Route::middleware('auth')->group(function () {
    // Dashboard para Administradores
    Route::get('/dashboard/administrador', function () {
        return view('administrador.dashboard');
    })->name('administrador.dashboard');

    Route::get('/administrador/users', function () {
        return view('administrador.users');
    })->name('administrador.users');

    // Dashboard para Empleados
    Route::get('/dashboard/empleado', function () {
        return view('empleado.dashboard');
    })->name('employee.dashboard');
});

require __DIR__.'/auth.php';

