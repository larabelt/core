<?php

use Belt\Core;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth']
],
    function () {

        # admin/belt/core home
        Route::get('belt/core/{any?}', function () {
            return view('belt-core::base.admin.dashboard');
        })->where('any', '(.*)');

        # admin home
        Route::get('', function () {
            return view('belt-core::base.admin.dashboard');
        });
    }
);