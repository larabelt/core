<?php

$factory->define(Belt\Core\Alert::class, function (Faker\Generator $faker) {

    $hours = random_int(1, 100);

    return [
        'name' => $faker->company,
        'body' => $faker->paragraphs(1, true),
        'starts_at' => $faker->dateTimeBetween('-1 days', '+2 days'),
        'ends_at' => $faker->dateTimeBetween('+2 days', '+3 days'),
    ];
});