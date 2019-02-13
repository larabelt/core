<?php

$factory->define(Belt\Core\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'mi' => $faker->randomLetter,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'created_at' => date('Y-m-d H:i:s'),
    ];
});