<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Services\WorkflowServiceTrait;

/**
 * Class StoreUser
 * @package Belt\Core\Http\Requests
 */
class StoreWorkRequest extends Belt\Core\Http\Requests\UserRequest
{
    use WorkflowServiceTrait;

    /**
     * @return array
     */
    public function rules()
    {
        $availableWorkflows = $this->workflowService()->get();

        return [
            'workflow_key' => [
                'required',
                'in:' . implode(',', array_keys($availableWorkflows))
            ],
            'workable_id' => 'required',
            'workable_type' => 'required',
        ];
    }

}