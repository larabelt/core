<?php

Route::group([
    'prefix' => config('larecipe.docs.route'),
    'middleware' => 'web'
], function () {

    //http://2.0.larabelt.test/docs/preview/core/2.0/admin/sidebars.access-expanded

    Route::get('/preview/{package}/{version}/{subtype}/{path}', function ($package, $version, $subtype, $path) {
        return view("belt-core::docs.partials.preview", [
            'package' => $package,
            'subtype' => $subtype,
            'version' => str_replace('.', '', $version),
            'path' => $path,
        ]);
    })->where('path', '(.*)');
});

Route::group([
    'prefix' => config('larecipe.docs.route'),
    'namespace' => 'BinaryTorch\LaRecipe\Http\Controllers',
    'as' => 'larecipe.',
    'middleware' => 'web'
], function () {
    Route::get('/{version}/{path?}', 'DocumentationController@show')->where('path', '(.*)')->name('show');
    Route::get('/', 'DocumentationController@index')->name('index');
});