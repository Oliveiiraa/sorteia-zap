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

Route::prefix('draw')->group(function () {
    Route::get('/', 'App\Http\Controllers\DrawController@list');
    Route::get('/services', 'App\Http\Controllers\DrawController@listServices');
    Route::post('/', 'App\Http\Controllers\DrawController@store');
    Route::post('/disable/{id}', 'App\Http\Controllers\DrawController@disable');
    Route::post('/sorteio', 'App\Http\Controllers\DrawController@draw');
});

Route::prefix('award')->group(function () {
    Route::get('/', 'App\Http\Controllers\AwardController@list');
    Route::get('/{id}', 'App\Http\Controllers\AwardController@listForDraw');
    Route::post('/', 'App\Http\Controllers\AwardController@store');
});

Route::post('/webhook', 'App\Http\Controllers\BotController@index');
Route::get('/winners', 'App\Http\Controllers\WinnerController@list');
Route::get('/draw/winners', 'App\Http\Controllers\WinnerController@listForDraw');
