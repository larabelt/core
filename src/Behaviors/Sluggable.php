<?php namespace Belt\Core\Behaviors;

use Belt;

/**
 * Class Sluggable
 * @package Belt\Core\Behaviors
 */
trait Sluggable
{

    /**
     * Binds events to subclass
     */
    public static function bootSluggable()
    {
        static::observe(Belt\Core\Observers\SluggableObserver::class);
    }

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

    /**
     * Scope a query to search by slug or id
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSluggish($query, $value)
    {

        $column = is_numeric($value) ? 'id' : 'slug';

        $value = $column == 'id' ? $value : str_slug($value);

        return $query->where($column, $value);
    }

}