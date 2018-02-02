<?php

$factory->define(Belt\Core\Ability::class, function (Faker\Generator $faker) {
    return [
        'name' => strtolower($faker->word),
        'entity_type' => strtolower($faker->word),
    ];
});