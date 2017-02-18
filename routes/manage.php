<?php

Route::group([
    'prefix' => 'home',
    'middleware' => ['web', 'auth']
],
    function () {
        Route::get('', function () {
            return view('belt-core::layouts.admin-user.index');
        });
    }
);