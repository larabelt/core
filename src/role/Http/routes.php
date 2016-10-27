<?php

use Ohio\Core\Role;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {
        Route::get('/roles/{id}', Role\Http\Controllers\ApiController::class . '@show');
        Route::put('/roles/{id}', Role\Http\Controllers\ApiController::class . '@update');
        Route::delete('/roles/{id}', Role\Http\Controllers\ApiController::class . '@destroy');
        Route::get('/roles', Role\Http\Controllers\ApiController::class . '@index');
        Route::post('/roles', Role\Http\Controllers\ApiController::class . '@store');
    }
);