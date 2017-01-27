<?php

use Ohio\Core;
use Illuminate\Http\Request;

Route::group([
    'prefix' => 'home',
    'middleware' => ['web', 'auth']
],
    function () {
        Route::get('', function () {
            return view('ohio-core::layouts.admin-user.index');
        });
    }
);