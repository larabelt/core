<?php

$factory->define(Belt\Core\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});