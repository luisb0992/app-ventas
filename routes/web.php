<?php

use App\Http\Controllers\SaleController;
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
// Rutas de ventas
// ----------------------
Route::resource('/sales', SaleController::class)->middleware(['auth', 'verified']);

// ---------------------------------------------------
// Ruta para la creación de una venta desde una marca
// ---------------------------------------------------
Route::get('/sales/brand/{slug}', [SaleController::class, 'createWithBrand'])->name('sales.createWithBrand');

// ---------------------------------------------------
// Ruta para guardar una venta desde una marca
// ---------------------------------------------------
Route::post('/sales/brand/{brand}', [SaleController::class, 'saveWithBrand'])->name('sales.saveWithBrand');

// ---------------------------------------------------
// Ruta para marcar una venta como verificada
// ---------------------------------------------------
Route::put('/sales/verify/{sale}/{brand}', [SaleController::class, 'saleVerify'])->name('sales.verify');

// ---------------------------------------------------
// Ruta para obtener las ventas de una marca
// ---------------------------------------------------
// Route::get('/sales/getAll/{brand}', [SaleController::class, 'getAll'])->name('sales.getAll');