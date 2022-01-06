<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stade extends Model
{
    
    protected $fillable = [
        'proprietaire_id','name', 'gouvernorat' , 'delegation', 'image', 'nbr_terrain','capacite' , 'horaire_ouverture', 'horaire_fermeture' , 'adresse' , 'tarif',
    ];

    protected $hidden = [
        'created_at','updated_at'  ,'proprietaire_id'
    ];





    public function proprietaires(){
        return $this->hasMany('App\User' , 'id','id');
    }
}
