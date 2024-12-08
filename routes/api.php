<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\RulesController;

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientsController::class, 'index']);
    Route::post('/', [ClientsController::class, 'store']);
    Route::get('/{id}', [ClientsController::class, 'show']);
    Route::put('/{id}', [ClientsController::class, 'update']);
    Route::delete('/{id}', [ClientsController::class, 'destroy']);
    Route::get('/{id}/qr-code', [ClientsController::class, 'generateQrCode']);
});

Route::prefix('stores')->group(function () {
    Route::get('/', [StoresController::class, 'index']);
    Route::post('/', [StoresController::class, 'store']);
    Route::get('/{id}', [StoresController::class, 'show']);
    Route::put('/{id}', [StoresController::class, 'update']);
    Route::delete('/{id}', [StoresController::class, 'destroy']);
});

Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionsController::class, 'index']);
    Route::post('/', [TransactionsController::class, 'store']);
    Route::get('/{id}', [TransactionsController::class, 'show']);
    Route::put('/{id}', [TransactionsController::class, 'update']);
    Route::delete('/{id}', [TransactionsController::class, 'destroy']);
    Route::post('/grant-points', [TransactionsController::class, 'grantPoints']);
});

Route::prefix('points')->group(function () {
    Route::get('/', [PointsController::class, 'index']);
    Route::post('/', [PointsController::class, 'store']);
    Route::get('/{id}', [PointsController::class, 'show']);
    Route::put('/{id}', [PointsController::class, 'update']);
    Route::delete('/{id}', [PointsController::class, 'destroy']);
    Route::get('total', [PointsController::class, 'getTotalPoints']);
});

Route::prefix('store-rules')->group(function () {
    Route::get('/', [RulesController::class, 'index']);
    Route::post('/', [RulesController::class, 'store']);
    Route::get('/{id}', [RulesController::class, 'show']);
    Route::put('/{id}', [RulesController::class, 'update']);
    Route::delete('/{id}', [RulesController::class, 'destroy']);
    Route::get('store/{storeId}', [RulesController::class, 'getRulesByStore']);
});

