<?php

namespace Belt\Core\Behaviors;

/**
 * Class CanEnable
 * @package Belt\Core\Behaviors
 */
trait CanEnable
{
    /**
     * @var bool
     */
    protected static $enabled = false;

    /**
     * Enable service
     */
    public static function enable()
    {
        self::$enabled = true;
    }

    /**
     * Disable service
     */
    public static function disable()
    {
        self::$enabled = false;
    }

    /**
     * Check if service is enabled
     */
    public static function isEnabled()
    {
        return self::$enabled;
    }
}