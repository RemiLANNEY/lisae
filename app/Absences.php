<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
	//
	
	protected $table = "absences";
	
	protected $fillable = [
			'id', 'id_etudiant', 'date', 'motif', 'justif'
			
	];
	
	protected $hidden = [
	];
}
