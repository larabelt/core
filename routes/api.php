<?php

use Ohio\Core;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['web', 'auth', 'api']
],
    function () {

        # roles
        Route::get('roles/{id}', Core\Role\Http\Controllers\Api\RolesController::class . '@show');
        Route::put('roles/{id}', Core\Role\Http\Controllers\Api\RolesController::class . '@update');
        Route::delete('roles/{id}', Core\Role\Http\Controllers\Api\RolesController::class . '@destroy');
        Route::get('roles', Core\Role\Http\Controllers\Api\RolesController::class . '@index');
        Route::post('roles', Core\Role\Http\Controllers\Api\RolesController::class . '@store');

        # team-users
        Route::group(['prefix' => 'teams/{team_id}/users'], function () {
            Route::get('{id}', Core\Team\Http\Controllers\Api\UsersController::class . '@show');
            Route::delete('{id}', Core\Team\Http\Controllers\Api\UsersController::class . '@destroy');
            Route::get('', Core\Team\Http\Controllers\Api\UsersController::class . '@index');
            Route::post('', Core\Team\Http\Controllers\Api\UsersController::class . '@store');
        });

        # teams
        Route::get('teams/{id}', Core\Team\Http\Controllers\Api\TeamsController::class . '@show');
        Route::put('teams/{id}', Core\Team\Http\Controllers\Api\TeamsController::class . '@update');
        Route::delete('teams/{id}', Core\Team\Http\Controllers\Api\TeamsController::class . '@destroy');
        Route::get('teams', Core\Team\Http\Controllers\Api\TeamsController::class . '@index');
        Route::post('teams', Core\Team\Http\Controllers\Api\TeamsController::class . '@store');

        # user-roles
        Route::group(['prefix' => 'users/{user_id}/roles'], function () {
            Route::get('{id}', Core\User\Http\Controllers\Api\RolesController::class . '@show');
            Route::delete('{id}', Core\User\Http\Controllers\Api\RolesController::class . '@destroy');
            Route::get('', Core\User\Http\Controllers\Api\RolesController::class . '@index');
            Route::post('', Core\User\Http\Controllers\Api\RolesController::class . '@store');
        });

        # users
        Route::get('users/{id}', Core\User\Http\Controllers\Api\UsersController::class . '@show');
        Route::put('users/{id}', Core\User\Http\Controllers\Api\UsersController::class . '@update');
        Route::delete('users/{id}', Core\User\Http\Controllers\Api\UsersController::class . '@destroy');
        Route::get('users', Core\User\Http\Controllers\Api\UsersController::class . '@index');
        Route::post('users', Core\User\Http\Controllers\Api\UsersController::class . '@store');
    }
);
