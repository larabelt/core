<?php namespace Ohio\Core\Behaviors;

trait Sluggable
{

    public function __toString()
    {
        return $this->name;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug(trim($value));
    }

    public function slugify()
    {
        if (!$this->slug) {
            $this->setAttribute('slug', str_slug($this->name));
        }

        return $this;
    }

}