<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charge ;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charge=Charge::all();
        return response()->json($charge,200);
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
        $charge = Charge::create($input);
        return response()->json($charge,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $charge = Charge::find($id);

        if (empty($charge)) {

            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($charge, 200);
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
        $charge=Charge::find($id);
        if (empty($charge)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $input = $request->all();
        $charge->update($input);
        return response()->json($charge, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charge = Charge::find($id);

        if (empty($charge)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $charge->delete();
    }
}
