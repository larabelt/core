<?php

namespace Belt\Core\Http\Controllers\Behaviors;

/**
 * Class Positionable
 * @package Belt\Core\Http\Controllers\Behaviors
 */
trait Positionable
{

    /**
     * @param $request
     * @param $id
     * @param $collection
     * @param $relation
     */
    public function repositionHasManyThrough($request, $id, $collection, $relation)
    {
        $move = $request->get('move');
        $positionEntityId = $request->get('position_entity_id');
        if ($move && $positionEntityId) {
            $entityToMove = $collection->where('id', $id)->first();
            $entityInDesiredPosition = $collection->where('id', $positionEntityId)->first();
            $this->__reposition($move, $entityToMove, $entityInDesiredPosition);
        }
    }

    /**
     * @param $request
     * @param $entityToMove
     */
    public function reposition($request, $entityToMove)
    {
        $move = $request->get('move');
        $positionEntityId = $request->get('position_entity_id');

        if ($move && $positionEntityId) {
            $entityInDesiredPosition = $entityToMove->query()->where('id', $positionEntityId)->first();
            $this->__reposition($move, $entityToMove, $entityInDesiredPosition);
        }
    }

    public function __reposition($move, $entityToMove, $entityInDesiredPosition)
    {
        if ($entityToMove && $entityInDesiredPosition) {
            if ($move == 'after') {
                $entityToMove->moveAfter($entityInDesiredPosition);
            }
            if ($move == 'before') {
                $entityToMove->moveBefore($entityInDesiredPosition);
            }
        }
    }
}