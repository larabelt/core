<?php

namespace Belt\Core\Http\Controllers\Behaviors;

use Morph;

trait Morphable
{

    /**
     * @param $entity_type
     * @param $entity_id
     * @return mixed
     */
    public function morph($entity_type, $entity_id)
    {
        $entity = Morph::morph($entity_type, $entity_id);

        return $entity ?: $this->abort(404);
    }

}