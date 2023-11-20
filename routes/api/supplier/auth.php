<?php

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


Route::controller(\App\Http\Controllers\Api\Organization\AuthSupplierController::class)
    ->group(function () {
        Route::post('/register', 'register')->name('.register');
        Route::post('/login', 'login')->name('.login');
        Route::post('/logout', 'logout')->name('.logout');
    });
