<?php
namespace Ohio\Core\Base\BaseCriteria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class BasePaginateCriteria
{

    /**
     * @var array
     */
    public $input = [];

    /**
     * @var integer
     */
    public $perPage = 20;

    /**
     * @var integer
     */
    public $page = 1;

    /**
     * @var string
     */
    public $orderBy = 'id';

    /**
     * @var string
     */
    public $sortBy = 'asc';

    public $searchable = [];

    public function __construct(array $input)
    {
        if (array_get($input, 'page')) {
            $this->setCurrentPage(array_get($input, 'page'));
        }

        if (array_get($input, 'perPage')) {
            $this->setPerPage(array_get($input, 'perPage'));
        }

        if (array_get($input, 'orderBy')) {
            $this->setOrderBy(array_get($input, 'orderBy'));
        }

        if (array_get($input, 'sortBy')) {
            $this->setSortedBy(array_get($input, 'sortBy'));
        }
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return ($this->perPage * $this->page) - $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        if (!is_numeric($perPage) || $perPage < 1) {
            $perPage = 20;
        }

        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setCurrentPage($page)
    {
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        }

        $this->page = $page;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function getSortedBy()
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     */
    public function setSortedBy($sortBy)
    {
        $sortBy = strtolower($sortBy);

        if (!in_array($sortBy, ['asc', 'desc'])) {
            $sortBy = 'asc';
        }

        $this->sortBy = $sortBy;
    }

    public function toArray()
    {
        return [
          'orderBy' => $this->getOrderBy(),
          'sortedBy' => $this->getSortedBy(),
        ];
    }

    public function also($qb)
    {
        return $qb;
    }

}