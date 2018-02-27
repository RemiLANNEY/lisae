<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
	//
	
	protected $table = "structure";
	
	protected $fillable = [
			'id', 'nom', 'adresse1', 'adresse2', 'cp', 'ville', 'tel', 'email', 'site', 'typeStructure', 'notes', 'logo', 'users_id'
			
	];
	
	protected $hidden = [
	];
}
