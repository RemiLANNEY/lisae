<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    //
    
	protected $table = "candidats";
	
	protected $fillable = [
			'id', 'Nom', 'Prenom', 'Sexe', 'Date_de_naissance', 'Antenne_pole_emploi', 'Nationalite', 'Adresse','CP', 'Ville', 'QPV', 'Email', 'Telephone', 'Statut', 'Num_pole_emploi', 'Num_secu', 'Commentaires','liste'
			
	];
	
	protected $hidden = [
			'promo_id', 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13'
	];
}
