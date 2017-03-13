<?php

use Belt\Core\Http\Controllers;

Route::group(['middleware' => ['web']], function () {

    # login / logout
    Route::get('login', Controllers\Auth\LoginController::class . '@showLoginForm');
    Route::post('login', Controllers\Auth\LoginController::class . '@login');
    Route::get('logout', Controllers\Auth\LoginController::class . '@logout');
    Route::post('logout', Controllers\Auth\LoginController::class . '@logout');

    # password recovery
    Route::post('password/email', Controllers\Auth\ForgotPasswordController::class . '@sendResetLinkEmail');
    Route::get('password/reset', Controllers\Auth\ForgotPasswordController::class . '@showLinkRequestForm');
    Route::post('password/reset', Controllers\Auth\ResetPasswordController::class . '@reset');
    Route::get('password/reset/{token}', Controllers\Auth\ResetPasswordController::class . '@showResetForm');

    # home
    Route::get('', function () {
        return view('belt-core::base.web.home');
    });

    # debug
    if (env('APP_ENV') == 'local') {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    }
});