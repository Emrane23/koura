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
       $stade= Stade::all()->count();
        return response()->json(array ('Proprietaire' =>$propsum,'Utilisateur' =>$usersum, 'Stade'=>$stade));
    }
}
