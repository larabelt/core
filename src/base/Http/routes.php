<?php

/**
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('ohio-core::base.front.home');
    });
});

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth.admin']
],
    function () {
        Route::get('/', function () {
            return view('ohio-core::base.admin.dashboard');
        });
    }
);

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin/ohio/core',
    'middleware' => ['web', 'auth.admin']
],
    function () {
        Route::get('{a?}/{b?}/{c?}', function () {
            return view('ohio-core::base.admin.dashboard');
        });
    }
);

/**
 * Admin-User
 */
Route::group([
    'prefix' => 'home',
    'middleware' => ['web']
],
    function () {
        Route::get('/', function () {
            return view('ohio-core::layouts.admin-user.index');
        });
    }
);

/**
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('ohio-core::base.front.home');
    });
});