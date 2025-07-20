<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'getAll']);
        Route::post('/', [CustomerController::class, 'create']);
        Route::get('{id}', [CustomerController::class, 'getById']);
        Route::put('{id}', [CustomerController::class, 'update']);
        Route::delete('{id}', [CustomerController::class, 'delete']);
    });
});

