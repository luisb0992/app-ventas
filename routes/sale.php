<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

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
Route::put('/sales/verify/{sale}/{brand}', [SaleController::class, 'saleVerify'])
  ->name('sales.verify')
  ->middleware(['auth', 'verified']);
