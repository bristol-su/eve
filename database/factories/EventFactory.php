<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Event::class, function (Faker $faker) {
    return [
        'summary' => $faker->paragraph,
        'location' => $faker->city,
        'start' => $faker->dateTime,
        'end' => $faker->dateTime,
    ];
});
