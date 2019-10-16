<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\UcEvent::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(99999, 1000000),
        'name' => $faker->name,
        'slug' => $faker->slug,
        'description' => $faker->paragraph,
        'capacity' => $faker->numberBetween(50, 1500),
        'location' => $faker->city,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'contact_details' => $faker->firstName . ' ' . $faker->lastName,
        'email' => $faker->email,
        'start_date_time' => $faker->dateTime,
        'end_date_time' => $faker->dateTime,
    ];
});
