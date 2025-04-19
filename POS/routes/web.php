<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\UsersController as SuperUsersController;
use App\Http\Controllers\Superadmin\CompanyController;
use App\Http\Controllers\Administrador\UsersController as AdminUsersController;
use App\Http\Controllers\Administrador\ProviderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'));
Route::get('/info', fn() => view('info'));

/*
|--------------------------------------------------------------------------
| Autenticación (login, register, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (solo usuarios autenticados y verificados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified'])->group(function(){

    /*
    |--------------------------------------------------------------------------
    | Superadmin (type_user_id === 1)
    |--------------------------------------------------------------------------
    */
    Route::prefix('superadmin')
         ->name('superadmin.')
         ->group(function(){
        Route::get('dashboard', fn() => view('superadmin.dashboard'))
             ->name('dashboard');
        Route::resource('users',     SuperUsersController::class)
             ->names('users');
        Route::resource('companies', CompanyController::class)
             ->names('companies');
    });

    /*
    |--------------------------------------------------------------------------
    | Administrador (type_user_id === 2)
    |--------------------------------------------------------------------------
    */
    Route::prefix('administrador')
         ->name('administrador.')
         ->group(function(){
          Route::get('dashboard', fn() => view('administrador.dashboard'))
               ->name('dashboard');
          Route::resource('users', AdminUsersController::class)
               ->names('users');
          Route::resource('providers', ProviderController::class)
               ->names('providers');
    });

    /*
    |--------------------------------------------------------------------------
    | Empleado (type_user_id >= 3)
    |--------------------------------------------------------------------------
    */
    Route::get('dashboard/empleado', fn() => view('empleado.dashboard'))
         ->name('empleado.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Perfil (todos los usuarios)
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')
         ->name('profile.')
         ->group(function(){
        Route::get('/',    [ProfileController::class,'edit'])->name('edit');
        Route::patch('/',  [ProfileController::class,'update'])->name('update');
        Route::delete('/', [ProfileController::class,'destroy'])->name('destroy');
    });

});
