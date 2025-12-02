<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraBarang;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MitraBarangController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function() {
    return response()->json(['message' => 'Hello, World!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/mitra/lokasi/dashboard', [MitraBarangController::class, 'ShowBarangMitra']);
    Route::post('/show/komentar',[MitraBarangController::class, 'ShowKomentar']);
    Route::post('/add/komentar',[MitraBarangController::class, 'AddKomentar']);

});
