<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;

class PaginateTranslatableStrings extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\Role::class;

    public $perPage = 100;

    public $orderBy = 'translatable_strings.value';

    public $sortable = [
        'translatable_strings.id',
        'translatable_strings.value',
        'translatable_strings.created_at',
        'translatable_strings.updated_at',
    ];

    public $searchable = [
        'translatable_strings.value',
    ];

}