<?php

namespace Ohio\Core\Base\Http\Controllers\Behaviors;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait PositionableControllerTrait
{

    public function repositionEntity($request, $id, $collection, $relation)
    {
        $move = $request->get('move');
        $positionEntityId = $request->get('position_entity_id');

        if ($move && $positionEntityId) {

            $entityToMove = $collection->where('id', $id)->first();
            $entityInDesiredPosition = $collection->where('id', $positionEntityId)->first();

            if ($entityToMove && $entityInDesiredPosition) {
                if ($move == 'after') {
                    $relation->moveAfter($entityToMove, $entityInDesiredPosition);
                }
                if ($move == 'before') {
                    $relation->moveBefore($entityToMove, $entityInDesiredPosition);
                }
            }
        }

    }
}