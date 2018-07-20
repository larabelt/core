<?php

use Belt\Core\Http\Controllers\Api;

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        # access
        Route::group([
            'prefix' => '{entity_type}/{entity_id}/access',
            'middleware' => 'request.injections:entity_type,entity_id',
        ], function () {
            Route::get('{abilities}/{arguments}', Api\AccessController::class . '@show');
        });

        # index
        Route::get('index', Api\IndexController::class . '@index');

        # paramables
        Route::group([
            'prefix' => '{paramable_type}/{paramable_id}/params',
            'middleware' => 'request.injections:paramable_type,paramable_id',
        ], function () {
            Route::get('{id}', Api\ParamablesController::class . '@show');
            Route::put('{id}', Api\ParamablesController::class . '@update');
            Route::delete('{id}', Api\ParamablesController::class . '@destroy');
            Route::get('', Api\ParamablesController::class . '@index');
            Route::post('', Api\ParamablesController::class . '@store');
        });

        # abilities
        Route::get('abilities/{id}', Api\AbilitiesController::class . '@show');
        Route::put('abilities/{id}', Api\AbilitiesController::class . '@update');
        Route::delete('abilities/{id}', Api\AbilitiesController::class . '@destroy');
        Route::get('abilities', Api\AbilitiesController::class . '@index');
        Route::post('abilities', Api\AbilitiesController::class . '@store');

        # forms
        Route::get('forms/{form}', Api\FormsController::class . '@show');
        Route::post('forms', Api\FormsController::class . '@store');
        Route::put('forms/{form}', Api\FormsController::class . '@update');

        # roles
        Route::get('roles/{id}', Api\RolesController::class . '@show');
        Route::put('roles/{id}', Api\RolesController::class . '@update');
        Route::delete('roles/{id}', Api\RolesController::class . '@destroy');
        Route::get('roles', Api\RolesController::class . '@index');
        Route::post('roles', Api\RolesController::class . '@store');

        # team-users
        Route::group(['prefix' => 'teams/{team_id}/users'], function () {
            Route::get('{id}', Api\TeamUsersController::class . '@show');
            Route::delete('{id}', Api\TeamUsersController::class . '@destroy');
            Route::get('', Api\TeamUsersController::class . '@index');
            Route::post('', Api\TeamUsersController::class . '@store');
        });

        # teams
        Route::get('teams/{id}', Api\TeamsController::class . '@show');
        Route::put('teams/{id}', Api\TeamsController::class . '@update');
        Route::delete('teams/{id}', Api\TeamsController::class . '@destroy');
        Route::get('teams', Api\TeamsController::class . '@index');
        Route::post('teams', Api\TeamsController::class . '@store');

        # assigned roles
        Route::group([
            'prefix' => '{subject_type}/{subject_id}/roles',
            'middleware' => 'request.injections:subject_type,subject_id',
        ], function () {
            Route::get('{role}', Api\AssignedRolesController::class . '@show');
            Route::delete('{role}', Api\AssignedRolesController::class . '@destroy');
            Route::get('', Api\AssignedRolesController::class . '@index');
            Route::post('', Api\AssignedRolesController::class . '@store');
        });

        # permissions
        Route::group([
            'prefix' => '{entity_type}/{entity_id}/permissions',
            'middleware' => 'request.injections:entity_type,entity_id',
        ], function () {
            Route::get('{ability_id}', Api\PermissionsController::class . '@show');
            Route::delete('{ability_id}', Api\PermissionsController::class . '@destroy');
            Route::get('', Api\PermissionsController::class . '@index');
            Route::post('', Api\PermissionsController::class . '@store');
        });

        # users
        Route::get('users/{user}', Api\UsersController::class . '@show');
        Route::put('users/{user}', Api\UsersController::class . '@update');
        Route::delete('users/{user}', Api\UsersController::class . '@destroy');
        Route::get('users', Api\UsersController::class . '@index');
        Route::post('users', Api\UsersController::class . '@store');
    }
);
