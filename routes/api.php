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
    Route::get('cookie', [HomeController::class, 'Cookie']);
    Route::prefix('home')->group(function(){
        Route::post('index', [HomeController::class, 'index']);
        Route::get('favorit', [HomeController::class, 'favorit']);
        Route::get('getTypeMenu', [HomeController::class, 'getTypeMenu']);
        Route::get('keranjang/{id}', [HomeController::class, 'keranjang']);

    });

    Route::prefix('keranjang')->group(function(){
        Route::get('index', [HomeController::class, 'getKeranjang']);
        Route::post('hapus', [HomeController::class, 'hapus']);
        Route::get('getMeja', [HomeController::class, 'getMeja']);
        Route::post('transaksi', [TransaksiController::class, 'transaksi']);
    });

    Route::prefix('transaksi')->group(function(){
        Route::post('index', [TransaksiController::class, 'index']);
        Route::post('done', [TransaksiController::class, 'done']);
        Route::post('kasirIndex', [TransaksiController::class, 'kasirIndex']);
        Route::post('kasirUpdate', [TransaksiController::class, 'kasirUpdate']);
    });
    
});
