<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = [
        'montant','designation',
    ];

    protected $hidden = [
        'created_at','updated_at'  
    ];
}
