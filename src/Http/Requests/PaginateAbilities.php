<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateAbilities extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\Ability::class;

    public $perPage = null;

    public $orderBy = 'abilities.id';

    public $sortable = [
        'abilities.id',
        'abilities.name',
    ];

    public $searchable = [
        'abilities.name',
    ];

    public function modifyQuery(Builder $query)
    {
        if ($this->get('entity_id')) {
            $query->where('entity_id', $this->get('entity_id'));
        } else {
            $query->whereNull('entity_id');
        }

        return $query;
    }

}