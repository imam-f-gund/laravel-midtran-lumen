<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test/paymentTransfer', [App\Http\Controllers\PaymentsController::class, 'bankTransferCharge']);
Route::post('/token/payment', [App\Http\Controllers\PaymentsController::class, 'getTokenCC']);
Route::post('/test/paymentCC', [App\Http\Controllers\PaymentsController::class, 'chargeCreditCard']);
