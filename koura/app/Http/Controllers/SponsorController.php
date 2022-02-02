<?php

namespace App\Http\Controllers;
use App\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sponsor=Sponsor::all();
        return response()->json($Sponsor,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $Sponsor = Sponsor::create($input);
        return response()->json($Sponsor,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Sponsor = Sponsor::find($id);

        if (empty($Sponsor)) {

            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($Sponsor, 200);
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
        $Sponsor=Sponsor::find($id);
        if (empty($Sponsor)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $input = $request->all();
        $Sponsor->update($input);
        return response()->json($Sponsor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Sponsor = Sponsor::find($id);

        if (empty($Sponsor)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $Sponsor->delete();
        return response()->json(["message" => "Record deleted "],200);
    }
}
