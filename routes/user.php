<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ---------------------------------------
// ruta para mostrar el perfil de usuario
// ---------------------------------------
Route::get('/profile', [UserController::class, 'profile'])
    ->middleware(['auth', 'verified'])
    ->name('profile');

// ---------------------------------------
// ruta para actualizar el perfil de usuario
// ---------------------------------------
Route::put('/profile/update/{user}', [UserController::class, 'updateProfile'])
    ->middleware(['auth', 'verified'])
    ->name('profile.updateData');

// ---------------------------------------
// ruta para actualizar el password de usuario
// ---------------------------------------
Route::put('/profile/updatepass/{user}', [UserController::class, 'updateProfilePassword'])
    ->middleware(['auth', 'verified'])
    ->name('profile.updatePass');