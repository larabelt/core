<?php

/*
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('login', \Ohio\Core\Base\Http\Controllers\Auth\AuthController::class . '@getLogin');
    Route::post('login', \Ohio\Core\Base\Http\Controllers\Auth\AuthController::class . '@postLogin');
    Route::get('logout', \Ohio\Core\Base\Http\Controllers\Auth\AuthController::class . '@getLogout');
    Route::get('/', function () {
        return view('core::front.home');
    });
});

/*
 * Admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth.admin']
],
    function () {
        Route::get('/', \Ohio\Core\Base\Http\Controllers\AdminController::class . '@getIndex');
        Route::get('/ohio/core', function () {
            return view('layouts::admin.dashboard2');
        });
    }
);

/*
 * Admin-User
 */
Route::group([
    'prefix' => 'admin-user',
    'middleware' => ['web']
],
    function () {
        Route::get('/', \Ohio\Core\Base\Http\Controllers\AdminUserController::class . '@getIndex');
    }
);