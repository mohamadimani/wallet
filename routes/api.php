<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\TransferController;
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::middleware('auth:api')->group(function () {
        
        Route::post('payments', [PaymentController::class, 'store']);
        Route::get('payments/{payment}', [PaymentController::class, 'show']);
        Route::get('payments', [PaymentController::class, 'index']);
        Route::patch('payments/{payment}/reject', [PaymentController::class, 'reject']);
        Route::patch('payments/{payment}/verify', [PaymentController::class, 'verify']);
        Route::delete('payments/{payment}/destroy', [PaymentController::class, 'destroy']);

        Route::post('currencies', [CurrencyController::class, 'store']);
        Route::get('currencies/{currency}', [CurrencyController::class, 'show']);
        Route::get('currencies', [CurrencyController::class, 'index']);
        Route::patch('currencies/{currency}/active', [CurrencyController::class, 'active']);
        Route::patch('currencies/{currency}/inactive', [CurrencyController::class, 'inActive']);

        Route::post('transfers', [TransferController::class, 'store']);
    });
});
