<?php

namespace Belt\Core\Http\Requests;

use Belt, DB;
use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateIndex extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\Index::class;

    public $perPage = 20;

    public $orderBy = 'index.id';

    public $sortable = [
        'index.id',
        'index.indexable_id',
        'index.indexable_type',
        'index.name',
    ];

    public $searchable = [
        'index.name',
    ];

    /**
     * @var Belt\Core\Services\IndexService
     */
    public $service;

    /**
     * @return Belt\Core\Services\IndexService
     */
    public function service()
    {
        return $this->service ?: $this->service = new Belt\Core\Services\IndexService();
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        if ($id = $this->get('id')) {
            $query->whereIn('index.indexable_id', explode(',', $id));
        }

        if ($type = $this->get('type')) {
            $query->whereIn('index.indexable_type', explode(',', $type));
        }

        $columns = $this->service()->columns();
        $input = array_except($this->all(), ['id', 'type']);

        foreach ($input as $key => $value) {
            if (in_array($key, $columns)) {
                $query->where('index.' . $key, $value);
            }
        }
    }

}