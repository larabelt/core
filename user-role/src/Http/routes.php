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
        Route::put('/user-roles/{id}', UserRole\Http\Controllers\ApiController::class . '@update');
        Route::delete('/user-roles/{id}', UserRole\Http\Controllers\ApiController::class . '@destroy');
        Route::get('/user-roles', UserRole\Http\Controllers\ApiController::class . '@index');
        Route::post('/user-roles', UserRole\Http\Controllers\ApiController::class . '@store');
    }
);

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web']
],
    function () {
            Route::get('/user-roles/{id}', UserRole\Http\Controllers\AdminController::class . '@show');
            Route::get('/user-roles', UserRole\Http\Controllers\AdminController::class . '@index');
            Route::get('/user-roles-vue', UserRole\Http\Controllers\AdminController::class . '@indexVue');
    }
);