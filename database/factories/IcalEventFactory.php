<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\IcalEvent::class, function (Faker $faker) {
    return [
        'uid' => $faker->unique()->numberBetween(99999, 1000000),
        'event_id' => function() {
            return factory(\App\Event::class)->create()->id;
        },
    ];
});
