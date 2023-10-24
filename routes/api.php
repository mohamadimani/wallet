<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\TransferController;
use Illuminate\Http\Request;
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
    $router->get('payments/{payment:unique_id}', [PaymentController::class, 'show']);
    $router->get('payments', [PaymentController::class, 'index']);
    $router->patch('payments/{payment:unique_id}/reject', [PaymentController::class, 'reject']);
    $router->patch('payments/{payment:unique_id}/verify', [PaymentController::class, 'verify']);

    $router->post('currencies', [CurrencyController::class, 'store']);
    $router->get('currencies/{currency}', [CurrencyController::class, 'show']);
    $router->get('currencies', [CurrencyController::class, 'index']);
    $router->patch('currencies/{currency}/active', [CurrencyController::class, 'active']);
    $router->patch('currencies/{currency}/inactive', [CurrencyController::class, 'inActive']);

    $router->post('transfers', [TransferController::class, 'store']);
});
