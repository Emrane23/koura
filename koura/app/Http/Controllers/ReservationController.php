<?php

namespace App\Http\Controllers;

use App\reservation;
use App\Stade;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
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
        $debut=$request->input('horaire_debut');
        $fin=$request->input('horaire_fin');
        $date=$request->input('date');
        $idstade=$request->input('stade_id');
        $start = new \DateTime($debut);
        $end = new \DateTime($fin);
        $horair_debut = $start->format('H:i');
        $horair_fin = $end->format('H:i');
        $houverture=  DB::table('stades')->where('id',$idstade)->value('horaire_ouverture');
        $hfermeture=DB::table('stades')->where('id',$idstade)->value('horaire_fermeture');
        $ho= new \DateTime($houverture);
        $fe=new \DateTime($hfermeture);
        $houverture=$ho->format('H:i');
        $hfermeture=$fe->format('H:i');

        if( (strtotime($horair_debut) < strtotime($houverture)) || (strtotime($horair_fin) > strtotime($hfermeture)))
        {
            return response()->json(["error" => "Vérifir la date d'ouverture et fermeture de ce stade! "], 400);
        }

        $reservations=reservation::where('stade_id',$idstade)->where('date',$date)->get();
 
        foreach ($reservations as $reservation) {
             $dbstart=new \DateTime($reservation->horaire_debut);
            $dbend=new \DateTime($reservation->horaire_fin);
            $dbhorair_debut= $dbstart->format('H:i');
          
            $dbhorair_fin=$dbend->format('H:i');
            
            if ( $horair_debut >= $dbhorair_debut && $horair_debut <= $dbhorair_fin ){
                return response()->json(["error" => "Période déja réservé! "], 400);
            }
            elseif ( $horair_fin >= $dbhorair_debut && $horair_fin <= $dbhorair_fin ) {
                return response()->json(["error" => "Période déja réservé! "], 400);

            }
        }
 
        
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



    // public function heure_dispo($date, $idstade)
    // {
    //     $start_time = Stade::where('id', $idstade)->value('horaire_ouverture');
    //     $end_time = Stade::where('id', $idstade)->value('horaire_fermeture');
    //     // $start_time ="08:00";
    //     // $end_time = "20:00";


    //      $slots = $this->getTimeSlot(120, $start_time, $end_time);
    //     $heuresdispo = [];
    //     foreach ($slots as $slot) {
    //         $value1=$slot['horaire_debut'];
    //         $value2=$slot['horaire_fin'];
    //         $lastvalue="De ".$value1." a "."$value2 ";
    //         array_push($heuresdispo,$lastvalue);
    //     }
    
    //     $heuresreserve = DB::table('reservations')->where('date',$date)->pluck('horaire_reservation');

    

    //     foreach ($heuresreserve as $heure) {

    //         if (($key = array_search($heure, $heuresdispo)) !== false) {
    //             unset($heuresdispo[$key]);
    //         }
    //     }
    //     return response()->json($heuresdispo, 200);
    // }



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

    public function reservdate($date)
    {
        //liste réservation par date 
        $reservation= reservation::with('Clients')->with('stades')->where('date',$date)->get();
        return response()->json($reservation, 200);
    }

    

    public function Listpardate()
    {

    //    $result= reservation::select([DB::raw('* as listes'),
    //   DB::raw('count(*) as nbr_reservation'),  DB::raw('DATE(date) as date')
    // ])->groupBy('date')
    // ->get();
    $liste= DB::table('reservations')->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as title'))
        ->groupBy('date')
        ->get();
        return response()->json($liste, 200); 
        
    

    }


    public function nbr_reservation_par_date($date)
    {
        //nombre réservation total par date

        $reservation= reservation::where('date',$date)->count();
        return response()->json($reservation, 200);

    }

    public function nbr_reservation_par_stade($date, $stadeid)
    {
        //nombre réservation d'un stade par date

        $reservation= reservation::where('date',$date)->where('stade_id',$stadeid)->count();
        return response()->json($reservation, 200);

    }


    public function list_reserv_dprop($propid, $date )
    {
        // liste reservations par date d'un prop
        
        $stades=Stade::where('proprietaire_id',$propid)->pluck('id');
        $reservation= reservation::whereIn('stade_id', $stades)->where('date',$date)->with('Clients')->with('stades')->get();
        return response()->json($reservation, 200);


    }
    public function list_reservtotal_dprop($propid)
    {
        //liste reservations total d'un prop
        $stades=Stade::where('proprietaire_id',$propid)->pluck('id');
        $reservation= reservation::whereIn('stade_id', $stades)->get();
        return response()->json($reservation, 200);

    }

    public function nombre_reservtotal_dprop($propid)
    {
        //nombre des reservations total d'un prop
        $stades=Stade::where('proprietaire_id',$propid)->pluck('id');
        $reservation= reservation::whereIn('stade_id', $stades)->count();
        return response()->json($reservation, 200);

    }

    public function listreservprop($propid)
    {
        {


            //    $result= reservation::select([DB::raw('* as listes'),
            //   DB::raw('count(*) as nbr_reservation'),  DB::raw('DATE(date) as date')
            // ])->groupBy('date')
            // ->get();
            $stades=Stade::where('proprietaire_id',$propid)->pluck('id');
        
            $liste= DB::table('reservations')->whereIn('stade_id', $stades)->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as title'))
                ->groupBy('date')
                ->get();
                return response()->json($liste, 200); 
                
            
        
            }

    }

    
    public function valide_reservation($reservationid)
    {
        //valide une reservation
        $reservation = reservation::find($reservationid);
        if (empty($reservation)) {

            return response()->json(["error" => "not found! "], 400);
        }

        reservation::where('id', $reservationid)
      ->update(['etat' => "Validé"]);
      return response()->json(['message'=>'Réservation validé avec succés!'],200);


    }

    public function invalide_reservation($reservationid)
    {
        //invalide une reservation
        $reservation = reservation::find($reservationid);
        if (empty($reservation)) {

            return response()->json(["error" => "not found! "], 400);
        }

        reservation::where('id', $reservationid)
      ->update(['etat' => "Non validé"]);
      return response()->json(['message'=>'Annulation du réservation avec succés!'],200);
    }


    public function heures_disponible($stadeid, $date)
    {

      $reservations=  DB::table('reservations')
        ->select(array('horaire_debut', 'horaire_fin'))->where('stade_id',$stadeid)->where('date',$date)
        ->get();
        $complet = [];
        $heuresdispo=[];
        $i = 0;

        foreach ($reservations as $reservation ) {
            $i++;
            $complet[$i]['horaire_debut'] = $reservation->horaire_debut;
            $complet[$i]['horaire_fin'] = $reservation->horaire_fin;
        }
        $houverture=  DB::table('stades')->where('id',$stadeid)->value('horaire_ouverture');
       
        $hfermeture=DB::table('stades')->where('id',$stadeid)->value('horaire_fermeture');
        $j=1;
        $heuresdispo[1]['from'] = $houverture;
        $heuresdispo[1]['to']=$complet[1]['horaire_debut'];
        
        for ($i=1; $i < count($complet); $i++) { 
            
            $j++;
            
                $heuresdispo[$j]['from'] = $complet[$i]['horaire_fin'];
                $heuresdispo[$j]['to']=$complet[$i+1]['horaire_debut'];
        
            
        }
        $heuresdispo[$j+1]['from'] = $complet[$i]['horaire_fin'];
        $heuresdispo[$j+1]['to']=$hfermeture;
        foreach ($heuresdispo as $key => $value) {
           
        $start = new \DateTime($value['from']);
        $end = new \DateTime($value['to']);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $interval=abs(strtotime($endTime) - strtotime($startTime));
        if ($interval < 30*60)
        {
            unset($heuresdispo[$key]);
        }
            
        }
      
        return response()->json($heuresdispo, 200); 
    }

}
