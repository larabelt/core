<?php

namespace Belt\Core\Resources;

use Belt, Illuminate;

/**
 * Class BaseParam
 * @package Belt\Core\Resources\Params
 */
abstract class BaseParam extends Belt\Core\Resources\BaseResource
{

    use Belt\Core\Resources\Traits\HasGroup;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type = '')
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array|mixed
     */
    public function toArray()
    {
        return [
            'group' => $this->getGroup(),
            'type' => $this->getType(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }
}