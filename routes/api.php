<?php

use Belt\Core\Http\Controllers\Api;

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        # alerts
        Route::get('alerts/{alert}', Api\AlertsController::class . '@show');
        Route::put('alerts/{alert}', Api\AlertsController::class . '@update');
        Route::delete('alerts/{alert}', Api\AlertsController::class . '@destroy');
        Route::get('alerts', Api\AlertsController::class . '@index');
        Route::post('alerts', Api\AlertsController::class . '@store');

        # contact
        Route::post('contact', Api\ContactController::class . '@store');

        # index
        Route::get('index', Api\IndexController::class . '@index');

        # params
        Route::get('param-keys', Api\ParamsController::class . '@keys');
        Route::get('param-values', Api\ParamsController::class . '@values');

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

        # user-roles
        Route::group(['prefix' => 'users/{user_id}/roles'], function () {
            Route::get('{id}', Api\UserRolesController::class . '@show');
            Route::delete('{id}', Api\UserRolesController::class . '@destroy');
            Route::get('', Api\UserRolesController::class . '@index');
            Route::post('', Api\UserRolesController::class . '@store');
        });

        # users
        Route::get('users/{user}', Api\UsersController::class . '@show');
        Route::put('users/{user}', Api\UsersController::class . '@update');
        Route::delete('users/{user}', Api\UsersController::class . '@destroy');
        Route::get('users', Api\UsersController::class . '@index');
        Route::post('users', Api\UsersController::class . '@store');
    }
);
