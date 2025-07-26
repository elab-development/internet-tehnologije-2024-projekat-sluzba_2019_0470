<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);

// Grupisana ruta za autentifikovane korisnike
Route::middleware('auth:sanctum')->group(function () {
    
   
    Route::post('/logout', [UserAuthController::class, 'logout']);

    
});