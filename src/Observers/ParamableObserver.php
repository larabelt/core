<?php

namespace Belt\Core\Observers;

use Belt\Core\Behaviors\ParamableInterface;

class ParamableObserver
{
    /**
     * Listen to the ParamableInterface deleting $item.
     *
     * @param  ParamableInterface $item
     * @return void
     */
    public function deleting(ParamableInterface $item)
    {
        $item->params()->delete();
    }
}