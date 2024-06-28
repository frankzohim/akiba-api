<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\CreateUserController;
use App\Http\Controllers\Api\User\CurrentUserController;
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

Route::post('/user', [CreateUserController::class, 'createUser']);
Route::post('/login',[LoginController::class,'login']);

// endpoint simple user

Route::middleware('auth:api')->prefix('v1')->group(function(){

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/currentUser',[CurrentUserController::class,'currentUser']);
    Route::post('/logout',[LogoutController::class,'logout']);
});




