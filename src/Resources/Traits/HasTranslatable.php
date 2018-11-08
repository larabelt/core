<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasTranslatable
 * @package Belt\Core\Resources\Traits
 */
trait HasTranslatable
{
    /**
     * @var boolean
     */
    protected $translatable;

    /**
     * @return mixed
     */
    public function getTranslatable()
    {
        return $this->translatable;
    }

    /**
     * @param bool $translatable
     * @return $this
     */
    public function setTranslatable($translatable)
    {
        $this->translatable = $translatable;

        return $this;
    }

}