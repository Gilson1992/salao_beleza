<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPriceController;
use App\Http\Controllers\ItemPriceHistoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    Route::middleware('role:admin,manager')->group(function () {
        Route::apiResource('services', ServiceController::class);
        Route::apiResource('items', ItemController::class);
        Route::apiResource('item-prices', ItemPriceController::class);
    });

    Route::get('items/{item}/price-histories', [ItemPriceHistoryController::class, 'index'])
        ->name('items.price-histories.index');

    Route::middleware('role:admin,manager,professional,receptionist')->group(function () {
        Route::apiResource('appointments', AppointmentController::class);
    });
});
