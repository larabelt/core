<?php

$factory->define(Belt\Core\PublishHistory::class, function (Faker\Generator $faker) {
    return [
        'path' => '/' . $faker->word,
        'hash' => md5($faker->word),
    ];
});