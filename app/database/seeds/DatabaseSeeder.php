<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		User::create(array(
			'name' => 'admin',
			'username'=>'admin',
			'email' => 'info@emizor.com',
			'password' => '123456'
		));
		
	}

}
