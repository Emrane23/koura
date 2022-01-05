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
Route::post('stat',[\App\Http\Controllers\StatController::class,'stat']);
Route::post('users',[\App\Http\Controllers\CrudusprController::class,'index']);
Route::get('user/{id}',[\App\Http\Controllers\CrudusprController::class,'show']);
Route::post('adduser',[\App\Http\Controllers\CrudusprController::class,'store']);
Route::delete('user/{id}',[\App\Http\Controllers\CrudusprController::class,'destroy']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::group(['middleware' => ['api']], function() {
    
    
});