<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\AuthController;
use App\Http\Controllers\Seller\IndexController;

Route::prefix('seller')->group(function () {
    Route::middleware('guest:seller')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('seller.login');
        Route::post('/login', [AuthController::class, 'store']);
    });

    Route::middleware([\App\Http\Middleware\SellerAuth::class])->group(function () {
        Route::get('/', [IndexController::class, 'dashboard'])->name('seller.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('seller.logout');
    });
});