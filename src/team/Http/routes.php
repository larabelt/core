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
        Route::get('/teams/{id}', Controllers\ApiController::class . '@show');
        Route::put('/teams/{id}', Controllers\ApiController::class . '@update');
        Route::delete('/teams/{id}', Controllers\ApiController::class . '@destroy');
        Route::get('/teams', Controllers\ApiController::class . '@index');
        Route::post('/teams', Controllers\ApiController::class . '@store');
    }
);