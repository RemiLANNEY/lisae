<?php 

namespace App\Repositories;

use App\Structure;

class StructureRepository extends RessourceRepository
{


	public function __construct(Structure $structure)
	{
		$this->model = $structure;
	}

	private function save(Structure $structure, Array $inputs)
	{
		// $retards->id_etudiant = $inputs['id_etudiant'];
		// $retards->date= $inputs['date'];
		// $retards->motif = $inputs['motif'];

		$structure->nom = $inputs['nom'];
		$structure->adresse1 = $inputs['adresse1'];
		$structure->adresse2 = $inputs['adresse2'];
		$structure->cp = $inputs['cp'];
		$structure->ville = $inputs['ville'];
		$structure->tel = $inputs['tel'];
		$structure->email = $inputs['email'];
		$structure->site = $inputs['site'];
		$structure->typeStructure = $inputs['typeStructure'];
		$structure->notes = $inputs['notes'];
		$structure->logo = $inputs['logo'];
		$structure->users_id = $inputs['users_id'];


		return $structure->save();
	}
	
	public function store(Array $inputs)
	{
		$structure = new $this->model;
		if($this->save($structure, $inputs))
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