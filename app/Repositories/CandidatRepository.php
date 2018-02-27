<?php

namespace App\Repositories;

use App\Candidat;

class CandidatRepository extends RessourceRepository
{


    public function __construct(Candidat $candidat)
	{
		$this->model = $candidat;
	}

	private function save(Candidat $candidat, Array $inputs)
	{
// 		$promo->name = $inputs['name'];
// 		$promo->email = $inputs['email'];	
// 		$promo->role = $inputs['role'];
// 		$promo->admin = $inputs['admin'];
// 		$promo->privileges = $inputs['privileges'];	

		$candidat->save();
	}

}