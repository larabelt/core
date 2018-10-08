<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasDriver
 * @package Belt\Core\Resources\Traits
 */
trait HasDriver
{
    /**
     * @var string
     */
    protected $driver;

    /**
     * @param string $driver
     * @return $this
     */
    public function setDriver($driver = '')
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

}