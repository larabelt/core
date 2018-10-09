<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasForceCompile
 * @package Belt\Core\Resources\Traits
 */
trait HasForceCompile
{
    /**
     * @var boolean
     */
    protected $force_compile = false;

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

}