<?php

namespace App\Repositories;

use App\Evaluations;

class EvaluationsRepository extends RessourceRepository
{
	
	
	public function __construct(Evaluations $eval)
	{
		$this->model = $eval;
	}
	
	private function save(Evaluations $eval, Array $inputs)
	{
		$eval->id_candidat = $inputs['id_etudiant'];
		if($inputs['final']=="true")
			$eval->final = 1;
		else 
			$eval->final = 0;
		$eval->text = $inputs['text'];
		
		$eval->save();
	}
	
	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
}