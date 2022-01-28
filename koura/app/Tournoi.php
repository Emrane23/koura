<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournoi extends Model
{
    protected $fillable = [
        'organisateur_id','stade_id', 'nom','date_debut','date_fin','places', 'cotisation' 
    ];

    protected $hidden = [
        'created_at','updated_at'  
    ];

    public function users(){
        return $this->belongsToMany('App\User' , 'App\Participation', 'tournoi_id','user_id','id', 'id')->withTimestamps();
    }
}
