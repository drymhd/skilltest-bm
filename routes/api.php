<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiController;
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

Route::prefix('v1')->group(function () {
    Route::get('test', [TransaksiController::class, 'index']);
    Route::prefix('home')->group(function(){
        Route::post('index', [HomeController::class, 'index']);
        Route::get('getTypeMenu', [HomeController::class, 'getTypeMenu']);
    });
    
});
