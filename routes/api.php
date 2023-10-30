<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\TransferController;
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

Route::group(['prefix' => 'v1'], function () use ($router) {
    $router->post('payments', [PaymentController::class, 'store']);
    $router->get('payments/{payment}', [PaymentController::class, 'show']);
    $router->get('payments', [PaymentController::class, 'index']);
    $router->patch('payments/{payment}/reject', [PaymentController::class, 'reject']);
    $router->patch('payments/{payment}/verify', [PaymentController::class, 'verify']);
    $router->delete('payments/{payment}/destroy', [PaymentController::class, 'destroy']);

    $router->post('currencies', [CurrencyController::class, 'store']);
    $router->get('currencies/{currency}', [CurrencyController::class, 'show']);
    $router->get('currencies', [CurrencyController::class, 'index']);
    $router->patch('currencies/{currency}/active', [CurrencyController::class, 'active']);
    $router->patch('currencies/{currency}/inactive', [CurrencyController::class, 'inActive']);

    $router->post('transfers', [TransferController::class, 'store']);
});
