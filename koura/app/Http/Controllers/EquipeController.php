<?php

namespace App\Http\Controllers;
use App\Equipe ;
use App\Equipe_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;

class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipe=Equipe::with('createur')->with('joueurs')->get();
        return response()->json($equipe,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        
        $input = $request->all();
        $joueurs=DB::table('equipe_users')->pluck('user_id');
        foreach ($input['joueurs'] as $value) {
            if ($joueurs->contains($value))
            {
                return response()->json(["error" => "il y'a un ou des joueurs(s) qui appartiennent déja à une autre équipe ! "], 400);
            }
        }

        $equipe = Equipe::create($input);
        $equipe->joueurs()->attach($input['joueurs']);
        return response()->json($equipe,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipe = Equipe::with('createur')->with('joueurs')->find($id);

        if (empty($equipe)) {
            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($equipe, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$userid)
    {

        $equipe=Equipe::find($id);
        if (empty($equipe)) {

            return response()->json(["error" => "not found! "], 400);
        }
        if ($equipe->createur_id !=$userid) {

            return response()->json(["error" => " cette action ne peut pas fait que par le createur de l'equipe !"], 400);
        }

        $input = $request->all();
        $joueurs=DB::table('equipe_users')->pluck('user_id');
        foreach ($input['joueurs'] as $value) {
            if ($joueurs->contains($value))
            {
                return response()->json(["error" => "il y'a un ou des joueurs(s) qui appartiennent déja à une autre équipe ! "], 400);
            }
        }
        $equipe->update($input);
        $equipe->joueurs()->sync($request->joueurs);

        return response()->json($equipe, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$userid)
    {
        $equipe = Equipe::find($id);

        if (empty($equipe)) {

            return response()->json(["error" => "not found! "], 400);
        }
        if ($equipe->createur_id !=$userid) {

            return response()->json(["error" => " cette action ne peut pas fait que par le createur de l'equipe !"], 400);
        }
        $equipe->joueurs()->detach();
        $equipe->delete();

        return response()->json(["message" => "Record deleted "],200);
    }

    public function quitter_equipe($userid)
    {
        DB::table('equipe_users')->where('user_id',$userid)->delete();
        return response()->json(["message" => "Vous avez quitter l'équipe avec succées"],200);
    }
}
