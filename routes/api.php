<?php

use App\Http\Controllers\PaymentController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () use ($router) {
    $router->post('payments', [PaymentController::class, 'store']);
    $router->get('payments/{payment:unique_id}', [PaymentController::class, 'show']);
    $router->get('payments', [PaymentController::class, 'index']);
    $router->patch('payments/{payment:unique_id}/reject', [PaymentController::class, 'reject']);
});
