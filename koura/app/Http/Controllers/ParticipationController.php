<?php

namespace App\Http\Controllers;
use App\Participation;
use App\Tournoi;
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
    public function store(Request $request)
    {
        $idtournoi=$request->tournoi_id ;
        $places=Tournoi::where('id',$idtournoi)->value('places');
        if ($places==0) {

            return response()->json(["error" => "Complet! il ne reste aucune place disponible ! "], 400);
        }
        $userid=$request->user_id ;
        $participation = Participation::where('user_id',$userid)->where('tournoi_id',$idtournoi)->count();
        if ($participation>0) {

            return response()->json(["error" => "vous etes déjà inscrit à ce tournoi ! "], 400);
        }
       $dateparticip= strtotime(date('Y-m-d H:i:s')) ;
       $datetournoi=Tournoi::find($idtournoi)->date_fin;
       $datetournoi=strtotime($datetournoi);
       if ($dateparticip>$datetournoi) {

        return response()->json(["error" => "la date final pour la participation est dépassé ! "], 400);
    }
        
        $input = $request->all();
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
}
