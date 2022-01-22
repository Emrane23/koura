<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = [
        'montant','designation','prix_unitaire','quantité','num_facture','facture'
    ];

    protected $hidden = [
        'created_at','updated_at'  
    ];
}
