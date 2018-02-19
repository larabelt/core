<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Services\WorkflowService;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Workflows\BaseWorkflow;

/**
 * Class WorkflowsController
 * @package Belt\Content\Http\Controllers\Api
 */
class WorkflowsController extends ApiController
{

    /**
     * @var WorkflowService
     */
    public $service;

    /**
     * @return WorkflowService
     */
    public function service()
    {
        return $this->service ?: $this->service = new WorkflowService();
    }

    /**
     * @param $accessor
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($accessor)
    {
        $this->authorize('view', BaseWorkflow::class);

        $this->service()->setWorkflow($accessor);

        $workflow = $this->service()->getWorkflow() ?: $this->abort(404);

        return response()->json($workflow->toArray());
    }

}
