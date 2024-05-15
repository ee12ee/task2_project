<?php

use App\Http\Controllers\api\Auth\LoginController;
use App\Http\Controllers\api\Auth\LogoutController;
use App\Http\Controllers\api\Auth\refreshtokenController;
use App\Http\Controllers\api\Auth\SignupController;
use App\Http\Controllers\api\Auth\VerifyController;
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
Route::post('auth/signup',[SignupController::class,'signup']);
Route::post('/verify-email', [VerifyController::class,'verify']);
Route::post('auth/login',[LoginController::class,'login']);
Route::middleware('auth:sanctum')->get('auth/logout',[LogoutController::class,'logout']);
Route::middleware('auth:sanctum')->get('auth/refresh',[refreshtokenController::class,'refresh']);
