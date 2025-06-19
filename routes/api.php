<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
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
Route::get('/test', function () {
    return ['status' => 'ok'];
});
Route::get('/sales', [SaleController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/stocks', [StockController::class, 'index']);
Route::get('/incomes', [IncomeController::class, 'index']);
