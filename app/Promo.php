<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{

    protected $fillable = ['titre', 'ville', 'description','user_id'];

	public function promos() 
	{
		return $this->belongsTo('App\User');
	}
	
	public static function AllPromos(){
		return "test";
	}

}