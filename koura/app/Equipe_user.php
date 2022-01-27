<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe_user extends Model
{
    protected $fillable = [
        'user_id','Equipe_id' 
    ];

    protected $hidden = [
        'created_at','updated_at'  
    ];
}
