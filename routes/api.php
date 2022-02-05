<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
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

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/notify', [NotificationController::class, 'SendNotification']);

// protected routes
Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
     Route::resource('users', App\Http\Controllers\UserController::class);
     Route::resource('devices', App\Http\Controllers\DeviceController::class);

});
