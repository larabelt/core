<?php

use Belt\Core;
use Illuminate\Http\Request;

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