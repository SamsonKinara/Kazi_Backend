<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Token-based login/register/logout (no CSRF middleware)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Optional: protected route to get the logged-in user
Route::middleware('auth:sanctum')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});
