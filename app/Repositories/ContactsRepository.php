<?php 

namespace App\Repositories;

use App\Contacts;

class ContactsRepository extends RessourceRepository
{


	public function __construct(Contacts $contacts)
	{
		$this->model = $contacts;
	}

	private function save(Contacts $contacts, Array $inputs)
	{
		// $retards->id_etudiant = $inputs['id_etudiant'];
		// $retards->date= $inputs['date'];
		// $retards->motif = $inputs['motif'];

		$contacts->nom = $inputs['nom'];
		$contacts->prenom = $inputs['prenom'];
		$contacts->tel1 = $inputs['tel1'];
		$contacts->tel2 = $inputs['tel2'];
		$contacts->email = $inputs['email'];
		$contacts->users_id = $inputs['users_id'];
		$contacts->notes = $inputs['notes'];


		return $contacts->save();
	}
	
	public function store(Array $inputs)
	{
		$contacts = new $this->model;
		if($this->save($contacts, $inputs))
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