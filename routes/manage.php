<?php

Route::group([
    'prefix' => 'home',
    'middleware' => ['web', 'auth'],
    //'middleware' => ['web'],
],
    function () {
        Route::get('', function () {
            return view('belt-core::layouts.admin-user.index');
        });
    }
);