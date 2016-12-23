<?php

use Ohio\Core\User\Http\Controllers;

/**
 * Front
 */
Route::group(['middleware' => ['web', 'guest']], function () {
    Route::get('login', Controllers\Auth\LoginController::class . '@showLoginForm');
    Route::post('login', Controllers\Auth\LoginController::class . '@login');
});

/**
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('logout', Controllers\Auth\LoginController::class . '@logout');
    Route::post('logout', Controllers\Auth\LoginController::class . '@logout');
    Route::post('password/email', Controllers\Auth\ForgotPasswordController::class . '@sendResetLinkEmail');
    Route::get('password/reset', Controllers\Auth\ForgotPasswordController::class . '@showLinkRequestForm');
    Route::post('password/reset', Controllers\Auth\ResetPasswordController::class . '@reset');
    Route::get('password/reset/{token}', Controllers\Auth\ResetPasswordController::class . '@showResetForm');
});

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        Route::group(['prefix' => 'users/{user_id}/roles'], function () {
            Route::get('{id}', Controllers\Api\RolesController::class . '@show');
            Route::delete('{id}', Controllers\Api\RolesController::class . '@destroy');
            Route::get('', Controllers\Api\RolesController::class . '@index');
            Route::post('', Controllers\Api\RolesController::class . '@store');
        });

        Route::get('users/{id}', Controllers\Api\UsersController::class . '@show');
        Route::put('users/{id}', Controllers\Api\UsersController::class . '@update');
        Route::delete('users/{id}', Controllers\Api\UsersController::class . '@destroy');
        Route::get('users', Controllers\Api\UsersController::class . '@index');
        Route::post('users', Controllers\Api\UsersController::class . '@store');
    }
);