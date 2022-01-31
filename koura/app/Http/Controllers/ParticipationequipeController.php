<?php

namespace App\Http\Controllers;
use App\Participation;
use App\Equipe_tournoi;
use App\Tournoi;
use App\Equipe;
use Illuminate\Http\Request;

class ParticipationequipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participation=Equipe_tournoi::all();
        return response()->json($participation,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,$userid)
    {
        $input = $request->all();
        $equipe=Equipe::find($request->equipe_id);
        if (empty($equipe)) {

            return response()->json(["error" => "equipe not found! "], 400);
        }
        if ($equipe->createur_id !=$userid) {

            return response()->json(["error" => " cette action ne peut pas fait que par le createur de l'equipe !"], 400);
        }

        $idtournoi=$request->tournoi_id ;
        $participation = Equipe_tournoi::where('equipe_id',$request->equipe_id)->where('tournoi_id',$idtournoi)->count();
        if ($participation>0) {
            
            return response()->json(["error" => "cette équipe est déja participé à ce tournoi ! "], 400);
        }
        $places=Tournoi::where('id',$idtournoi)->value('places');
        $joueurs=$equipe->joueurs;
        $ids=[];
        
        foreach ($joueurs as $key => $joueur)
        {
            array_push($ids,$joueur->id);
            
            
        }
        
        if ($places<count($ids)) {

            return response()->json(["error" => "Complet! il ne reste des places disponible pour votre equipe ! "], 400);
        }
        $input = $request->all();

        foreach ($ids as $key => $value) {
            $userid=$value;
            $participation = Participation::where('user_id',$userid)->where('tournoi_id',$idtournoi)->count();
        if ($participation>0) {
            
            return response()->json(["error" => "le joueur $userid est déja participé à ce tournoi ! "], 400);
        }
        }
         
       $dateparticip= strtotime(date('Y-m-d H:i:s')) ;
       $datetournoi=Tournoi::find($idtournoi)->date_fin;
       $datetournoi=strtotime($datetournoi);
       if ($dateparticip>$datetournoi) {

        return response()->json(["error" => "la date final pour la participation est dépassé ! "], 400);
    }

        
        $tournoi=Tournoi::find($idtournoi);
        $participation = $tournoi->equipes()->attach($equipe->id);

        Tournoi::where('id',$idtournoi)->decrement('places',count($ids));
        return  response()->json(['message'=>'Participation avec succées !'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request, $equipeid,$userid,$idtournoi)
    {
        $equipe= Equipe::find($equipeid);
          if ($equipe->createur_id !=$userid)
           {
             return response()->json(["error" => " cette action ne peut pas fait que par le createur de l'equipe !"], 400);
            }
           $joueurs=$equipe->joueurs;
           $ids=[];
           
           foreach ($joueurs as $key => $joueur)
           {
               array_push($ids,$joueur->id);
               
           }
          $increment= count($ids);


           Equipe_tournoi::where('equipe_id',$equipeid)->where('tournoi_id',$idtournoi)->delete();
        
          Tournoi::where('id',$idtournoi)->increment('places',$increment);

       return response()->json(["message" => "Record deleted "],200);

    }
    
}
