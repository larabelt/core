<?php
namespace Ohio\Core\Base;

use Illuminate\Database\Eloquent\Model;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class BaseModel extends Model
{

    protected $guarded = ['id'];

    public function __toString()
    {
        return (string) $this->id;
    }

    public function scopeBasePaginate($query, BasePaginateRequest $request)
    {
        $needle = $request->needle();
        if ($needle && $request->searchable) {
            $query->where(function ($subQB) use ($needle, $request) {
                foreach ($request->searchable as $column) {
                    $subQB->orWhere($column, 'LIKE', "%$needle%");
                }
            });
        }

        //$qb = $criteria->also($qb);

        $query->orderBy($request->orderBy(), $request->sortBy());

        return $query;
    }

    public function scopeExtendedPaginate($query, BasePaginateRequest $request)
    {
        return $query;
    }
}