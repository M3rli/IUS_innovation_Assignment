<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Assignment::class, function (Faker\Generator $faker) {

	$devices = array('Server', 'PC', 'Smartphone - Android', 'Laptop');


    return [
        'owner_id' => rand(0,5),
        'device_type' => $devices[rand(0,3)],
        'log' => $faker->paragraph,
        'resolved' => rand(0,1)

    ];
});
