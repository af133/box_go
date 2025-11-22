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
Route::post('/profile/update',[ProfileController::class,'update']);
Route::get('/mitra/lokasi',[MitraBarangController::class,'ShowBarangMitra']);
