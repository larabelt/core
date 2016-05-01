<?php

Route::get('/', function () {
    return view('base::front.home');
});

Route::group(
    [
        //'middleware' => 'auth.admin',
        'prefix' => 'admin',
    ],
    function () {
        Route::get('/', function () {
            return view('base::admin.home');
        });
    }
);