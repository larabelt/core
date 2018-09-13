<?php

namespace Belt\Core\Resources;

use Belt;

/**
 * Class BaseParam
 * @package Belt\Core\Resources\Params
 */
abstract class BaseParamGroup extends Belt\Core\Resources\BaseResource
{
    use Belt\Core\Resources\Traits\HasParams, Belt\Core\Resources\Traits\HasGroup;

    /**
     * @var bool
     */
    protected $collapsible = true;

    /**
     * @var bool
     */
    protected $collapsed = true;

    /**
     * @var string
     */
    protected $component;

    public function setup()
    {
        $this->makeParams();
    }

    /**
     * @return mixed
     */
    public function getCollapsible()
    {
        return $this->collapsible;
    }

    /**
     * @param $collapsible
     * @return $this
     */
    public function setCollapsible($collapsible)
    {
        $this->collapsible = $collapsible;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollapsed()
    {
        return $this->collapsed;
    }

    /**
     * @param $collapsed
     * @return $this
     */
    public function setCollapsed($collapsed)
    {
        $this->collapsed = $collapsed;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param $component
     * @return $this
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'collapsible' => $this->getCollapsible(),
            'collapsed' => $this->getCollapsed(),
            'component' => $this->getComponent(),
        ];
    }

}