<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasDescription
 * @package Belt\Core\Resources\Traits
 */
trait HasDescription
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description = '')
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}