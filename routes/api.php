<?php

use App\Http\Controllers\Api\CommitionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MarketingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('marketing', MarketingController::class);
Route::apiResource('transaction', TransactionController::class);
Route::get('commition', CommitionController::class);
Route::apiResource('payment/{transactionId}', PaymentController::class);
