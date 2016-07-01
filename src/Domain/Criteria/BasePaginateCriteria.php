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
//        'per_page' => 20,
//        'current_page' => 20,
//        'order_by' => 'id',
//        'sorted_by' => 'asc',
//    ];

    /**
     * @var integer
     */
    public $per_page = 20;

    /**
     * @var integer
     */
    public $current_page = 1;

    /**
     * @var string
     */
    public $order_by = 'id';

    /**
     * @var string
     */
    public $sorted_by = 'asc';

    public function __construct(array $input)
    {

        //$this->setDefaults();

        if (array_get($input, 'current_page')) {
            $this->setCurrentPage(array_get($input, 'current_page'));
        }

        if (array_get($input, 'per_page')) {
            $this->setPerPage(array_get($input, 'per_page'));
        }

        if (array_get($input, 'order_by')) {
            $this->setOrderBy(array_get($input, 'order_by'));
        }

        if (array_get($input, 'sorted_by')) {
            $this->setSortedBy(array_get($input, 'sorted_by'));
        }
    }

//    public function setDefaults()
//    {
//        $defaults = $this->defaults;
//
//        $this->setCurrentPage(array_get($defaults, 'current_page', 1));
//        $this->setPerPage(array_get($defaults, 'per_page', 20));
//        $this->setOrderBy(array_get($defaults, 'order_by', 'id'));
//        $this->setSortedBy(array_get($defaults, 'sorted_by', 'asc'));
//    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param int $per_page
     */
    public function setPerPage($per_page)
    {
        if (!is_numeric($per_page) || $per_page < 1) {
            $per_page = 20;
        }

        $this->per_page = $per_page;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current_page;
    }

    /**
     * @param int $current_page
     */
    public function setCurrentPage($current_page)
    {
        if (!is_numeric($current_page) || $current_page < 1) {
            $current_page = 1;
        }

        $this->current_page = $current_page;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->order_by;
    }

    /**
     * @param string $order_by
     */
    public function setOrderBy($order_by)
    {
        $this->order_by = $order_by;
    }

    /**
     * @return string
     */
    public function getSortedBy()
    {
        return $this->sorted_by;
    }

    /**
     * @param string $sorted_by
     */
    public function setSortedBy($sorted_by)
    {
        $sorted_by = strtolower($sorted_by);

        if (!in_array($sorted_by, ['asc', 'desc'])) {
            $sorted_by = 'asc';
        }

        $this->sorted_by = $sorted_by;
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
            'current_page' => $this->getCurrentPage(),
            'per_page' => $this->getPerPage(),
            'order_by' => $this->getOrderBy(),
            'sorted_by' => $this->getSortedBy(),
        ];
    }

}