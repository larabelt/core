<?php

namespace Belt\Core\Builders;

use Belt;
use Belt\Core\Behaviors\IncludesSubtypesInterface;

/**
 * Class BaseBuilder
 * @package Belt\Content\Builders
 */
abstract class BaseBuilder
{
    /**
     * @var IncludesSubtypesInterface
     */
    public $item;

    /**
     * BaseBuilder constructor.
     * @param IncludesSubtypesInterface $item
     */
    public function __construct(IncludesSubtypesInterface $item)
    {
        $this->item = $item;
    }

    abstract function build();

}