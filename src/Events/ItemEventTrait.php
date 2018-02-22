<?php

namespace Belt\Core\Events;

use Belt, Auth, Morph;
use Belt\Core\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemEventTrait
 * @package Belt\Core\Events
 */
trait ItemEventTrait
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $itemID;

    /**
     * @var string
     */
    private $itemType;

    /**
     * @var integer
     */
    private $userID;

    /**
     * @var Builder
     */
    private $userQB;

    /**
     * Create a new event instance.
     *
     * @param Model $item
     * @param string $name
     */
    public function __construct(Model $item, $name = null)
    {
        $this->setItemID($item->id);
        $this->setItemType($item->getMorphClass());

        if ($userID = Auth::id()) {
            $this->setUserID($userID);
        }

        if ($name) {
            $this->setName($name);
        }
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Model
     */
    public function item()
    {
        return Morph::morph($this->getItemType(), $this->getItemID());
    }

    /**
     * @return User
     */
    public function user()
    {
        if ($userID = $this->getUserID()) {
            return $this->getUserQB()->find($userID);
        }
    }

    /**
     * @param $id
     */
    public function setItemID($id)
    {
        $this->itemID = $id;
    }

    /**
     * @return int|mixed
     */
    public function getItemID()
    {
        return $this->itemID;
    }

    /**
     * @param $type
     */
    public function setItemType($type)
    {
        $this->itemType = $type;
    }

    /**
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @param $id
     */
    public function setUserID($id)
    {
        $this->userID = $id;
    }

    /**
     * @return int|mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param Builder $qb
     */
    public function setUserQB($qb)
    {
        $this->userQB = $qb;
    }

    /**
     * @return Builder
     */
    public function getUserQB()
    {
        return $this->userQB ?: $this->userQB = User::query();
    }

}