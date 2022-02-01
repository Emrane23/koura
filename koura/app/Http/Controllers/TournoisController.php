<?php

namespace App\Http\Controllers;
use App\Tournoi;
use App\reservation;
Use Illuminate\Support\Facades\DB;
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
        $tournoi=Tournoi::with('organisateur')->with('equipes')->with('users')->get();
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
        $debut=$request->input('date_debut');
        $fin=$request->input('date_fin');
        $dateact= date('Y-m-d H:i');
        if ($debut<$dateact)
        {
            return response()->json(["error" => "Ce date déja dépassée ! "], 400);  
        }
        
         $idstade=$request->input('stade_id');
         $start = new \DateTime($debut);
         $end = new \DateTime($fin);
         $datedebut=$start->format('Y-m-d');
         $datefin=$end->format('Y-m-d');
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
            return response()->json(["error" => "Vérifier l'heure d'ouverture et fermeture de ce stade! "], 400);
        }
   
        $listdate=$this->dateintervalle($datedebut,$datefin);

       $reservations=reservation::where('stade_id',$idstade)->whereIn('date',$listdate)->get();
         $hdbut=new \DateTime($debut);
         $hfin=new \DateTime($fin);
         $horair_debut=$hdbut->format('Y-m-d H:i');
         $horair_fin=$hfin->format('Y-m-d H:i');
 
        foreach ($reservations as $reservation) {
            $dbdatestart=$reservation->date." ".$reservation->horaire_debut;
            $dbdatend=$reservation->date." ".$reservation->horaire_fin;
             $dbstart=new \DateTime($dbdatestart);
            $dbend=new \DateTime($dbdatend);
           
            $dbhorair_debut= $dbstart->format('Y-m-d H:i');
         
            $dbhorair_fin=$dbend->format('Y-m-d H:i');
            
            if ( $horair_debut > $dbhorair_debut && $horair_debut < $dbhorair_fin ){
                return response()->json(["error" => "Période déja réservé! "], 400);
            }
            elseif ( $horair_fin > $dbhorair_debut && $horair_fin < $dbhorair_fin ) {
                return response()->json(["error" => "Période déja réservé! "], 400);

            }
            elseif( $horair_debut <= $dbhorair_debut && $horair_fin >= $dbhorair_fin){
                return response()->json(["error" => "Période déja réservé! "], 400);

            }
        }
        $tournois= DB::table('tournois')->select(DB::raw('(date_debut) as date_debut'), DB::raw('(date_fin) as date_fin'))->where('stade_id',$idstade)->get();
        foreach ($tournois as $tournoi) {
            $dbdatestart=$tournoi->date_debut;
            $dbdatend=$tournoi->date_fin;
            $dbstart=new \DateTime($dbdatestart);
            $dbend=new \DateTime($dbdatend);
           
            $dbhorair_debut= $dbstart->format('Y-m-d H:i');
         
            $dbhorair_fin=$dbend->format('Y-m-d H:i');
            
            if ( $horair_debut > $dbhorair_debut && $horair_debut < $dbhorair_fin ){
                return response()->json(["error" => "Période déja réservé pour un tournoi ! "], 400);
            }
            elseif ( $horair_fin > $dbhorair_debut && $horair_fin < $dbhorair_fin ) {
                return response()->json(["error" => "Période déja réservé pour un tournoi ! "], 400);

            }
            elseif( $horair_debut <= $dbhorair_debut && $horair_fin >= $dbhorair_fin){
                return response()->json(["error" => "Période déja réservé pour un tournoi ! "], 400);

            }
        }

      
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
        $tournoi = Tournoi::with('organisateur')->with('equipes')->with('users')->find($id);

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

    function dateintervalle($datestart,$dateend)
    {

    $debut_jour = substr("$datestart",-2) ;
    $debut_mois = substr("$datestart",5,2) ;
    $debut_annee = substr("$datestart", 0, 4);

    $fin_jour = substr("$dateend",-2) ;
    $fin_mois = substr("$dateend",5,2);
    $fin_annee = substr("$dateend", 0, 4);

     $debut_date = mktime(0, 0, 0, $debut_mois, $debut_jour, $debut_annee);
     $fin_date = mktime(0, 0, 0, $fin_mois, $fin_jour, $fin_annee);
     $listdate=[];

     for($i = $debut_date; $i <= $fin_date; $i+=86400)
        {
           $aux=date("Y-m-d",$i);
           array_push($listdate,$aux);
         }
         return $listdate;
        }


        function add(Request $request ,$organisateurid)
        {
            $input = $request->all();
        $debut=$request->input('date_debut');
        $fin=$request->input('date_fin');
        $dateact= date('Y-m-d H:i');
        if ($debut<$dateact)
        {
            return response()->json(["error" => "Ce date déja dépassée ! "], 400);  
        }
        
         $idstade=$request->input('stade_id');
         $start = new \DateTime($debut);
         $end = new \DateTime($fin);
         $datedebut=$start->format('Y-m-d');
         $datefin=$end->format('Y-m-d');
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
            return response()->json(["error" => "Vérifier l'heure d'ouverture et fermeture de ce stade! "], 400);
        }
   
        $listdate=$this->dateintervalle($datedebut,$datefin);

       $reservations=reservation::where('stade_id',$idstade)->whereIn('date',$listdate)->get();
         $hdbut=new \DateTime($debut);
         $hfin=new \DateTime($fin);
         $horair_debut=$hdbut->format('Y-m-d H:i');
         $horair_fin=$hfin->format('Y-m-d H:i');
         $horaire_debut=$hdbut->format('H:i');
         $horaire_fin=$hfin->format('H:i');
         foreach ($reservations as $reservation) {
            $dbdatestart=$reservation->date." ".$reservation->horaire_debut;
            $dbdatend=$reservation->date." ".$reservation->horaire_fin;
             $dbstart=new \DateTime($dbdatestart);
            $dbend=new \DateTime($dbdatend);
           
            $dbhorair_debut= $dbstart->format('Y-m-d H:i');
         
            $dbhorair_fin=$dbend->format('Y-m-d H:i');
            
            if ( $horair_debut > $dbhorair_debut && $horair_debut < $dbhorair_fin ){
                return response()->json(["error" => "Période déja réservé! "], 400);
            }
            elseif ( $horair_fin > $dbhorair_debut && $horair_fin < $dbhorair_fin ) {
                return response()->json(["error" => "Période déja réservé! "], 400);

            }
            elseif( $horair_debut <= $dbhorair_debut && $horair_fin >= $dbhorair_fin){
                return response()->json(["error" => "Période déja réservé! "], 400);

            }
        }
        $i=1;

        if($datedebut==$datefin){
            $this->reservastion_equipe($idstade,$organisateurid,$datedebut,$horaire_debut,$horaire_fin);
        }
        elseif($datedebut!=$datefin){
            
            foreach ($listdate as $key => $date) {
                if($i==1){
                    $this->reservastion_equipe($idstade,$organisateurid,$date,$horaire_debut,$hfermeture);
                }
                elseif($i==count($listdate)){
                    $this->reservastion_equipe($idstade,$organisateurid,$date,$houverture,$horaire_fin);
                }
                else{
                    $this->reservastion_equipe($idstade,$organisateurid,$date,$houverture,$hfermeture);
                }
                $i=$i+1;
            }

        }
        $input = $request->all();
        $input['organisateur_id']=$organisateurid;
        $tournoi = Tournoi::create($input);
        return response()->json($tournoi,201);


        }

        


        public function mise_ajour(Request $request, $id)
        {
            $tournoi=Tournoi::find($id);
            if (empty($tournoi)) {
    
                return response()->json(["error" => "not found! "], 400);
            
            }
            















            $input = $request->all();
            $tournoi->update($input);
        }















        function reservastion_equipe($stade,$client,$date,$horairedebut,$horairefin)
        {
            $reservation=new reservation();
            $reservation->client_id= $client;
            $reservation->stade_id= $stade;
            $reservation->date= $date;
            $reservation->horaire_debut= $horairedebut;
            $reservation->horaire_fin =$horairefin ;
            $reservation->etat="En attente";
            $reservation->save();
        }
}
