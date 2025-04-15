<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
    return view('info');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para el Dashboard de Administradores (tipo Administrador, type_user_id === 2)
// Eliminamos el middleware 'checkRole:administrador' si ya no lo necesitamos
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/administrador', function () {
        return view('administrador.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
