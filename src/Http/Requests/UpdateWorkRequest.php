<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Services\WorkflowService;
use Illuminate\Validation\Rule;

/**
 * Class UpdateWorkRequest
 * @package Belt\Core\Http\Requests
 */
class UpdateWorkRequest extends Belt\Core\Http\Requests\FormRequest
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
        return $this->service ?: new WorkflowService();
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $workRequest = $this->route('workRequest');

        if ($this->get('transition')) {
            $availableTransitions = $this->service()->availableTransitions($workRequest->getWorkflow(), $workRequest->place);
            $rules['transition'] = [
                'sometimes',
                'required',
                'in:' . implode(',', $availableTransitions)
            ];
        }

        if ($place = $this->get('place')) {
            $rules['place'] = [
                'sometimes',
                'required',
                'in:' . implode(',', $workRequest->getWorkflow()->places())
            ];
        }

        return $rules;
    }

}