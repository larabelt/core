<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasSectionable
 * @package Belt\Core\Resources\Traits
 */
trait HasSectionable
{
    /**
     * @var boolean
     */
    protected $sectionable = false;

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

}