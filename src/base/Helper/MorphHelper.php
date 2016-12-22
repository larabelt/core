<?php
namespace Ohio\Core\Base\Helper;

use Illuminate\Database\Eloquent\Relations\Relation;

class MorphHelper
{

    public static $map;

    public function map()
    {
        return static::$map ?: static::$map = Relation::morphMap(null, false);
    }

    public function type2Class($type)
    {
        $map = $this->map();

        if (isset($map[$type])) {
            return $map[$type];
        }

        return false;
    }

    public function morph($type, $id)
    {
        $morphable = null;

        $class = $this->type2Class($type);

        if ($class) {
            $morphable = $class::find($id);
        }

        return $morphable;
    }

}