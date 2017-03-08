<?php

use Belt\Core;

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        # params
        Route::group([
            'prefix' => '{paramable_type}/{paramable_id}/params',
            'middleware' => 'request.injections:paramable_type,paramable_id',
        ], function () {
            Route::get('{id}', Core\Http\Controllers\Api\ParamsController::class . '@show');
            Route::put('{id}', Core\Http\Controllers\Api\ParamsController::class . '@update');
            Route::delete('{id}', Core\Http\Controllers\Api\ParamsController::class . '@destroy');
            Route::get('', Core\Http\Controllers\Api\ParamsController::class . '@index');
            Route::post('', Core\Http\Controllers\Api\ParamsController::class . '@store');
        });

        # roles
        Route::get('roles/{id}', Core\Http\Controllers\Api\RolesController::class . '@show');
        Route::put('roles/{id}', Core\Http\Controllers\Api\RolesController::class . '@update');
        Route::delete('roles/{id}', Core\Http\Controllers\Api\RolesController::class . '@destroy');
        Route::get('roles', Core\Http\Controllers\Api\RolesController::class . '@index');
        Route::post('roles', Core\Http\Controllers\Api\RolesController::class . '@store');

        # team-users
        Route::group(['prefix' => 'teams/{team_id}/users'], function () {
            Route::get('{id}', Core\Http\Controllers\Api\TeamUsersController::class . '@show');
            Route::delete('{id}', Core\Http\Controllers\Api\TeamUsersController::class . '@destroy');
            Route::get('', Core\Http\Controllers\Api\TeamUsersController::class . '@index');
            Route::post('', Core\Http\Controllers\Api\TeamUsersController::class . '@store');
        });

        # teams
        Route::get('teams/{id}', Core\Http\Controllers\Api\TeamsController::class . '@show');
        Route::put('teams/{id}', Core\Http\Controllers\Api\TeamsController::class . '@update');
        Route::delete('teams/{id}', Core\Http\Controllers\Api\TeamsController::class . '@destroy');
        Route::get('teams', Core\Http\Controllers\Api\TeamsController::class . '@index');
        Route::post('teams', Core\Http\Controllers\Api\TeamsController::class . '@store');

        # user-roles
        Route::group(['prefix' => 'users/{user_id}/roles'], function () {
            Route::get('{id}', Core\Http\Controllers\Api\UserRolesController::class . '@show');
            Route::delete('{id}', Core\Http\Controllers\Api\UserRolesController::class . '@destroy');
            Route::get('', Core\Http\Controllers\Api\UserRolesController::class . '@index');
            Route::post('', Core\Http\Controllers\Api\UserRolesController::class . '@store');
        });

        # users
        Route::get('users/{id}', Core\Http\Controllers\Api\UsersController::class . '@show');
        Route::put('users/{id}', Core\Http\Controllers\Api\UsersController::class . '@update');
        Route::delete('users/{id}', Core\Http\Controllers\Api\UsersController::class . '@destroy');
        Route::get('users', Core\Http\Controllers\Api\UsersController::class . '@index');
        Route::post('users', Core\Http\Controllers\Api\UsersController::class . '@store');
    }
);
