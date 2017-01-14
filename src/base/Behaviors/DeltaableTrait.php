<?php namespace Ohio\Core\Base\Behaviors;

trait DeltaableTrait
{

    function scopeDeltaable($query, $options) {

        $columns = array_get($this->deltaable, 'columns');
        foreach($columns as $column) {
            $query->where($column, array_get($options, $column));
        }

        return $query;
    }

    function

}