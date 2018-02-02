<?php

namespace Belt\Core\Events;

use Morph;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemEventTrait
 * @package Belt\Core\Events
 */
trait ItemEventTrait
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * Create a new event instance.
     *
     * @param Model $item
     */
    public function __construct(Model $item)
    {
        $this->setId($item->id);
        $this->setType($item->getMorphClass());
    }

    /**
     * @return Morph
     */
    public function morph()
    {
        return Morph::morph($this->type, $this->id);
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}