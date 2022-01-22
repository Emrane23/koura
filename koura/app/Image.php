<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Stade;

class Image extends Model
{
  
	protected $fillable=[
		'image',
		'stade_id',
	];

	public function stades(){
		return $this->belongsTo(Stade::class);
	}
}
