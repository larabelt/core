<?php

namespace Ohio\Core\Base\Http\Controllers;

use Ohio\Core\Base\Http\Exception;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseApiController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function abort($statusCode, $message = '')
    {
        if ($statusCode == 404) {
            throw new Exception\ApiNotFoundHttpException($message);
        }

        throw new Exception\ApiException($message);
    }

    public function getPaginateRequest($class = BasePaginateRequest::class, $query = [])
    {

        if ($class == BasePaginateRequest::class || is_subclass_of($class, BasePaginateRequest::class)) {
            return new $class($query);
        }

        throw new \Exception('Invalid class for BaseApiController::getPaginateRequest');
    }

    public function getPaginator(Builder $qb, BasePaginateRequest $request)
    {
        return new BaseLengthAwarePaginator($qb, $request);
    }

}