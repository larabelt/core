<?php

namespace Belt\Core\Http\Controllers;

use Belt, Event;
use Belt\Core\Http\Exceptions;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\DefaultLengthAwarePaginator;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ApiController
 * @package Belt\Core\Http\Controllers
 */
class ApiController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HandlesAuthorization;

    /**
     * @param $statusCode
     * @param string $message
     * @throws Exceptions\ApiException
     * @throws Exceptions\ApiNotFoundHttpException
     */
    public function abort($statusCode, $message = '')
    {
        if ($statusCode == 404) {
            throw new Exceptions\ApiNotFoundHttpException($message);
        }

        $exception = new Exceptions\ApiException();
        $exception->setStatusCode($statusCode);
        $exception->setMsg($message);

        throw $exception;
    }

    /**
     * @param $class
     * @param array $query
     * @return mixed
     * @throws \Exception
     */
    public function getPaginateRequest($class = PaginateRequest::class, $query = [])
    {

        if ($class == PaginateRequest::class || is_subclass_of($class, PaginateRequest::class)) {
            return new $class($query);
        }

        throw new \Exception('Invalid class for ApiController::getPaginateRequest');
    }

    /**
     * @param Builder $qb
     * @param PaginateRequest $request
     * @return DefaultLengthAwarePaginator
     */
    public function paginator(Builder $qb, PaginateRequest $request)
    {
        $paginator = new DefaultLengthAwarePaginator($qb, $request);

        $paginator->build();

        return $paginator;
    }

    /**
     * @param $item
     * @param $input
     * @param $key
     */
    public function set($item, $input, $key)
    {
        if (is_array($key)) {
            foreach ($key as $_key) {
                $this->set($item, $input, $_key);
            }
        } elseif (array_key_exists($key, $input)) {
            $item->$key = $input[$key];
        }
    }

    /**
     * @param $item
     * @param $input
     * @param $key
     */
    public function setIfNotEmpty($item, $input, $key)
    {
        if (is_array($key)) {
            foreach ($key as $_key) {
                $this->setIfNotEmpty($item, $input, $_key);
            }
        } elseif (array_key_exists($key, $input) && $value = $input[$key]) {
            $item->$key = $value;
        }
    }

    /**
     * @param $type
     * @param $item
     */
    public function itemEvent($type, $item)
    {
        $name = sprintf('%s.%s', $item->getMorphClass(), $type);

        $classes = [
            'saved' => Belt\Core\Events\ItemSaved::class,
            'created' => Belt\Core\Events\ItemCreated::class,
            'updated' => Belt\Core\Events\ItemUpdated::class,
            'deleted' => Belt\Core\Events\ItemDeleted::class,
            'attached' => Belt\Core\Events\ItemUpdated::class,
            'detached' => Belt\Core\Events\ItemUpdated::class,
        ];

        $subtype = @end(explode('.', $type));

        $class = array_get($classes, $subtype);

        if ($class) {
            $event = new $class($item, $name);
            $result = Event::dispatch($name, $event);
        }

    }

    /**
     * Authorize a given action for the current user.
     *
     * @todo re-write when upgrading to laravel 5.5
     * @param  mixed $abilities
     * @param  mixed|array $arguments
     * @return \Illuminate\Auth\Access\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorize($abilities, $arguments = [])
    {
        $gate = app(Gate::class);

        foreach ((array) $abilities as $ability) {
            list($ability, $arguments) = $this->parseAbilityAndArguments($ability, $arguments);
            if ($gate->allows($ability, $arguments)) {
                return $this->allow();
            }
        }

        return $this->deny();
    }

    /**
     * @param $request
     * @param $item
     */
    public function append($request, $items)
    {
        $items = is_array($items) ? $items : [$items];

        if ($append = $request->get('append')) {
            foreach ((array) $items as $item) {
                $item->append(explode(',', $append));
            }
        }
    }

    /**
     * @param $request
     * @param $item
     */
    public function embed($request, $items)
    {
        $items = is_array($items) ? $items : [$items];

        if ($embed = $request->get('embed')) {
            foreach ((array) $items as $item) {
                foreach (explode(',', $embed) as $relation) {
                    $item->$relation;
                }
            }
        }
    }


}