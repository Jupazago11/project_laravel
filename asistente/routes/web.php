<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminNegocioController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tarifas', function () {
    return view('tarifas');
})->name('tarifas');

// ──────────────────────────────────────────────────────────────────────────
// Quitar 'superadmin' y dejar sólo 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])
         ->name('superadmin.dashboard');
});

// ──────────────────────────────────────────────────────────────────────────
// Quitar 'adminnegocio' y dejar sólo 'auth'
Route::middleware('auth')->group(function () {
    Route::get('/adminnegocio/seleccion-empresa',
        [AdminNegocioController::class, 'seleccionEmpresa']
    )->name('adminnegocio.seleccion-empresa');

    Route::get('/adminnegocio/crear-empresa',
        [AdminNegocioController::class, 'crearEmpresaForm']
    )->name('adminnegocio.crear-empresa');

    Route::post('/adminnegocio/crear-empresa',
        [AdminNegocioController::class, 'storeEmpresa']
    )->name('adminnegocio.store-empresa');

    Route::get('/adminnegocio/dashboard/{empresa}',
        [AdminNegocioController::class, 'dashboard']
    )->name('adminnegocio.dashboard');
});

// Empleados (adminnegocio)
Route::middleware('auth')->group(function () {
    Route::get('/empleados/crear', [EmpleadoController::class, 'create'])
         ->name('empleados.create');

    Route::post('/empleados', [EmpleadoController::class, 'store'])
         ->name('empleados.store');
});

// Empleado dashboard
Route::middleware('auth')->group(function () {
    Route::get('/empleado/dashboard', [EmpleadoController::class, 'dashboard'])
         ->name('empleado.dashboard');
});

require __DIR__.'/auth.php';
