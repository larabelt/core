<?php

Route::get('/js/lang.js', function () {

    $locale = Lang::getLocale();
    $loader = Lang::getLoader();

    $trans = [];

    foreach (app('belt')->packages() as $name => $package) {
        $namespace = sprintf('belt-%s', $name);
        $files = glob(sprintf('%s/resources/lang/%s/*.php', $package['dir'], $locale));
        foreach ($files as $file) {
            $group = basename($file, '.php');
            $trans[$namespace][$group] = $loader->load($locale, $group, $namespace);
        }
    }

    $js = sprintf('window.i18n = %s;', json_encode($trans));

    return response($js, 200, ['Content-Type' => 'text/javascript']);
})->name('belt.lang');