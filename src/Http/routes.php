<?php

/*
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('core::front.home');
    });
});