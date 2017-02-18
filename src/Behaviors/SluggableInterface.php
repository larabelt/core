<?php namespace Belt\Core\Behaviors;

/**
 * Interface SluggableInterface
 * @package Belt\Core\Behaviors
 */
interface SluggableInterface
{

    /**
     * @return mixed
     */
    public function __toString();

    /**
     * @param $value
     * @return mixed
     */
    public function setNameAttribute($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setSlugAttribute($value);

    /**
     * @return mixed
     */
    public function slugify();

}