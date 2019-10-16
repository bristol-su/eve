<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Scan::class, function (Faker $faker) {
    return [
        'ticket_number' => function() {
            return factory(\App\Ticket::class)->create()->ticket_number;
        },
    ];
});
