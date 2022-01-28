<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'user_id','tournoi_id' 
    ];

    protected $hidden = [
        'updated_at'  
    ];
}
