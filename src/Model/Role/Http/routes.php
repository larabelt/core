<?php

use Ohio\Core\Model\Role;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {
        Route::get('/roles/{id}', Role\Http\Controllers\ApiController::class . '@show');
        Route::put('/roles/{id}', Role\Http\Controllers\ApiController::class . '@update');
        Route::delete('/roles/{id}', Role\Http\Controllers\ApiController::class . '@destroy');
        Route::get('/roles', Role\Http\Controllers\ApiController::class . '@index');
        Route::post('/roles', Role\Http\Controllers\ApiController::class . '@store');
    }
);

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web']
],
    function () {
            Route::get('/roles/{id}', Role\Http\Controllers\AdminController::class . '@show');
            Route::get('/roles', Role\Http\Controllers\AdminController::class . '@index');
            Route::get('/roles-vue', Role\Http\Controllers\AdminController::class . '@indexVue');
    }
);