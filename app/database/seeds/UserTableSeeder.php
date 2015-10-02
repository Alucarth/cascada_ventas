<?php 
class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->delete();
 
        User::create(array(
            'username' => 'firstuser',
            'password' => Hash::make('first_password'),
            'email'    => 'correo1@empresa.com'
        ));
 
        User::create(array(
            'username' => 'seconduser',
            'password' => Hash::make('second_password'),
            'email'    => 'correo2@empresa.com'
        ));
    }
 
}
?>