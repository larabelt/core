<?php

namespace Belt\Core\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class MorphHelper
 * @package Belt\Core\Helpers
 */
class MorphHelper
{

    /**
     * @var array
     */
    public static $map = [];

    /**
     * @return array
     */
    public function map()
    {
        return static::$map ?: static::$map = Relation::morphMap(null, false);
    }

    /**
     * Convert morphable type to actual class
     *
     * @param $type
     * @return Model
     */
    public function type2Class($type)
    {
        return array_get($this->map(), $type);
    }

    /**
     * Convert morphable type to actual query builder object
     *
     * @param $type
     * @return Builder
     */
    public function type2QB($type)
    {
        $class = $this->type2Class($type);

        return (new $class())->newQuery();
    }

    /**
     * Load morphable item
     *
     * @param $type
     * @param $id
     * @return null
     */
    public function morph($type, $id)
    {
        $qb = $this->type2QB($type);

        return $qb ? $qb->find($id) : null;
    }

}