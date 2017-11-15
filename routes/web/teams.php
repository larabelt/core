<?php

use Belt\Core\Http\Controllers;

Route::group([
    'prefix' => 'teams',
    'middleware' => ['web'],
], function () {

    Route::get('signup', Controllers\Web\TeamsController::class . '@signup');
    Route::get('welcome', Controllers\Web\TeamsController::class . '@welcome');

});