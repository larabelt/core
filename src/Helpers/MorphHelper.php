<?php
namespace Belt\Core\Helpers;

use Illuminate\Database\Eloquent\Relations\Relation;

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
     * @return mixed
     */
    public function type2Class($type)
    {
        return array_get($this->map(), $type);
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
        $class = $this->type2Class($type);

        return $class ? $class::find($id) : null;
    }

}