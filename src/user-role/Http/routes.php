<?php

use Ohio\Core\UserRole;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {
        Route::get('/user-roles/{id}', UserRole\Http\Controllers\ApiController::class . '@show');
        Route::delete('/user-roles/{id}', UserRole\Http\Controllers\ApiController::class . '@destroy');
        Route::get('/user-roles', UserRole\Http\Controllers\ApiController::class . '@index');
        Route::post('/user-roles', UserRole\Http\Controllers\ApiController::class . '@store');
    }
);