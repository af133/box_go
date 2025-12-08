<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraBarang;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LokasiMitraController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function() {
    return response()->json(['message' => 'Hello, World!']);
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/mitra/lokasi/dashboard', [LokasiMitraController::class, 'ShowLokasiMitra']);
    Route::post('/show/komentar',[LokasiMitraController::class, 'ShowKomentar']);
    Route::post('/add/komentar',[LokasiMitraController::class, 'AddKomentar']);

    Route::post('show/mitra/lokasi',[LokasiMitraController::class, 'ShowLokasiMitraByIdMitra']);
    Route::post('jenis/barang',[LokasiMitraController::class, 'JenisBarang']);
    Route::post('update/jenis/barang',[LokasiMitraController::class, 'UpdateJenisBarang']);

    Route::post('add/mitra/lokasi',[LokasiMitraController::class, 'AddLokasiMitra']);
    Route::post('add/mitra/polygon',[LokasiMitraController::class, 'AddPolygon']);
    Route::post('add/jenis/barang',[LokasiMitraController::class, 'AddJenisBarang']);
    Route::get('lokasi/{idLokasi}',[LokasiMitraController::class, 'LokasiDetail']);
    Route::post('update/or/add/titik/polygon',[LokasiMitraController::class, 'UpdateOrAddLokasiAndPolygon']);
    Route::post('update/lokasi/mitra',[LokasiMitraController::class, 'UpdateLokasi']);

    Route::post('/order/store', [OrderController::class, 'AddOrder']);
    Route::post('/dashboard', [OrderController::class, 'ShowOrder']);
    Route::post('/dashboard/mitra', [OrderController::class, 'ShowAllOrdersMitra']);
    Route::post('/jenisBarang', [LokasiMitraController::class, 'JenisBarang']);


});
