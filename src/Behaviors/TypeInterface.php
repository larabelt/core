<?php namespace Belt\Core\Behaviors;

/**
 * Interface TypeInterface
 * @package Belt\Core\Behaviors
 */
interface TypeInterface
{
    /**
     * @return string
     */
    public function getTypeAttribute();

    /**
     * @return string
     */
    public function getMorphClassAttribute();
}