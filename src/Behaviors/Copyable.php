<?php namespace Belt\Core\Behaviors;

/**
 * Class Copyable
 * @package Belt\Core\Behaviors
 */
trait Copyable
{
    /**
     * @var bool
     */
    protected $isCopy = false;

    /**
     * @param $value
     */
    public function setIsCopy($value)
    {
        $this->isCopy = $value;
    }

    /**
     * @return bool
     */
    public function getIsCopy()
    {
        return $this->isCopy;
    }

}