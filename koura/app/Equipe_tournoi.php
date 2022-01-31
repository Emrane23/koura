<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe_tournoi extends Model
{
    protected $fillable = [
        'tournoi_id','Equipe_id' 
    ];

    protected $hidden = [
        'created_at','updated_at'  
    ];
}
