<?php

use Ohio\Core;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function () {

    # login / logout
    Route::get('login', Core\User\Http\Controllers\Auth\LoginController::class . '@showLoginForm');
    Route::post('login', Core\User\Http\Controllers\Auth\LoginController::class . '@login');
    Route::get('logout', Core\User\Http\Controllers\Auth\LoginController::class . '@logout');
    Route::post('logout', Core\User\Http\Controllers\Auth\LoginController::class . '@logout');

    # password recovery
    Route::post('password/email', Core\User\Http\Controllers\Auth\ForgotPasswordController::class . '@sendResetLinkEmail');
    Route::get('password/reset', Core\User\Http\Controllers\Auth\ForgotPasswordController::class . '@showLinkRequestForm');
    Route::post('password/reset', Core\User\Http\Controllers\Auth\ResetPasswordController::class . '@reset');
    Route::get('password/reset/{token}', Core\User\Http\Controllers\Auth\ResetPasswordController::class . '@showResetForm');

    # home
    Route::get('', function () {
        return view('ohio-core::base.front.home');
    });
});