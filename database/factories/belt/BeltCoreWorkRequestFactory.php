<?php

$factory->define(Belt\Core\WorkRequest::class, function (Faker\Generator $faker, $params = []) {

    $workable = array_get($params, 'workable', factory(Belt\Core\Team::class)->make());

    return [
        'is_open' => true,
        'workable_id' => $workable->id,
        'workable_type' => $workable->getMorphClass(),
    ];
});