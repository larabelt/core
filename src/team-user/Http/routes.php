<?php

use Ohio\Core\TeamUser;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {
        Route::get('/team-users/{id}', TeamUser\Http\Controllers\ApiController::class . '@show');
        Route::delete('/team-users/{id}', TeamUser\Http\Controllers\ApiController::class . '@destroy');
        Route::get('/team-users', TeamUser\Http\Controllers\ApiController::class . '@index');
        Route::post('/team-users', TeamUser\Http\Controllers\ApiController::class . '@store');
    }
);