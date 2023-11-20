<?php
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


Route::prefix('category')
    ->name('.category')
    ->controller(\App\Http\Controllers\CategoryController::class)
    ->group(function (){
        Route::get('/','index')->name('.index');
        Route::get('/{id}/show','show')->name('.show');
        Route::post('/','store')->name('.store');
        Route::put('/{id}/update','update')->name('update');
        Route::delete('/{id}/delete','destroy')->name('.destroy');
    });
Route::controller(\App\Http\Controllers\ProductController::class)
    ->group(function (){
        Route::get('/','index')->name('.index');
        Route::get('/my-list','myList')->name('.myList');
        Route::get('/{id}/show','show')->name('.show');
        Route::put('/{id}/update','update')->name('.update');
        Route::post('/','store')->name('.store');
        Route::delete('/{id}/delete','destroy')->name('.destroy');
        Route::delete('/{id}/img-delete','destroyImage')->name('.destroyImage');
    });


