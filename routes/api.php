<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraBarangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/hello', function() {
    return response()->json(['message' => 'Hello, World!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
<<<<<<< HEAD
    Route::post('/profile/update', [Profile::class, 'update']);
    Route::post('/mitra/lokasi/dashboard', [MitraBarang::class, 'ShowBarangMitra']);
    Route::post('/show/komentar',[MitraBarang::class, 'ShowKomentar']);
    Route::post('/add/komentar',[MitraBarang::class, 'AddKomentar']);

=======
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/mitra/lokasi/dashboard', [MitraBarangController::class, 'ShowBarangMitra']);
>>>>>>> e1c01165589cb6e9f6653e8d493b4d4461795c5f
});
