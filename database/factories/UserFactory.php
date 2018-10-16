<?php

use Faker\Generator as Faker;
use App\User;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'sex' => $faker->numberBetween(0,1),
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'email'=> str_random(15).'@gmail.com',
        'rac'=> $faker->realText(10),
        'status'=> 1,
        'nationality'=> $faker->countryCode,
        'national_card'=>$faker->randomDigit,
        'passport'=> $faker->randomDigit,
        'phone'=> str_random(10),
        'village'=> str_random(10),
        'commune'=> $faker->state,
        'district'=> $faker->city,
        'province'=> $faker->postcode,
        'current_address'=> $faker->address,
        'dateregistered'=> $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_id'=> User::all()->random()->id,
        'photo'=> $faker->randomElement(['90495.2018-09-05.1536117843.jpg',
        								 '30783.2018-09-05.1536118212.png',
        								 '49739.2018-09-05.1536121628.png',
        								 '56679.2018-09-05.1536129521.jpg',
        								]),

    ];
});
