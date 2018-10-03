<?php

namespace Belt\Core\Resources\Traits;

/**
 * Trait HasTile
 * @package Belt\Core\Resources\Traits
 */
trait HasTile
{
    /**
     * @var string
     */
    protected $tile;

    /**
     * @param string $tile
     * @return $this
     */
    public function setTile($tile = '')
    {
        $this->tile = $tile;

        return $this;
    }

    /**
     * @return string
     */
    public function getTile()
    {
        return $this->tile;
    }

}