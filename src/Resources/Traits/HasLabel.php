<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasLabel
 * @package Belt\Core\Resources\Traits
 */
trait HasLabel
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label = '')
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label ?: title_case(str_replace(['-', '_'], ' ', $this->getKey()));
    }

}