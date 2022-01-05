<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function stat()
    {
        
       $propsum =User::where("role","=","Prop")->count();
       $usersum =User::where("role","=","User")->count();
        return response()->json(array ('Proprietaire' =>$propsum,'Utilisateur' =>$usersum));
    }
}
