<?php
namespace Belt\Core\Behaviors;

use Rutorika\Sortable\MorphToSortedManyTrait;

trait HasSortableTrait
{
    use MorphToSortedManyTrait;

    /**
     * @todo deprecate
     *
     * Eloquent renamed getBelongsToManyCaller to guessBelongsToManyRelation
     * and the package Rutorika\Sortable currently expects the old name to exist
     *
     * @return mixed
     */
    public function getBelongsToManyCaller()
    {
        return $this->guessBelongsToManyRelation();
    }

}