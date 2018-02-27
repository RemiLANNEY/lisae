<?php

use Illuminate\Database\Seeder;

class PromosTableSeeder extends Seeder {

    public function run()
	{
		DB::table('promos')->delete();

		
		for($i = 0; $i < 10; ++$i)
		{
			DB::table('promos')->insert([
				'titre' => 'Simplon '.$i,
				'ville' => 'Nice '.$i,
				'dateDebutPromo' => date("Y-m-d", strtotime("now")),
				'dateFinPromo' => date("Y-m-d", strtotime("now + 6 months")),
				'description' => 'Description Simplon '.$i
			]);
		}
	}
}