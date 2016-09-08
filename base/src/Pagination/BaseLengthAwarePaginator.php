<?php
namespace Ohio\Core\Base\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class BaseLengthAwarePaginator
{
    /**
     * @var BasePaginateRequest
     */
    public $request;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $qb;

    /**
     * @var LengthAwarePaginator
     */
    public $paginator;

    public function __construct($qb, $request)
    {
        $this->qb = $qb;

        $this->request = $request;

        $this->build();
    }

    public function build()
    {

        $request = $this->request;

        $needle = $request->needle();
        if ($needle && $request->searchable) {
            $this->qb->where(function ($subQB) use ($needle, $request) {
                foreach ($request->searchable as $column) {
                    $subQB->orWhere($column, 'LIKE', "%$needle%");
                }
            });
        }

        $request->modifyQuery($this->qb);

        $this->qb->orderBy($request->orderBy(), $request->sortBy());

        $count = $this->qb->count();

        $this->qb->take($request->perPage());
        $this->qb->offset($request->offset());

        $paginator = new LengthAwarePaginator(
            $this->qb->get(),
            $count,
            $request->perPage(),
            $request->page()
        );

        $paginator->request = $request;

        $paginator->appends($request->diff());

        $this->paginator = $paginator;
    }

    public function toArray()
    {
        $array = $this->paginator->toArray();

        $array['meta'] = $this->request->meta();

        return $array;
    }

}