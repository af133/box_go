<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenarikanDanaController;

Route::get('/hello', function() {
    return response()->json(['message' => 'Hello, World!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
});

Route::get('/penarikan-dana', [PenarikanDanaController::class, 'index']);
Route::post('/penarikan-dana/approve/{id}', [PenarikanDanaController::class, 'approve']);
Route::post('/penarikan-dana/reject/{id}', [PenarikanDanaController::class, 'reject']);
