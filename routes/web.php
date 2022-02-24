<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ----------------------
// rutas de autenticación
// ----------------------
require __DIR__ . '/auth.php';

// ----------------------
// rutas de marcas
// ----------------------
require __DIR__ . '/brand.php';

// ----------------------
// rutas de ventas
// ----------------------
require __DIR__ . '/sale.php';

// ----------------------
// ruta de inicio
// ----------------------
Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status'),
        'appName'  => config('app.name'),
    ]);
})->middleware('guest')->name('main');

// ----------------------
// ruta para el dashboard
// ----------------------
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
