<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    //
	protected $table = "evaluations";
	
	protected $fillable = [
			'id', 'created_at', 'update_at', 'id_etudiant', 'final', 'text'
			
	];
	
	protected $hidden = [
			'id'
	];
}
