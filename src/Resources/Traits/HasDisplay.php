<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasDisplay
 * @package Belt\Core\Resources\Traits
 */
trait HasDisplay
{
    /**
     * @var array
     */
    protected $display = [];

    /**
     * @param array $display
     * @return $this
     */
    public function setDisplay($display = [])
    {
        $this->display = $display;

        return $this;
    }

    /**
     * @return array
     */
    public function getDisplay()
    {
        return $this->display;
    }

}