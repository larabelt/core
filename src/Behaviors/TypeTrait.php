<?php

namespace Belt\Core\Behaviors;

/**
 * Class TypeTrait
 * @package Belt\Core\Behaviors
 */
trait TypeTrait
{
    /**
     * @deprecated
     * @return mixed
     */
    public function getTypeAttribute()
    {
        return $this->getTable();
    }

    /**
     * @return mixed
     */
    public function getMorphClassAttribute()
    {
        return $this->getMorphClass();
    }

}