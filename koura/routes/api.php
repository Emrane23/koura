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

Route::post('login', [\App\Http\Controllers\AuthController::class, 'authenticate']);

// ***** Crud proprietaire 
Route::post('stat',[\App\Http\Controllers\StatController::class,'stat']);
Route::post('props',[\App\Http\Controllers\CrudusprController::class,'index']);
Route::get('prop/{id}',[\App\Http\Controllers\CrudusprController::class,'show']);
Route::post('addpropsusers',[\App\Http\Controllers\CrudusprController::class,'store']);
Route::delete('prop/{id}',[\App\Http\Controllers\CrudusprController::class,'destroy']);
Route::delete('reservation/{id}',[\App\Http\Controllers\ReservationController::class,'destroy']);


// Crud user
Route::post('users',[\App\Http\Controllers\UserController::class,'index']);
Route::get('user/{id}',[\App\Http\Controllers\UserController::class,'show']);
Route::delete('user/{id}',[\App\Http\Controllers\UserController::class,'destroy']);
Route::post('reservation',[\App\Http\Controllers\ReservationController::class,'store']);
Route::get('reservations/{id}',[\App\Http\Controllers\ReservationController::class,'index']);
Route::get('reservation/{id}',[\App\Http\Controllers\ReservationController::class,'show']);
Route::get('heuredispo/{date}/{stadeid}',[\App\Http\Controllers\ReservationController::class,'heure_dispo']);
Route::get('heuredispo/{interval}/{start_time}/{end_time}',[\App\Http\Controllers\ReservationController::class,'getTimeSlot']);


// admin
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);

//Crud stade
Route::post('stades/{type}',[\App\Http\Controllers\StadeController::class,'index']);
Route::get('stade/{id}',[\App\Http\Controllers\StadeController::class,'show']);
Route::post('addstade',[\App\Http\Controllers\StadeController::class,'store']);
Route::delete('stade/{id}',[\App\Http\Controllers\StadeController::class,'destroy']);

//Crud charge
Route::post('charges',[\App\Http\Controllers\ChargeController::class,'index']);
Route::get('charge/{id}',[\App\Http\Controllers\ChargeController::class,'show']);
Route::delete('charge/{id}',[\App\Http\Controllers\ChargeController::class,'destroy']);
Route::post('addcharge',[\App\Http\Controllers\ChargeController::class,'store']);

Route::post('/changepassword',[\App\Http\Controllers\ProfileController::class, 'change_password']);

Route::group(['middleware' => ['api']], function() {
    
    
});