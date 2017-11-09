<?php

namespace Belt\Core\Behaviors;

/**
 * Class PriorityTrait
 * @package Belt\Core\Behaviors
 */
trait PriorityTrait
{
    /**
     * Set priority value
     */
    public function setPriorityAttribute($value)
    {
        $this->attributes['priority'] = intval($value);
    }

}