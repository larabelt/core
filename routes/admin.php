<?php

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'admin']
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