<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $fillable = [
        'createur_id','nom','logo'
    ];

    protected $hidden = [
        'updated_at','pivot'
    ];

    public function joueurs(){
        return $this->belongsToMany('App\User' , 'App\Equipe_user', 'equipe_id','user_id','id', 'id');
    }

    public function tournois(){
        return $this->belongsToMany('App\Tournoi' , 'App\Equipe_tournoi', 'equipe_id','tournoi_id','id', 'id');
    }

    public function createur()
{
    return $this->belongsTo(User::class, 'createur_id');
}


}
