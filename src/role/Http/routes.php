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
        Route::get('roles/{id}', Role\Http\Controllers\Api\RolesController::class . '@show');
        Route::put('roles/{id}', Role\Http\Controllers\Api\RolesController::class . '@update');
        Route::delete('roles/{id}', Role\Http\Controllers\Api\RolesController::class . '@destroy');
        Route::get('roles', Role\Http\Controllers\Api\RolesController::class . '@index');
        Route::post('roles', Role\Http\Controllers\Api\RolesController::class . '@store');
    }
);