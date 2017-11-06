<?php namespace Belt\Core\Behaviors;

use Laravel\Scout\Searchable;

/**
 * Class IsSearchable
 * @package Belt\Core\Behaviors
 */
trait IsSearchable
{

    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->__toSearchableArray();
    }

    public function __toSearchableArray()
    {
        $this->setAppends([]);

        $array = $this->toArray();

        foreach ($this->dates as $column) {
            $array[$column] = strtotime($this->$column);
        }

        foreach($this->relationsToArray() as $relationKey => $relationArray) {
            $array[$relationKey] = $relationArray;
        }

        return $array;
    }

}