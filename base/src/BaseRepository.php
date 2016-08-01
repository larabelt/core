<?php

namespace Ohio\Core\Base;

use DB, Request;
use Ohio\Core\Base\BaseCriteria\BasePaginateCriteria;
use Ohio\Core\Base\Helper\DebugHelper;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;

class BaseRepository extends PrettusRepository implements BaseRepositoryInterface
{

    protected $model_class;

    /**
     * @var BasePaginateCriteria
     */
    public $page_criteria;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->skipPresenter(true);
    }

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

//        DebugHelper::enableQueryLog();

        $this->applyCriteria();
        $this->applyScope();

        $perPage = $limit ?: $this->page_criteria->getPerPage();
        $page = $this->page_criteria->getCurrentPage();

        $results = $this->model->paginate($perPage, $columns, 'page', $page);

//        $query = DebugHelper::getLastQuery();
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

        if (!$this->skipPresenter) {
            $results['meta']['request'] = $this->page_criteria->toArray();
        }

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
        unset($attributes['id']);
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
