<?php

namespace Belt\Core\Resources\Subtypes;

use Belt;
use Illuminate\Support\Collection;

/**
 * Class BaseParam
 * @package Belt\Core\Resources\Params
 */
class BaseListItem extends Belt\Core\Resources\BaseSubtype
{
    use Belt\Core\Resources\Traits\HasTile;

    /**
     * @return mixed
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['tile'] = $this->getTile();

        return $array;
    }
}