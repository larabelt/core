<?php

use Belt\Core;

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
    Route::get('login', Core\Http\Controllers\Auth\LoginController::class . '@showLoginForm');
    Route::post('login', Core\Http\Controllers\Auth\LoginController::class . '@login');
    Route::get('logout', Core\Http\Controllers\Auth\LoginController::class . '@logout');
    Route::post('logout', Core\Http\Controllers\Auth\LoginController::class . '@logout');

    # password recovery
    Route::post('password/email', Core\Http\Controllers\Auth\ForgotPasswordController::class . '@sendResetLinkEmail');
    Route::get('password/reset', Core\Http\Controllers\Auth\ForgotPasswordController::class . '@showLinkRequestForm');
    Route::post('password/reset', Core\Http\Controllers\Auth\ResetPasswordController::class . '@reset');
    Route::get('password/reset/{token}', Core\Http\Controllers\Auth\ResetPasswordController::class . '@showResetForm');

    # home
    Route::get('', function () {
        return view('belt-core::base.web.home');
    });

    # debug
    if (env('APP_ENV') == 'local') {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    }
});