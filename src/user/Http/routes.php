<?php

use Ohio\Core\User;

/**
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('login', \Ohio\Core\User\Http\Controllers\Auth\AuthController::class . '@getLogin');
    Route::post('login', \Ohio\Core\User\Http\Controllers\Auth\AuthController::class . '@postLogin');
    Route::get('logout', \Ohio\Core\User\Http\Controllers\Auth\AuthController::class . '@getLogout');
});

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {
        Route::get('/users/{id}', User\Http\Controllers\ApiController::class . '@show');
        Route::put('/users/{id}', User\Http\Controllers\ApiController::class . '@update');
        Route::delete('/users/{id}', User\Http\Controllers\ApiController::class . '@destroy');
        Route::get('/users', User\Http\Controllers\ApiController::class . '@index');
        Route::post('/users', User\Http\Controllers\ApiController::class . '@store');
    }
);

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web']
],
    function () {
            Route::get('/users/{id}', User\Http\Controllers\AdminController::class . '@show');
            Route::get('/users', User\Http\Controllers\AdminController::class . '@index');
    }
);