<?php

namespace App\Repositories;

use App\Promo;

class PromoRepository extends RessourceRepository
{

    public function __construct(Promo $promo)
	{
		$this->model = $promo;
	}

	private function save(Promo $promo, Array $inputs)
	{

		$promo->titre= $inputs['titre'];
		$promo->ville= $inputs['ville'];	
		$promo->pays= $inputs['pays'];
		$promo->dateDebutPromo= $inputs['dateDebutPromo'];
		$promo->dateFinPromo= $inputs['dateFinPromo'];	
		$promo->description= $inputs['description'];	
		$promo->user_id= $inputs['user_id'];	

		return $promo->save();
	}
	
	
	public function store(Array $inputs)
	{	
		$promo = new $this->model;
		if($this->save($promo, $inputs))
		{
			return true;
		}
		else 
		{
			return false;
		}
		
// 		return $promo;
	}


}