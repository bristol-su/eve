<?php

/** @var Factory $factory */

use App\UcEvent;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Ticket::class, function (Faker $faker) {
    return [
        'forename' => $faker->firstName,
        'surname' => $faker->lastName,
        'ticket_type_id' => function() {
            return factory(\App\TicketType::class)->create()->id;
        },
        'quantity' => 1,
        'ticket_number' => $faker->randomLetter . $faker->randomLetter. $faker->randomNumber(1). $faker->randomLetter.  $faker->randomNumber(2),
        'redeemed' => false,
        'on_codereadr' => false
    ];
});
