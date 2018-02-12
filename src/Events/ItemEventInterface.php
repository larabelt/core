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
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param $type
     * @return $this
     */
    public function setType($type);

}