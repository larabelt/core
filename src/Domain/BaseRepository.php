<?php

namespace Ohio\Base\Domain;

use Request;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Post;
use App\Validators\PostValidator;

/**
 * Class PostRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BaseRepository extends PrettusRepository implements BaseRepositoryInterface
{

    protected $domain;
    protected $limit;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return $this->domain;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return $this->domain . 'Validator';
    }

    /**
     * Specify Presenter class name
     *
     * @return mixed
     */
    public function presenter()
    {
        return $this->domain . 'Presenter';
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {

        $limit = $limit ?: $this->getPaginateLimit();

        return parent::paginate($limit, $columns, $method);
    }

    public function getPaginateLimit()
    {

        $limit = Request::input('limit') ?: $this->limit;
        $limit = is_numeric($limit) ? $limit : $this->limit;

        return abs($limit);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
    }
}
