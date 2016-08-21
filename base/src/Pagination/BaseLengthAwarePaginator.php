<?php
namespace Ohio\Core\Base\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class BaseLengthAwarePaginator extends LengthAwarePaginator
{
    /**
     * @var BasePaginateRequest
     */
    public $request;

    public static function get($qb, BasePaginateRequest $request)
    {

        $qb->basePaginate($request);

        $qb->extendedPaginate($request);

        $count = $qb->count();

        $qb->take($request->perPage());
        $qb->offset($request->offset());

        $paginator = new BaseLengthAwarePaginator(
            $qb->get(),
            $count,
            $request->perPage(),
            $request->page()
        );

        $paginator->request = $request;

        $paginator->appends($request->diff());

        return $paginator;
    }

    public function toArray()
    {
        $array = parent::toArray();

        $array['meta'] = $this->request->meta();

        return $array;
    }

}