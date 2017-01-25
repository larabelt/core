<?php

use Ohio\Core\Team\Http\Controllers;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['ohio.api.admin']
],
    function () {

        # team-users
        Route::group(['prefix' => 'teams/{team_id}/users'], function () {
            Route::get('{id}', Controllers\Api\UsersController::class . '@show');
            Route::delete('{id}', Controllers\Api\UsersController::class . '@destroy');
            Route::get('', Controllers\Api\UsersController::class . '@index');
            Route::post('', Controllers\Api\UsersController::class . '@store');
        });

        # teams
        Route::get('teams/{id}', Controllers\Api\TeamsController::class . '@show');
        Route::put('teams/{id}', Controllers\Api\TeamsController::class . '@update');
        Route::delete('teams/{id}', Controllers\Api\TeamsController::class . '@destroy');
        Route::get('teams', Controllers\Api\TeamsController::class . '@index');
        Route::post('teams', Controllers\Api\TeamsController::class . '@store');
    }
);