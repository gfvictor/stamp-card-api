<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\RulesController;

Route::group(['prefix' => 'clients'], function () {
    Route::apiResource('/', ClientsController::class);
});

Route::group(['prefix' => 'stores'], function () {
    Route::apiResource('/', StoresController::class);
});

Route::group(['prefix' => 'transactions'], function () {
    Route::apiResource('/', TransactionsController::class);
});

Route::group(['prefix' => 'points'], function () {
    Route::apiResource('/', PointsController::class);
    Route::get('total', [PointsController::class, 'getTotalPoints']);
});

Route::group(['prefix' => 'store-rules'], function () {
    Route::apiResource('/', RulesController::class);
    Route::get('store/{storeId}', [RulesController::class, 'getRulesByStore']);
});
