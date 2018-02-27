<?php 

namespace App\Repositories;

use App\Absences;

class AbsencesRepository extends RessourceRepository
{


	public function __construct(Absences $absences)
	{
		$this->model = $absences;
	}

	private function save(Absences $absences, Array $inputs)
	{
		$absences->id_etudiant = $inputs['id_etudiant'];
		$absences->date= $inputs['date'];
		$absences->motif = $inputs['motif'];

		return $absences->save();
	}
	
	public function store(Array $inputs)
	{
		$absence = new $this->model;
		if($this->save($absence, $inputs))
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