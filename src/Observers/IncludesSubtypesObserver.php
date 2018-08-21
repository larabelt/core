<?php

namespace Belt\Core\Observers;

use Belt\Core\Behaviors\IncludesSubtypesInterface;
use Belt\Content\Builders\BaseBuilder;

class IncludesSubtypesObserver
{
    /**
     * Listen to the IncludesSubtypesInterface created $item.
     *
     * @param  IncludesSubtypesInterface $item
     * @return void
     */
    public function created(IncludesSubtypesInterface $item)
    {
        /** @var $builder BaseBuilder */
        $class = $item->getSubtypeConfig('builder');
        if ($class && class_exists($class) && !$item->getIsCopy()) {
            $builder = new $class($item);
            $builder->build();
        }
    }

    /**
     * Listen to the IncludesSubtypesInterface saved $item.
     *
     * @param  IncludesSubtypesInterface $item
     * @return void
     */
    public function saved(IncludesSubtypesInterface $item)
    {
        $item->reconcileSubtypeParams();
    }

}