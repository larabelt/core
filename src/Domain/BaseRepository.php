<?php

namespace Ohio\Base\Domain;

use DB, Request;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;
use Ohio\Base\Domain\Criteria\BasePaginateCriteria;

//use App\Entities\Post;
//use App\Validators\PostValidator;

class BaseRepository extends PrettusRepository implements BaseRepositoryInterface
{

    protected $model_class;

    /**
     * @var BasePaginateCriteria
     */
    public $page_criteria;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return $this->model_class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return $this->model() . 'Validator';
    }

    /**
     * Specify Presenter class name
     *
     * @return mixed
     */
    public function presenter()
    {
        return $this->model() . 'Presenter';
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {

//        \Ohio\Base\Helper\DebugHelper::enableQueryLog();

        $this->applyCriteria();
        $this->applyScope();

        $perPage = $limit ?: $this->page_criteria->getPerPage();
        $currentPage = $this->page_criteria->getCurrentPage();

        $results = $this->model->paginate($perPage, $columns, 'currentPage', $currentPage);

//        $query = \Ohio\Base\Helper\DebugHelper::getLastQuery();
//        s($query);
//        foreach ($results as $n => $result) {
//            s([
//                'id' => $result->id,
//                'email' => $result->email,
//            ]);
//        }
//        exit;


        $results->appends(request()->query());
        $this->resetModel();

        $results = $this->parserResult($results);

        $results['meta']['request'] = $this->page_criteria->toArray();

        return $results;
    }

    public function getPaginateLimit()
    {

        $limit = Request::input('limit') ?: $this->limit;
        $limit = is_numeric($limit) ? $limit : $this->limit;

        return abs($limit);
    }

    public function update(array $attributes, $id)
    {
        unset($attributes['created_at']);
        unset($attributes['updated_at']);

        return parent::update($attributes, $id);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
    }
}
