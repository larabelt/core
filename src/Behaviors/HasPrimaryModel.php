<?php namespace Belt\Core\Behaviors;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HasPrimaryModel
 * @package Belt\Core\Behaviors
 */
trait HasPrimaryModel
{

    /**
     * @return Model
     */
    public function instance()
    {
        $class = static::$primaryModel;

        return new $class();
    }

    /**
     * Get Model query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->instance()->query();
    }

    /**
     * Get Model table
     *
     * @return string
     */
    public function table()
    {
        return $this->instance()->getTable();
    }

}