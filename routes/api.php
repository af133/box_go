<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraBarang;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function() {
    return response()->json(['message' => 'Hello, World!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile/update', [Profile::class, 'update']);
    Route::post('/mitra/lokasi/dashboard', [MitraBarang::class, 'ShowBarangMitra']);
    Route::post('/show/komentar',[MitraBarang::class, 'ShowKomentar']);
    Route::post('/add/komentar',[MitraBarang::class, 'AddKomentar']);

});
