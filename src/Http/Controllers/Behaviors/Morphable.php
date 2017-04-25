<?php

namespace Belt\Core\Http\Controllers\Behaviors;

use Belt\Core\Helpers\MorphHelper;
use Illuminate\Http\Request;

trait Morphable
{

    /**
     * @var MorphHelper
     */
    public $morphHelper;

    /**
     * @return MorphHelper
     */
    public function morphHelper()
    {
        return $this->morphHelper ?: $this->morphHelper = new MorphHelper();
    }

    /**
     * @param $morphable_type
     * @param $morphable_id
     */
    public function morphable($morphable_type, $morphable_id)
    {
        $morphable = $this->morphHelper()->morph($morphable_type, $morphable_id);

        return $morphable ?: $this->abort(404);
    }

    /**
     * @param $morphable
     * @param $relationKey
     * @param $object
     */
    public function morphableContains($morphable, $relationKey, $object)
    {
        if (!$morphable->$relationKey->contains($object->id)) {
            $this->abort(404, $relationKey . ' does not belong to owner');
        }
    }

    /**
     * @param Request $request
     * @param $prefix
     */
    public function morphRequest(Request $request, $prefix)
    {
        $morphable_type = $request->get($prefix . '_type');
        $morphable_id = $request->get($prefix . '_id');

        if ($morphable_type && $morphable_id) {
            return $this->morphable($morphable_type, $morphable_id);
        }
    }

}