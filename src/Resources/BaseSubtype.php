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
        Belt\Core\Resources\Traits\HasParamGroups;

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

    /**
     * @var boolean
     */
    protected $force_compile = false;

    /**
     * @var boolean
     */
    protected $sectionable = false;

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
     * @return bool
     */
    public function isForceCompile()
    {
        return $this->force_compile;
    }

    /**
     * @param bool $force_compile
     * @return $this
     */
    public function setForceCompile($force_compile)
    {
        $this->force_compile = $force_compile;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSectionable()
    {
        return $this->sectionable;
    }

    /**
     * @param bool $sectionable
     * @return $this
     */
    public function setSectionable($sectionable)
    {
        $this->sectionable = $sectionable;

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
            'force_compile' => $this->isForceCompile(),
            'sectionable' => $this->isSectionable(),
            'param_groups' => $this->getParamGroups()->toArray(),
            'params' => $this->getParams()->toArray(),
        ];
    }


}