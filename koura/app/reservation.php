<?php

namespace App;
use App\Tournoi;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    
    protected $fillable = [
        'client_id' ,'stade_id', 'date', 'horaire_debut', 'horaire_fin', 'message', 'service', 'etat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    public function clients(){
        return $this->belongsTo('App\User' ,'client_id','id');
    }

    public function stades(){
        return $this->belongsTo('App\Stade' , 'stade_id','id');
    }
    

}
