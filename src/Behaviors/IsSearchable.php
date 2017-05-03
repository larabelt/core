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
        $this->setAppends([]);

        return $this->toArray();
    }

}