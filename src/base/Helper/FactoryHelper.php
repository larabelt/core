<?php
namespace Ohio\Core\Base\Helper;

class FactoryHelper
{

    /**
     * @var array
     */
    public static $ids = [];

    /**
     * @var array
     */
    public static $images = [];

    /**
     * @return string
     */
    public static function popImage()
    {
        shuffle(static::$images);
        
        return array_pop(static::$images);
    }

}