<?php

$factory->define(Belt\Core\Translation::class, function (Faker\Generator $faker) {
    return [
        'translatable_type' => 'params',
        'translatable_column' => 'value',
        'locale' => 'es_ES',
        'value' => $faker->words(rand(3, 7), true),
    ];
});