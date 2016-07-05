<?php
namespace Ohio\Base\Domain\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class BasePaginateCriteria implements CriteriaInterface
{
//    /**
//     * @var array
//     */
//    public $defaults = [
//        'perPage' => 20,
//        'page' => 20,
//        'orderBy' => 'id',
//        'sortBy' => 'asc',
//    ];

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

    public function __construct(array $input)
    {

        //$this->setDefaults();

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

//    public function setDefaults()
//    {
//        $defaults = $this->defaults;
//
//        $this->setCurrentPage(array_get($defaults, 'page', 1));
//        $this->setPerPage(array_get($defaults, 'perPage', 20));
//        $this->setOrderBy(array_get($defaults, 'orderBy', 'id'));
//        $this->setSortedBy(array_get($defaults, 'sortBy', 'asc'));
//    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
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

    /**
     * Apply criteria in query repository
     *
     * @param         Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {

        $model = $model instanceof Builder ?: $model->query();

        $repository->page_criteria = $this;

        $model->orderBy($this->getOrderBy(), $this->getSortedBy());

        return $model;
    }

    public function toArray()
    {
        return [
            'page' => $this->getCurrentPage(),
            'perPage' => $this->getPerPage(),
            'orderBy' => $this->getOrderBy(),
            'sortBy' => $this->getSortedBy(),
        ];
    }

}