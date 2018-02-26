<?php

namespace Belt\Core\Events;

use Belt, Morph;
use Belt\Core\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemEventInterface
 * @package Belt\Core\Events
 */
interface ItemEventInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);
    
    /**
     * @return Model
     */
    public function item();

    /**
     * @return integer
     */
    public function getItemId();

    /**
     * @param $id
     */
    public function setItemId($id);

    /**
     * @return string
     */
    public function getItemType();

    /**
     * @param $type
     */
    public function setItemType($type);

    /**
     * @return User
     */
    public function user();

    /**
     * @return integer
     */
    public function getUserId();

    /**
     * @param $id
     */
    public function setUserId($id);

    /**
     * @return integer
     */
    public function getUserQB();

    /**
     * @param Builder $qb
     */
    public function setUserQB($qb);

}