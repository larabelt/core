<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\WorkRequest;
use Belt\Core\Services\WorkflowService;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Class WorkRequestsController
 * @package Belt\Content\Http\Controllers\Api
 */
class WorkRequestsController extends ApiController
{

    /**
     * @var WorkRequest
     */
    public $workRequests;

    /**
     * @var WorkflowService
     */
    public $service;

    /**
     * ApiController constructor.
     * @param WorkRequest $workRequest
     */
    public function __construct(WorkRequest $workRequest)
    {
        $this->workRequests = $workRequest;
    }

    /**
     * @return WorkflowService
     */
    public function service()
    {
        return $this->service ?: new WorkflowService();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //$this->authorize('index', WorkRequest::class);

        $request = Requests\PaginateWorkRequests::extend($request);

        $paginator = $this->paginator($this->workRequests->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreWorkRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\StoreWorkRequest $request)
    {
        $this->authorize('create', WorkRequest::class);

        $input = $request->all();

        $workRequest = $this->workRequests->create(['name' => $input['name']]);

        $this->set($workRequest, $input, [
            'is_active',
            'slug',
            'body',
            'starts_at',
            'ends_at',
        ]);

        $workRequest->save();

        $this->service()->cache();

        return response()->json($workRequest, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkRequest $workRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(WorkRequest $workRequest)
    {
        //$this->authorize('view', $workRequest);

        return response()->json($workRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateWorkRequest $request
     * @param WorkRequest $workRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\UpdateWorkRequest $request, WorkRequest $workRequest)
    {
        $this->authorize('update', $workRequest);

        $input = $request->all();

        $this->set($workRequest, $input, [
            'is_active',
            'name',
            'slug',
            'body',
            'starts_at',
            'ends_at',
        ]);

        $workRequest->save();

        $this->service()->cache();

        return response()->json($workRequest);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param WorkRequest $workRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(WorkRequest $workRequest)
    {
        $this->authorize('delete', $workRequest);

        $workRequest->delete();

        $this->service()->cache();

        return response()->json(null, 204);
    }
}
