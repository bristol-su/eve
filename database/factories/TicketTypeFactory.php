<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\TicketType::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(99999, 1000000),
        'name' => $faker->name,
        'event_id' => function() {
            return factory(\App\UcEvent::class)->create()->id;
        },

    ];
});
