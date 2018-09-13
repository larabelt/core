<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasGroup
 * @package Belt\Core\Resources\Traits
 */
trait HasGroup
{
    /**
     * @var string
     */
    protected $group;

    /**
     * @param string $group
     * @return $this
     */
    public function setGroup($group = '')
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

}