<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    public function run()
	{
		DB::table('users')->delete();

		DB::table('users')->insert([
				'name' => 'Rémi LANNEY',
				'email' => 'rlanney@simplon.co',
				'password' => '$2y$10$F0L2oOLDZuoKDXzq7av6..55neoXxVYSo3betEdj4fb/WzUqefhDa',
				'privileges' => 'SuperAdmin',
				'admin' => '1'
		]);
		DB::table('users')->insert([
				'name' => 'Test Admin',
				'email' => 'test@test.com',
				'password' => '$2y$10$OnZIdJs0JGPdecGqvZnWJ.MFPVHI1Tt8fnooNFNrItwiG7tUafEX6',
				'privileges' => 'Admin',
				'admin' => '1'
		]);
		
		for($i = 0; $i < 10; ++$i)
		{
			DB::table('users')->insert([
				'name' => 'users' . $i,
				'email' => 'users' . $i . '@test.fr',
				'password' => bcrypt('test' . $i),
				'admin' => rand(1, 2)
			]);
		}
	}
}