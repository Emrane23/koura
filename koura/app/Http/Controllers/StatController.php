<?php

namespace App\Http\Controllers;

use App\User;
use App\Stade;
use App\reservation ;

use Illuminate\Http\Request;

class StatController extends Controller
{
    public function stat()
    {
        
       $propsum =User::where("role","=","Prop")->count();
       $usersum =User::where("role","=","User")->count();
       $stadefoot= Stade::where('type','Football')->count();
       $stadetennis=Stade::where('type','Tennis')->count();
       $stadebasket=Stade::where('type','Basketball')->count();
       $reservation=reservation::count();
        return response()->json(array ('Proprietaire' =>$propsum,'Utilisateur' =>$usersum, 'Stade_foot'=>$stadefoot
        ,'Stade_tennis'=>$stadetennis,'Stade_basket'=>$stadebasket, 'Réservations_total'=>$reservation)
    
    );
    }

    public function stat_reservation_stade() 
    {
        //Top 3 stades qui porte le nombre le plus grand de Réservation
        
        $collection= reservation::pluck('stade_id');
        $counted = $collection->countBy();
        $desc=$counted->sortDesc();
        $result=$desc->take(3);
        return response()->json($result,200);

    }

    public function stat_reservation()
    {
        //top 10 utilisateur qui font des reservations

        $collection= reservation::pluck('client_id');
        $counted = $collection->countBy();
        $desc=$counted->sortDesc();
        $result=$desc->take(10);
        return response()->json($result,200);


    }
}
