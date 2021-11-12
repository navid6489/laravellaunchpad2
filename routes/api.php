<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\UserController;




use App\Providers\RouteServiceProvider;



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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
/*
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@details');
});*/

Route::post('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'register']);
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details',[UserController::class,'details']);
    Route::post('delete/{id}',[UserController::class,'delete']);
    Route::post('update/{id}',[UserController::class,'update']);
    });
