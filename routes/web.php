<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// ----------------------
// rutas de autenticación
// ----------------------
require __DIR__ . '/auth.php';

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
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ----------------------
// Rutas de marcas
// ----------------------
Route::resource('/brands', BrandController::class)->middleware(['auth', 'verified']);
