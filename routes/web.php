<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    Route::resource('trades', TradeController::class)->except(['create', 'edit']);
    Route::resource('promotions', PromotionController::class)->except(['create', 'edit']);
    Route::resource('refunds', RefundController::class)->except(['create', 'edit']);

    Route::get('logs/{type}', [LogController::class, 'index'])->name('logs.index');
    Route::resource('logs', LogController::class)->only(['destroy']);
});



