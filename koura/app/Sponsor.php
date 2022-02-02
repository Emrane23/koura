<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'logo','lienweb','nom_sponsor','convention_sponsoring','date_fin_contrat'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
