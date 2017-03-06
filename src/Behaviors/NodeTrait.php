<?php namespace Belt\Core\Behaviors;

use Kalnoy\Nestedset\NodeTrait as BaseNodeTrait;

/**
 * Class Paramable
 * @package Belt\Core\Behaviors
 */
trait NodeTrait
{

    use BaseNodeTrait;

    public function children()
    {
        return $this->hasMany(get_class($this), $this->getParentIdName())
            ->orderBy('_lft')
            ->setModel($this);
    }

}