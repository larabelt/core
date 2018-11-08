<?php

namespace Belt\Core\Resources;

use Belt;
use Illuminate\Support\Collection;

/**
 * Class BaseParam
 * @package Belt\Core\Resources\Params
 */
abstract class BaseSubtype extends Belt\Core\Resources\BaseResource
{
    use Belt\Core\Resources\Traits\HasParams,
        Belt\Core\Resources\Traits\HasParamGroups,
        Belt\Core\Resources\Traits\HasTranslatable;

    /**
     * @var string
     */
    protected $extends;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $builder;

    /**
     * @var string
     */
    protected $preview;

    public function setup()
    {
        $this->makeParams();
        $this->makeParamGroups();
    }

    /**
     * @return string
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param string $builder
     * @return $this
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param string $preview
     * @return $this
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param $extends
     * @return $this
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

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
            'extends' => $this->getExtends(),
            'path' => $this->getPath(),
            'builder' => $this->getBuilder(),
            'preview' => $this->getPreview(),
            'translatable' => $this->getTranslatable() ?: [],
            'param_groups' => $this->getParamGroups()->toArray(),
            'params' => $this->getParams()->toArray(),
        ];
    }


}