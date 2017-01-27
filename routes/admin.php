<?php

use Ohio\Core;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth']
],
    function () {

        # admin/ohio/core home
        Route::get('ohio/core/{any?}', function () {
            return view('ohio-core::base.admin.dashboard');
        })->where('any', '(.*)');

        # admin home
        Route::get('', function () {
            return view('ohio-core::base.admin.dashboard');
        });
    }
);