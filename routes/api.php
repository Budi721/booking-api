<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Owner\CarController;
use App\Http\Controllers\User\BookingController;
use Illuminate\Http\Client\Request;
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
Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/register', [RegisterController::class, 'register']);
Route::middleware('auth:sanctum')->group(function() {
    // No owner/user grouping, for now, will do it later with more routes
    Route::apiResource('owner/cars', CarController::class);
    Route::post('user/rent', [BookingController::class, 'rent']);
    Route::post('user/return', [BookingController::class, 'return_car']);
});
