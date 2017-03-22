<?php
namespace Belt\Core\Http\Requests;

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
     * @var array
     */
    public $joins = [];

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

        if ($orderBy && in_array($orderBy, $this->sortable)) {
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
    public function items(Builder $query) {
        return $query->get();
    }

}