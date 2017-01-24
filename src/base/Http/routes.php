<?php

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['ohio.admin']
],
    function () {
        Route::get('', function () {
            return view('ohio-core::base.admin.dashboard');
        });
    }
);

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin/ohio/core',
    'middleware' => ['ohio.admin']
],
    function () {
        Route::get('{any?}', function () {
            return view('ohio-core::base.admin.dashboard');
        })->where('any', '(.*)');
    }
);

/**
 * Admin-User
 */
Route::group([
    'prefix' => 'home',
    'middleware' => ['ohio.web']
],
    function () {
        Route::get('', function () {
            return view('ohio-core::layouts.admin-user.index');
        });
    }
);

/**
 * Front
 */
Route::group(['middleware' => ['ohio.web']], function () {
    Route::get('', function () {
        return view('ohio-core::base.front.home');
    });
});