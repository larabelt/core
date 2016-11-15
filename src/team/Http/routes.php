<?php

use Ohio\Core\Team\Http\Controllers;

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
    //Route::get('register', Controllers\Auth\RegisterController::class . '@showRegistrationForm');
    //Route::post('register', Controllers\Auth\RegisterController::class . '@register');
});

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