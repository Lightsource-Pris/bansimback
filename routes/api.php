<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::prefix('')->as('api.')->group(function () {
    Route::get('/login', [UserController::class, 'index']);
    Route::post('login', [UserController::class, 'Login']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'Logout']);
    Route::get('transactions', [UserController::class, 'Transactions']);
    Route::post('transfer', [UserController::class, 'TransferMoney']);
    
});