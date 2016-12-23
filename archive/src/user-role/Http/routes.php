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
        Route::get('user-roles/{id}', UserRole\Http\Controllers\Api\UserRolesController::class . '@show');
        Route::delete('user-roles/{id}', UserRole\Http\Controllers\Api\UserRolesController::class . '@destroy');
        Route::get('user-roles', UserRole\Http\Controllers\Api\UserRolesController::class . '@index');
        Route::post('user-roles', UserRole\Http\Controllers\Api\UserRolesController::class . '@store');
    }
);