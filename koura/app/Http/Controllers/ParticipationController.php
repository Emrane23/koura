<?php

namespace App\Http\Controllers;
use App\Participation;
use App\Tournoi;
use App\Equipe;
use App\User;
use App\Equipe_tournoi;
use App\Equipe_user;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participation=Participation::all();
        return response()->json($participation,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $userid)
    {
        $user=User::find($userid);
        if (empty($user)) {
            return response()->json(["error" => "user not found! "], 400);
        }
        $idtournoi=$request->tournoi_id ;
        $places=Tournoi::where('id',$idtournoi)->value('places');
        if ($places==0) {

            return response()->json(["error" => "Complet! il ne reste aucune place disponible ! "], 400);
        }
        $participation = Participation::where('user_id',$userid)->where('tournoi_id',$idtournoi)->count();
        if ($participation>0) {

            return response()->json(["error" => "vous etes déjà participé à ce tournoi ! "], 400);
        }
        $equipeid=Equipe_user::where('user_id',$userid)->value('equipe_id');
        $participationequipe=Equipe_tournoi::where('tournoi_id',$idtournoi)->where('equipe_id',$equipeid)->count();
        if ($participationequipe>0) {

            return response()->json(["error" => "votre équipe déjà participé à ce tournoi ! "], 400);
        }
       $dateparticip= strtotime(date('Y-m-d H:i:s')) ;
       $datetournoi=Tournoi::find($idtournoi)->date_fin;
       $datetournoi=strtotime($datetournoi);
       if ($dateparticip>$datetournoi) {

        return response()->json(["error" => "la date final pour la participation est dépassé ! "], 400);
    }
        
        $input = $request->all();
        $input['user_id']=$userid;
        $participation = Participation::create($input);
        Tournoi::where('id',$idtournoi)->decrement('places',1);
        return response()->json($participation,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $participation = Participation::find($id);

        if (empty($participation)) {

            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($participation, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $participation = Participation::find($id);
        $idtournoi=$participation->tournoi_id;

        if (empty($participation)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $participation->delete();
        Tournoi::where('id',$idtournoi)->increment('places',1);

    }


    // public function participation_par_equipe(Request $request ,$equipeid,$userid)
    // {
    //     $input = $request->all();
    //     $equipe=Equipe::find($equipeid);
    //     if (empty($equipe)) {

    //         return response()->json(["error" => "equipe not found! "], 400);
    //     }
    //     if ($equipe->createur_id !=$userid) {

    //         return response()->json(["error" => " cette action ne peut pas fait que par le createur de l'equipe !"], 400);
    //     }
    //     $idtournoi=$request->tournoi_id ;
    //     $places=Tournoi::where('id',$idtournoi)->value('places');
    //     $nmbrjoueurs=count($input['joueurs']);
    //     if ($places>$places) {

    //         return response()->json(["error" => "Complet! il ne reste des places disponible pour votre equipe ! "], 400);
    //     }
    //     $input = $request->all();
    //     foreach ($input['joueurs'] as $key => $value) {
    //         $userid=$value;
    //         $participation = Participation::where('user_id',$userid)->where('tournoi_id',$idtournoi)->count();
    //     if ($participation>0) {
    //         $id=$key+1;
    //         return response()->json(["error" => "le joueur $id est déja participé à ce tournoi ! "], 400);
    //     }
    //     }
         
    //    $dateparticip= strtotime(date('Y-m-d H:i:s')) ;
    //    $datetournoi=Tournoi::find($idtournoi)->date_fin;
    //    $datetournoi=strtotime($datetournoi);
    //    if ($dateparticip>$datetournoi) {

    //     return response()->json(["error" => "la date final pour la participation est dépassé ! "], 400);
    // }

        
        
    //     $tournoi=Tournoi::find($idtournoi);
    //     $participation = $tournoi->users()->attach($input['joueurs']);

    //     Tournoi::where('id',$idtournoi)->decrement('places',$nmbrjoueurs);
    //     return  response()->json(['message'=>'Participation avec succées !'],200);
    // }


    // public function dparticipation_par_equipe(Request $request, $equipeid,$userid)
    // {
    //       $equipe= Equipe::find($equipeid);
    //       if ($equipe->createur_id !=$userid)
    //        {
    //          return response()->json(["error" => " cette action ne peut pas fait que par le createur de l'equipe !"], 400);
    //         }
    //        $joueurs=$equipe->joueurs;
    //        $ids=[];
    //        $idtournoi=$request->tournoi_id ;
    //        foreach ($joueurs as $key => $joueur)
    //        {
    //            array_push($ids,$joueur->id);
               
    //        }
    //       $increment= Participation::whereIn('user_id',$ids)->where('tournoi_id',$idtournoi)->count();

    //        Participation::whereIn('user_id',$ids)->where('tournoi_id',$idtournoi)->delete();
        
    //       Tournoi::where('id',$idtournoi)->increment('places',$increment);

    //    return response()->json(["message" => "Record deleted "],200);

    // }
}
