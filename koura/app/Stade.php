<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stade extends Model
{
    
    protected $fillable = [
        'proprietaire_id','nom_proprietaire', 'prenom_proprietaire','type','option','name', 'gouvernorat' , 'delegation', 'image','capacite' , 'horaire_ouverture', 'horaire_fermeture' , 'adresse' , 'tarif',
    ];

    protected $hidden = [
        'created_at','updated_at'  
    ];


    public function reservations(){
        return $this->hasMany('App\reservation' , 'stade_id','id');
    }


    public function proprietaires(){
        return $this->belongsTo('App\User' , 'proprietaire_id','id');
    }
}
