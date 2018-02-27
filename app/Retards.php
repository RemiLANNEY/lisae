<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retards extends Model
{
	//
	
	protected $table = "retards";
	
	protected $fillable = [
			'id', 'id_etudiant', 'date', 'motif'
			
	];
	
	protected $hidden = [
	];
}
