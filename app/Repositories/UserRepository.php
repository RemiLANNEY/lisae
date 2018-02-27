<?php

namespace App\Repositories;

use App\User;

class UserRepository extends RessourceRepository
{

    
	public function __construct(User $user)
	{
		$this->model = $user;
	}

	private function save(User $user, Array $inputs)
	{
		$user->name = $inputs['name'];
		$user->email = $inputs['email'];	
		$user->role = $inputs['role'];
		$user->admin = $inputs['admin'];
		if(!empty($inputs['promo_id'])) {
			$user->promo_id = $inputs['promo_id'];
		}
		$user->privileges = $inputs['privileges'];

		$user->save($inputs);
	}
	

	public function store(Array $inputs)
	{
		$user = new $this->model;		
		$user->password = bcrypt($inputs['password']);

		$this->save($user, $inputs);

		return $user;
	}

}