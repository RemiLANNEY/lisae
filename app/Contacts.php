<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    //

    protected $table = "contacts";
	
	protected $fillable = [
			'id', 'nom', 'prenom', 'tel1', 'tel2', 'email', 'fonction', 'notes', 'logo', 'users_id'
			
	];
	
	protected $hidden = [
	];
}
