<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name'=>'chetan',
        	'username'=>'chetan',
        	'email'=>'chetan@yahoo.com',
        	'password'=>bcrypt('chetan'),
        	'remember_token'=>str_random(10),
        	'role_id'=>1,
        	'active'=>1,

        ]);
    }
}
