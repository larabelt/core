<?php namespace Ohio\Core\Base\Behaviors\Sluggable;

trait SluggableTrait
{

    public function slugify()
    {

        if (!$this->slug) {
            $this->setAttribute('slug', str_slug($this->title));
        }

        return $this;
    }

}