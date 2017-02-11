<?php namespace Ohio\Core\Behaviors;

interface SluggableInterface
{

    public function __toString();

    public function setNameAttribute($value);

    public function setSlugAttribute($value);

    public function slugify();

}