<?php

namespace Belt\Core\Behaviors;

/**
 * Class TypeTrait
 * @package Belt\Core\Behaviors
 */
trait TypeTrait
{
    public function getTypeAttribute()
    {
        return $this->getTable();
    }

    public function getMorphClassAttribute()
    {
        return $this->getMorphClass();
    }
}