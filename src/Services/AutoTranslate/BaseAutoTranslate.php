<?php

namespace Belt\Core\Services\AutoTranslate;

use Belt;

/**
 * Class BaseAutoTranslate
 * @package Belt\Core\Services
 */
abstract class BaseAutoTranslate
{
    public $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    abstract function translate($text, $target_locale, $source_locale);

}