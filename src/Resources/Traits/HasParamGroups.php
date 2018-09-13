<?php

namespace Belt\Core\Resources\Traits;

use Belt\Core\Resources\BaseParam;
use Belt\Core\Resources\BaseParamGroup;
use Belt\Core\Resources\ParamGroups\ParamGroupDefault;
use Illuminate\Support\Collection;

/**
 * Trait HasParamGroup
 * @package Belt\Core\Resources\Traits
 */
trait HasParamGroups
{
    /**
     * @var Collection
     */
    protected $paramGroups;

    /**
     * @param Collection $paramGroups
     * @return $this
     */
    public function setParamGroups(Collection $paramGroups)
    {
        $this->paramGroups = $paramGroups;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getParamGroups()
    {
        return $this->paramGroups ?: $this->paramGroups = new Collection();
    }

    /**
     * @param BaseParamGroup $paramGroup
     * @return $this
     */
    public function pushParamGroup(BaseParamGroup $paramGroup)
    {
        $this->getParamGroups()->put($paramGroup->getKey(), $paramGroup);

        return $this;
    }

    /**
     * @return $this
     */
    public function makeParamGroups()
    {
        foreach ($this->params() as $param) {
            if ($param instanceof BaseParamGroup) {
                $this->pushParamGroup($param);
            }
        }

        foreach ($this->params() as $param) {
            if ($param instanceof BaseParam) {
                if ($group = $param->getGroup()) {
                    if (!$this->getParamGroups()->has($group)) {
                        $paramGroup = ParamGroupDefault::make($group);
                        $this->pushParamGroup($paramGroup);
                    }
                }
            }
        }

        return $this;
    }

}