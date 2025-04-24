<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\UsersController as SuperUsersController;
use App\Http\Controllers\Superadmin\CompanyController;
use App\Http\Controllers\Administrador\UsersController as AdminUsersController;
use App\Http\Controllers\Administrador\ProductController;
use App\Http\Controllers\Administrador\ClientController as AdminClientController;
use App\Http\Controllers\Administrador\PaymentController as AdminPaymentController;
use App\Http\Controllers\Administrador\ProviderController;
use App\Http\Controllers\Administrador\CategoryController;
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
          Route::resource('categories', CategoryController::class)
               ->names('categories');
          Route::resource('products', ProductController::class)
               ->names('products');
          Route::resource('clients', AdminClientController::class)
               ->names('clients');

          Route::resource('payments/{client}', AdminPaymentController::class)
               ->names('payments');
               Route::get('payments/{client}', [AdminPaymentController::class, 'index'])
               ->name('payments.index');
      
          Route::get('payments/{client}/create', [AdminPaymentController::class, 'create'])
               ->name('payments.create');
      
          Route::post('payments/{client}', [AdminPaymentController::class, 'store'])
               ->name('payments.store');
      
          Route::get('payments/{client}/{payment}/edit', [AdminPaymentController::class, 'edit'])
               ->name('payments.edit');
      
          Route::put('payments/{client}/{payment}', [AdminPaymentController::class, 'update'])
               ->name('payments.update');
      
          Route::delete('payments/{client}/{payment}', [AdminPaymentController::class, 'destroy'])
               ->name('payments.destroy');
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
