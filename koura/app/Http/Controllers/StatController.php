<?php

namespace App\Http\Controllers;

use App\User;
use App\Stade;

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
        return response()->json(array ('Proprietaire' =>$propsum,'Utilisateur' =>$usersum, 'Stade foot'=>$stadefoot
        ,'Stade tennis'=>$stadetennis,'Stade basket'=>$stadebasket)
    
    );
    }
}
