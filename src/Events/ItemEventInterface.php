<?php

namespace Belt\Core\Events;

use Morph;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemEventInterface
 * @package Belt\Core\Events
 */
interface ItemEventInterface
{

    /**
     * @return Morph
     */
    public function morph();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getType();

}