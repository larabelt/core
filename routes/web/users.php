<?php

use Belt\Core\Http\Controllers;

Route::group([
    'prefix' => 'users',
    'middleware' => ['web'],
], function () {

    Route::get('signup', Controllers\Web\UsersController::class . '@signup');
    Route::get('welcome', Controllers\Web\UsersController::class . '@welcome');

});