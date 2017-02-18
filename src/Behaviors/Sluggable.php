<?php namespace Belt\Core\Behaviors;

/**
 * Class Sluggable
 * @package Belt\Core\Behaviors
 */
trait Sluggable
{

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug(trim($value));
    }

    /**
     * @return $this
     */
    public function slugify()
    {
        if (!$this->slug) {
            $this->setAttribute('slug', str_slug($this->name));
        }

        return $this;
    }

}