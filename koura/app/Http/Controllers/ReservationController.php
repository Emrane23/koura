<?php

namespace App\Http\Controllers;

use App\reservation;
use App\Stade;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index($id)
    {
        $reservation = reservation::where("stade_id", "=", "$id");
        return response()->json($reservation, 200);
    }




    public function store(Request $request)
    {
        $input = $request->all();
        $input['etat'] = "En attente";
        $reservation = reservation::create($input);
        return response()->json($reservation, 200);
    }



    public function show($id)
    {
        $reservation = reservation::find($id);

        if (empty($reservation)) {

            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($reservation, 200);
    }



    public function destroy($id)
    {
        $reservation = reservation::find($id);

        if (empty($reservation)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $reservation->delete();
    }



    public function heure_dispo($date, $idstade)
    {
        $start_time = Stade::where('id', $idstade)->value('horaire_ouverture');
        $end_time = Stade::where('id', $idstade)->value('horaire_fermeture');
        // $start_time ="08:00";
        // $end_time = "20:00";


         $slots = $this->getTimeSlot(120, $start_time, $end_time);
        $heuresdispo = [];
        foreach ($slots as $slot) {
            $value1=$slot['horaire_debut'];
            $value2=$slot['horaire_fin'];
            $lastvalue="De ".$value1." a "."$value2 ";
            array_push($heuresdispo,$lastvalue);
        }
    
        $heuresreserve = DB::table('reservations')->where('date',$date)->pluck('horaire_reservation');

    

        foreach ($heuresreserve as $heure) {

            if (($key = array_search($heure, $heuresdispo)) !== false) {
                unset($heuresdispo[$key]);
            }
        }
        return response()->json($heuresdispo, 200);
    }



    function getTimeSlot($interval, $start_time, $end_time)
    {

        $start = new \DateTime($start_time);
        $end = new \DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $i = 0;
        $time = [];
        while (strtotime($startTime) <= strtotime($endTime)) {
            $start = $startTime;
            $end = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
            $startTime = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
            $i++;
            if (strtotime($startTime) <= strtotime($endTime)) {
                $time[$i]['horaire_debut'] = $start;
                $time[$i]['horaire_fin'] = $end;
            }
        }
        return $time;
        // $period = new CarbonPeriod($start_time , $interval.' minutes', $end_time);
        // $slots = [];

        // foreach ($period as $key => $slot) {
        //     array_push($slots , $slot->format('H:i'));
        // }

        // return $slots;
    }
}
