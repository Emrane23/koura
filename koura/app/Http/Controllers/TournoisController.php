<?php

namespace App\Http\Controllers;
use App\Tournoi;
use Illuminate\Http\Request;

class TournoisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournoi=Tournoi::all();
        return response()->json($tournoi,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,$organisateurid)
    {
        $input = $request->all();
        $input['organisateur_id']=$organisateurid;
        $tournoi = Tournoi::create($input);
        return response()->json($tournoi,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tournoi = Tournoi::find($id);

        if (empty($tournoi)) {

            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($tournoi, 200);
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
        $tournoi=Tournoi::find($id);
        if (empty($tournoi)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $input = $request->all();
        $tournoi->update($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tournoi = Tournoi::find($id);

        if (empty($tournoi)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $tournoi->delete();
    }
}
