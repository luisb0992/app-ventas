<?php

use App\Http\Controllers\BrandController;
use App\Models\Brand;
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
// Ruta que responde al path de logos
// ----------------------
Route::get('/pathlogos', function () {
    $path = env('APP_URL') . 'storage/' . config('brands.folder') . '/';
    return response()->json($path);
})->middleware(['auth', 'verified'])->name('path.logos');

// ----------------------
// Rutas de marcas
// ----------------------
Route::resource('/brands', BrandController::class)->middleware(['auth', 'verified']);
Route::post('/brands/update/{brand}', [BrandController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('brands.updateAll');

// ----------------------
// Ruta para obtener logo
// ----------------------
Route::get('/get/logo/{brand}', [BrandController::class, 'getLogo'])
    ->middleware(['auth', 'verified'])
    ->name('get.logo');
