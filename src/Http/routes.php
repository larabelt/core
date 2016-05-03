<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        return view('base::front.home');
    });
});

Route::group(['prefix' => 'admin', ['middleware' => 'web']],
    function () {
        Route::get('/', \Ohio\Base\Http\Controllers\AdminController::class . '@getIndex');
    }
);