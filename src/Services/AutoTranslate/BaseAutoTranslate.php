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

    public function split($text, $size = 1000)
    {
        $sections = [];

        $helper = new Belt\Core\Services\AutoTranslate\Helpers\Sentence();

        $elements = $helper->split($text);

        foreach ($elements as $n => $element) {
            $section = isset($section) ? $section : '';
            $section .= $element;
            if (strlen($section) >= $size) {
                $sections[] = $section;
                unset($section);
            }
        }

        if (isset($section)) {
            $sections[] = $section;
        }

        return $sections;
    }

}