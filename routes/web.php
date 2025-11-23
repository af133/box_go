<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/confirm-payment/{transactionId}', [AdminController::class, 'confirmPayment'])->name('payment.confirm');
    Route::post('/confirm-withdrawal/{partnerId}', [AdminController::class, 'confirmWithdrawal'])->name('withdrawal.confirm');
    Route::get('/view-users', [AdminController::class, 'viewUsers'])->name('users.view');
    Route::put('/edit-user/{role}/{id}', [AdminController::class, 'editUser'])->name('user.edit');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Logout route
Route::post('/logout', function() {
    // Add logout logic here
    return redirect('/login');
})->name('logout');
