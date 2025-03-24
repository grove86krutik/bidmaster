<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\AuctionController;
use App\Http\Controllers\Admin\SellerController;

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'store']);
    });

    Route::middleware(['admin', 'preventBackHistory'])->group(function () {
        Route::get('/', [IndexController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::group(['as' => 'admin.'], function () {
            Route::resource('auction', AuctionController::class);
            Route::resource('seller', SellerController::class);
        });
    });
});
