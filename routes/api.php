<?php
// routes/api.php

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route to get all users
Route::get('/users', [AuthenticatedSessionController::class, 'index']);
Route::post('/users/{id}', [AuthenticatedSessionController::class, 'store']);
Route::put('/users/{id}', [AuthenticatedSessionController::class, 'update']);
Route::delete('/users/{id}', [AuthenticatedSessionController::class, 'destroy']);
//Route to get all users
