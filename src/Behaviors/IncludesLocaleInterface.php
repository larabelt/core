<?php

namespace Belt\Core\Behaviors;

/**
 * Interface IncludesLocaleInterface
 * @package Belt\Core\Behaviors
 */
interface IncludesLocaleInterface
{

    /**
     * @param $value
     */
    public function setLocaleAttribute($value);

    /**
     * @param $value
     *
     * @return string
     */
    public function getLocaleAttribute($value);

}