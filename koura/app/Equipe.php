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
        'created_at','updated_at','pivot'
    ];

    public function user(){
        return $this->belongsToMany('App\User' , 'App\Equipe_user', 'equipe_id','user_id','id', 'id');
    }

    public function createur()
{
    return $this->belongsTo(User::class, 'createur_id');
}

}
