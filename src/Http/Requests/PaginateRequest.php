<?php

namespace Belt\Core\Http\Requests;

use Belt\Core\Pagination\PaginationQueryModifier;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginateRequest extends Request
{

    /**
     * @var integer
     */
    public $perPage = 20;

    /**
     * @var string
     */
    public $orderBy = 'id';

    /**
     * @var string
     */
    public $sortBy = 'asc';

    /**
     * @var array
     */
    public $sortable = [];

    /**
     * @var array
     */
    public $searchable = [];

    /**
     * @var array
     */
    public $meta = [];

    /**
     * @var PaginationQueryModifier[]
     */
    public $queryModifiers = [];

    /**
     * @var array
     */
    public $joins = [];

    /**
     * @deprecated
     *
     * @return $this
     */
    public function reCapture()
    {
        $captured = parent::capture();

        $this->attributes = $captured->attributes;
        $this->request = $captured->request;
        $this->query = $captured->query;
        $this->server = $captured->server;
        $this->files = $captured->files;
        $this->cookies = $captured->cookies;
        $this->headers = $captured->headers;

        return $this;
    }

    /**
     * Create new PageRequest instance extending a regular Request instance
     *
     * @param Request $request
     * @return static
     */
    public static function extend(Request $request)
    {
        $new = new static();

        $new->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->content
        );

        return $new;
    }

    /**
     * @return string
     */
    public function needle()
    {
        $needle = $this->query('q');

        return (string) $needle;
    }

    /**
     * @return int
     */
    public function offset()
    {

        $perPage = $this->perPage();

        return (int) ($perPage * $this->page()) - $perPage;
    }

    /**
     * @return int $perPage
     */
    public function perPage()
    {

        $perPage = $this->query('perPage');

        if ($perPage && is_numeric($perPage) && $perPage > 0) {
            return (int) $perPage;
        }

        return (int) $this->perPage;
    }

    /**
     * @return int
     */
    public function page()
    {

        $page = $this->query('page');

        if ($page && is_numeric($page) && $page > 0) {
            return (int) $page;
        }

        return (int) 1;
    }

    /**
     * @return string
     */
    public function orderBy()
    {
        $orderBy = $this->query('orderBy');

        if ($orderBy && in_array(ltrim($orderBy, '-'), $this->sortable)) {
            return (string) $orderBy;
        }

        return (string) $this->orderBy;
    }

    /**
     * @return string
     */
    public function sortBy()
    {
        $sortBy = strtolower($this->query('sortBy'));

        if ($sortBy && in_array($sortBy, ['asc', 'desc'])) {
            return (string) $sortBy;
        }

        return (string) $this->sortBy;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function modifyQuery(Builder $query)
    {
        return $query;
    }

    /**
     * @param Builder $query
     * @return Collection
     */
    public function items(Builder $query)
    {
        return $query->get();
    }

}