<?php

use App\Http\Controllers\api\Auth\LoginController;
use App\Http\Controllers\api\Auth\LogoutController;
use App\Http\Controllers\api\Auth\refreshtokenController;
use App\Http\Controllers\api\Auth\SignupController;
use App\Http\Controllers\api\Auth\VerifyController;
use App\Http\Controllers\api\AuthController;
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

Route::post('signup',[AuthController::class,'signup']);
Route::post('verify-email', [AuthController::class,'verify']);
Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->get('logout',[AuthController::class,'logout']);
Route::middleware('auth:sanctum')->get('refresh',[AuthController::class,'refresh']);
