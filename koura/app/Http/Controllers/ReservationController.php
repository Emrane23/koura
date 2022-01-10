<?php

namespace App\Http\Controllers;
use App\reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index($id)
    {
        $reservation=reservation::where("stade_id","=","$id");
        return response()->json($reservation,200);
    }  
    

    

    public function store(Request $request)
    {
        $input = $request->all();
        $input['etat']="En attente";
        $reservation=reservation::create($input);
        return response()->json($reservation,200);
    }



    public function show($id)
    {
        $reservation = reservation::find($id);

        if (empty($reservation)) {

           return response()->json(["error" => "not found! "],400);

        }

        return response()->json($reservation,200);
    }



    public function destroy($id)
    {
        $reservation = reservation::find($id);

        if (empty($reservation)) {

           return response()->json(["error" => "not found! "],400);

        }
        $reservation->delete();
    }
}
