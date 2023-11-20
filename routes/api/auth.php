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


Route::controller(\App\Http\Controllers\Api\Organization\AuthController::class)
    ->group(function () {
        Route::post('/register-supplier', 'registerSupplier')->name('register-supplier');
        Route::post('/login-supplier', 'loginSupplier')->name('.login-supplier');
        Route::post('/register-user', 'registerUser')->name('register-user');
        Route::post('/login-user', 'loginUser')->name('.login-user');
        Route::post('/logout-user', 'logoutUser')->name('.logout-user');
        Route::post('/login-admin', 'loginAdmin')->name('.login-admin');
    });
