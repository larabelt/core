<?php

$factory->define(Belt\Core\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'body' => $faker->paragraphs(1, true),
    ];
});