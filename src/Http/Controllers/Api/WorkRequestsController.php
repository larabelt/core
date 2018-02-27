<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\WorkRequest;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\Morphable;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Services\WorkflowService;
use Belt\Core\Services\WorkflowServiceTrait;
use Illuminate\Http\Request;

/**
 * Class WorkRequestsController
 * @package Belt\Content\Http\Controllers\Api
 */
class WorkRequestsController extends ApiController
{
    use Morphable;
    use WorkflowServiceTrait;

    /**
     * @var WorkRequest
     */
    public $workRequests;

    /**
     * ApiController constructor.
     * @param WorkRequest $workRequest
     */
    public function __construct(WorkRequest $workRequest)
    {
        $this->workRequests = $workRequest;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', WorkRequest::class);

        $request = Requests\PaginateWorkRequests::extend($request);

        $paginator = $this->paginator($this->workRequests->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * @param Requests\StoreWorkRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\StoreWorkRequest $request)
    {
        $this->authorize('create', WorkRequest::class);

        $input = $request->all();

        $this->morphable($input['workable_type'], $input['workable_id']);

        $workRequest = $this->workRequests->create([
            'workable_id' => $input['workable_id'],
            'workable_type' => $input['workable_type'],
            'workflow_key' => $input['workflow_key'],
        ]);

        $this->set($workRequest, $input, [
            'is_open',
            'place',
            'payload',
        ]);

        $workRequest->save();

        return response()->json($workRequest, 201);
    }

    /**
     * @param WorkRequest $workRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(WorkRequest $workRequest)
    {
        $this->authorize('view', $workRequest);

        return response()->json($workRequest);
    }

    /**
     * @param Requests\UpdateWorkRequest $request
     * @param WorkRequest $workRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Requests\UpdateWorkRequest $request, WorkRequest $workRequest)
    {
        $this->authorize('update', $workRequest);

        $input = $request->all();

        $this->set($workRequest, $input, [
            'is_open',
            'place',
            'payload',
        ]);

        $workRequest->save();

        if ($transition = $request->get('transition')) {
            $workRequest = $this->workflowService()->apply($workRequest, $transition);
        }

        if ($reset = $request->get('reset')) {
            $workRequest = $this->workflowService()->reset($workRequest);
        }

        $workRequest->save();

        return response()->json($workRequest);
    }

    /**
     * @param WorkRequest $workRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(WorkRequest $workRequest)
    {
        $this->authorize('delete', $workRequest);

        $workRequest->delete();

        return response()->json(null, 204);
    }
}
