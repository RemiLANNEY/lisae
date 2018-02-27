<?php 

namespace App\Repositories;

use App\Retards;

class RetardsRepository extends RessourceRepository
{


	public function __construct(Retards $retards)
	{
		$this->model = $retards;
	}

	private function save(Retards $retards, Array $inputs)
	{
		$retards->id_etudiant = $inputs['id_etudiant'];
		$retards->date= $inputs['date'];
		$retards->motif = $inputs['motif'];

		return $retards->save();
	}
	
	public function store(Array $inputs)
	{
		$retard = new $this->model;
		if($this->save($retard, $inputs))
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