<?php

namespace Belt\Core;

use Silber\Bouncer\Database\Ability as BaseAbility;

/**
 * Class ability
 * @package Belt\Core
 */
class Ability extends BaseAbility
{

    /**
     * @var string
     */
    protected $morphClass = 'abilities';

//    /**
//     * Get the class name for polymorphic relations.
//     *
//     * @return string
//     */
//    public function getMorphClass()
//    {
//        return $this->morphClass;
//    }

}