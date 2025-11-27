<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenarikanDanaController;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

// Admin routes - TANPA middleware dulu untuk testing
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/list-mitra', function () {
        return view('list-mitra');
    })->name('mitra.index');

    Route::get('/list-pelanggan', function () {
        return view('list-pelanggan');
    })->name('pelanggan.index');

    Route::get('/mitra', [UserController::class, 'viewUsers'])->name('mitra');
    Route::get('/pelanggan', [UserController::class, 'viewUsers'])->name('pelanggan');
    Route::put('/edit-user/{role}/{id}', [UserController::class, 'editUser'])->name('user.edit');

    // Order routes - FIXED dengan penanganan yang lebih baik
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/approve', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{id}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');

    // Penarikan Dana routes
    Route::get('/penarikan-dana', function () {
        return view('penarikan-dana');
    })->name('penarikan.index');

    Route::get('/penarikan-dana/data', [PenarikanDanaController::class, 'index'])->name('penarikan.index');
    Route::post('/penarikan-dana/approve/{id}', [PenarikanDanaController::class, 'approve'])->name('penarikan.approve');
    Route::post('/penarikan-dana/reject/{id}', [PenarikanDanaController::class, 'reject'])->name('penarikan.reject');
});

// Logout route
Route::post('/logout', function() {
    // Add logout logic here
    return redirect('/login');
})->name('logout');
