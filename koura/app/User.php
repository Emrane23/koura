<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'nom','prenom', 'email','patente','date_de_naissance', 'type_user','nom_entreprise','pseudo', 'password','role', 'nbr_terrain', 'localisation', 'gouvernorat','sexe','delegation','telephone','image','test',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];


        public function reservations(){
            return $this->hasMany('App\reservation' , 'client_id','id');
        }

        public function stades(){
            return $this->hasMany('App\Stade' , 'proprietaire_id','id');
        }
        
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
    }