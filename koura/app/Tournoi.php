<?php

namespace App;
use App\User;
use App\reservation;
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
    public function equipes(){
        return $this->belongsToMany('App\Equipe' , 'App\Equipe_tournoi', 'tournoi_id','equipe_id','id', 'id')->withTimestamps();
    }
    public function organisateur()
{
    return $this->belongsTo(User::class, 'organisateur_id');
}
    public function reservation()
    {
        return $this->hasMany(reservation::class);
    }
}
