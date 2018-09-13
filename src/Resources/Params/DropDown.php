<?php

namespace Belt\Core\Resources\Params;

use Belt;

/**
 * Class DropDown
 * @package Belt\Core\Resources\Params
 */
class DropDown extends Belt\Core\Resources\BaseParam
{
    protected $type = 'select';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['options'] = $this->getOptions();

        return $array;
    }

}