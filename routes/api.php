<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavouritePlaceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherDataLogController;
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

Route::group(['middleware' => 'cors'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => ['auth:api', 'cors']], function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'index']);
    Route::put('/update-primary-place', [UserController::class, 'updateUserPrimaryPlace']);
    Route::delete('/user-delete', [UserController::class, 'destroy']);
    Route::apiResource('/favourite-places', FavouritePlaceController::class)
        ->only(['store', 'destroy']);
    Route::apiResource('/weather-data-logs', WeatherDataLogController::class)
        ->only(['index']);
});
