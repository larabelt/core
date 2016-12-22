<?php

use Ohio\Core\Team\Http\Controllers;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        # team-users
        Route::get('teams/{id}/users', Controllers\Api\UsersController::class . '@index');
        Route::post('teams/{id}/users', Controllers\Api\UsersController::class . '@store');
        Route::delete('teams/{id}/users/{userID}', Controllers\Api\UsersController::class . '@destroy');

        # teams
        Route::get('teams/{id}', Controllers\Api\TeamsController::class . '@show');
        Route::put('teams/{id}', Controllers\Api\TeamsController::class . '@update');
        Route::delete('teams/{id}', Controllers\Api\TeamsController::class . '@destroy');
        Route::get('teams', Controllers\Api\TeamsController::class . '@index');
        Route::post('teams', Controllers\Api\TeamsController::class . '@store');
    }
);