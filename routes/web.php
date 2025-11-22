<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('login');
});
Route::redirect('/', '/login');
Route::get('/login', function () {
    return view('login');
})->name('login');
// Admin routes
Route::prefix('admin')->group(function () {
    Route::post('/confirm-payment/{transactionId}', [AdminController::class, 'confirmPayment']);
    Route::post('/confirm-withdrawal/{partnerId}', [AdminController::class, 'confirmWithdrawal']);
    Route::get('/view-users', [AdminController::class, 'viewUsers']);
    Route::put('/edit-user/{role}/{id}', [AdminController::class, 'editUser']);
});

