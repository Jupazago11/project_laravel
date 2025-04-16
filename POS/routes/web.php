<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\UsersController; // Asegúrate de usar el namespace correcto.
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
    return view('info');
});

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Usuarios Autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | Dashboard Genérico (Superadmin Dashboard)
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard/superadmin', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');

    /*
    |----------------------------------------------------------------------
    | Módulo "Users" para Superadmin (CRUD completo)
    |----------------------------------------------------------------------
    | Se define una ruta resource para manejar todo el CRUD. Esto generará
    | rutas como 'superadmin.users.index', 'superadmin.users.create', etc.
    */
    Route::resource('/superadmin/users', UsersController::class)
         ->names('superadmin.users');

    // CRUD completo para Company
    Route::resource('/superadmin/companies', App\Http\Controllers\Superadmin\CompanyController::class)
    ->names('superadmin.companies');
    /*
    |----------------------------------------------------------------------
    | Rutas de Perfil
    |----------------------------------------------------------------------
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /*
    |----------------------------------------------------------------------
    | Rutas para Administradores (type_user_id === 2)
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard/administrador', function () {
        return view('administrador.dashboard');
    })->name('administrador.dashboard');

    Route::get('/administrador/users', function () {
        return view('administrador.users');
    })->name('administrador.users');

    /*
    |----------------------------------------------------------------------
    | Rutas para Empleados (type_user_id >= 3)
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard/empleado', function () {
        return view('empleado.dashboard');
    })->name('empleado.dashboard');



        

});
