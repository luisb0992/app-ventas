<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

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

// -------------------------------------------------
// Ruta que responde al path de logos de las marcas
// -------------------------------------------------
Route::get('/pathlogos', function () {
    $path = env('APP_URL') . 'storage/' . config('brands.folder') . '/';
    return response()->json($path);
})->middleware(['auth', 'verified'])->name('path.logos');
