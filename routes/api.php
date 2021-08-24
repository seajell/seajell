<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\StatisticController;

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

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('/user/{username}', [UserController::class, 'getUserByUsername']);
    Route::get('/event/{id}', [EventController::class, 'getEventByID']);
    Route::get('/statistic/today', [StatisticController::class, 'getStatisticToday']);
    Route::get('/statistic/month', [StatisticController::class, 'getStatisticMonth']);
    Route::get('/statistic/year', [StatisticController::class, 'getStatisticYear']);
    Route::get('/statistic/all', [StatisticController::class, 'getStatisticAll']);
});