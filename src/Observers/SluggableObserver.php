<?php

namespace Belt\Core\Observers;

use Belt\Core\Behaviors\SluggableInterface;

class SluggableObserver
{
    /**
     * Listen to the SluggableInterface saving $item.
     *
     * @param  SluggableInterface $item
     * @return void
     */
    public function saving(SluggableInterface $item)
    {
        $item->slugify();
    }
}