<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;
Route::get('/hello', function() {
    return response()->json(['message' => 'Hello, World!']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/profile/update',[Profile::class,'update']);