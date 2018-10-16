<?php

use Illuminate\Database\Seeder;
use App\Student;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $studentQuantity=5000;
        factory(Student::class,$studentQuantity)->create();
    }
}
