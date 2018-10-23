<?php
namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateTranslatables extends PaginateRequest
{
    public $perPage = 10;

    public $orderBy = 'translations.translatable_column';

    public $sortable = [
        'translations.id',
        'translations.translatable_id',
        'translations.translatable_type',
        'translations.translatable_column',
    ];

    public $searchable = [
        'translations.id',
        'translations.translatable_id',
        'translations.translatable_type',
        'translations.translatable_column',
        'translations.value',
    ];

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [];

    public function modifyQuery(Builder $query)
    {
        if ($this->get('translatable_id')) {
            $query->where('translatable_id', $this->get('translatable_id'));
        }

        if ($this->get('translatable_type')) {
            $query->where('translatable_type', $this->get('translatable_type'));
        }

        return $query;
    }

}