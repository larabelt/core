<?php

$factory->define(Belt\Core\Param::class, function (Faker\Generator $faker) {
    return [
        'key' => $faker->word,
        'value' => $faker->word,
    ];
});