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

//Crud tournoi 

Route::post('tournois',[\App\Http\Controllers\TournoisController::class,'index']);
Route::get('tournoi/{id}',[\App\Http\Controllers\TournoisController::class,'show']);
Route::post('addtournoi',[\App\Http\Controllers\TournoisController::class,'store']);
Route::delete('deltournois/{id}',[\App\Http\Controllers\TournoisController::class,'destroy']);

//Crud participation

Route::post('participations',[\App\Http\Controllers\ParticipationController::class,'index']);
Route::get('participation/{id}',[\App\Http\Controllers\ParticipationController::class,'show']);
Route::post('addparticipation',[\App\Http\Controllers\ParticipationController::class,'store']);
Route::delete('delparticipation/{id}',[\App\Http\Controllers\ParticipationController::class,'destroy']);


// ***** Crud proprietaire 

//stat
Route::post('stat',[\App\Http\Controllers\StatController::class,'stat']);
Route::get('statusersreserv',[\App\Http\Controllers\StatController::class,'stat_reservation']);
Route::get('statreservstade',[\App\Http\Controllers\StatController::class,'stat_reservation_stade']);
Route::get('statpropstade/{propid}',[\App\Http\Controllers\StatController::class,'stat_reservation_stade_d_prop']);
Route::get('nmbrstadesprop/{propid}',[\App\Http\Controllers\StatController::class,'nmbr_stades_prop']);
Route::get('listestadesprop/{propid}',[\App\Http\Controllers\StadeController::class,'liste_stades_prop']);

Route::post('props',[\App\Http\Controllers\CrudusprController::class,'index']);
Route::get('prop/{id}',[\App\Http\Controllers\CrudusprController::class,'show']);
Route::post('addpropsusers',[\App\Http\Controllers\CrudusprController::class,'store']);
Route::delete('prop/{id}',[\App\Http\Controllers\CrudusprController::class,'destroy']);
Route::delete('reservation/{id}',[\App\Http\Controllers\ReservationController::class,'destroy']);
Route::post('validreservation/{id}/{email}',[\App\Http\Controllers\ReservationController::class,'valide_reservation']);
Route::post('invalidreservation/{id}/{email}',[\App\Http\Controllers\ReservationController::class,'invalide_reservation']);
Route::get('listreservationprop/{propid}/{date}',[\App\Http\Controllers\ReservationController::class,'list_reserv_dprop']);
Route::get('listreservationtotalprop/{propid}',[\App\Http\Controllers\ReservationController::class,'list_reservtotal_dprop']);
Route::get('listreservprop/{propid}',[\App\Http\Controllers\ReservationController::class,'listreservprop']);
Route::get('nmbrreservationtotalprop/{propid}',[\App\Http\Controllers\ReservationController::class,'nombre_reservtotal_dprop']);

// Crud user
Route::post('users',[\App\Http\Controllers\UserController::class,'index']);
Route::get('user/{id}',[\App\Http\Controllers\UserController::class,'show']);
Route::delete('user/{id}',[\App\Http\Controllers\UserController::class,'destroy']);
Route::post('addreservation',[\App\Http\Controllers\ReservationController::class,'store']);
Route::get('reservations/{id}',[\App\Http\Controllers\ReservationController::class,'index']);
Route::get('reservation/{id}',[\App\Http\Controllers\ReservationController::class,'show']);

Route::get('heuredisponible/{stadeid}/{date}/{period}',[\App\Http\Controllers\ReservationController::class,'heures_disponible']);

//***** Reservation list */
Route::post('reservationpardate',[\App\Http\Controllers\ReservationController::class,'Listpardate']);
Route::get('reser/{date}',[\App\Http\Controllers\ReservationController::class,'reservdate']);

Route::get('nbrreser/{date}',[\App\Http\Controllers\ReservationController::class,'nbr_reservation_par_date']);
Route::get('nbrreserstade/{date}/{stadeid}',[\App\Http\Controllers\ReservationController::class,'nbr_reservation_par_stade']);

// admin
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);

//Crud stade
Route::post('stades/{type}',[\App\Http\Controllers\StadeController::class,'index']);
Route::get('stade/{id}',[\App\Http\Controllers\StadeController::class,'show']);
Route::post('addstade',[\App\Http\Controllers\StadeController::class,'store']);
Route::post('updatestade/{id}',[\App\Http\Controllers\StadeController::class,'update']);
Route::delete('stade/{id}',[\App\Http\Controllers\StadeController::class,'destroy']);

//Crud charge
Route::post('charges',[\App\Http\Controllers\ChargeController::class,'index']);
Route::get('charge/{id}',[\App\Http\Controllers\ChargeController::class,'show']);
Route::post('updatecharge/{id}',[\App\Http\Controllers\ChargeController::class,'update']);
Route::delete('charge/{id}',[\App\Http\Controllers\ChargeController::class,'destroy']);
Route::post('addcharge',[\App\Http\Controllers\ChargeController::class,'store']);

// equipe 
Route::post('equipes',[\App\Http\Controllers\EquipeController::class,'index']);
Route::get('equipe/{id}',[\App\Http\Controllers\EquipeController::class,'show']);
Route::post('addequipe',[\App\Http\Controllers\EquipeController::class,'store']);
Route::post('updateequipe/{id}/{userid}',[\App\Http\Controllers\EquipeController::class,'update']);
Route::delete('equipe/{id}/{userid}',[\App\Http\Controllers\EquipeController::class,'destroy']);



Route::post('changepassword/{userid}',[\App\Http\Controllers\ProfileController::class, 'change_password']);

Route::group(['middleware' => ['api']], function() {
    
    
});