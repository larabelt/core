<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Illuminate\Validation\Rule;

/**
 * Class UpdateWorkRequest
 * @package Belt\Core\Http\Requests
 */
class UpdateWorkRequest extends Belt\Core\Http\Requests\FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        $workRequest = $this->route('workRequest');
        $workflow = $workRequest->getWorkflow();
        $place = $this->get('place');

        $availableTransitions = $workflow->availableTransitions();

        return [
            'transition' => [
                'required',
                'in:' . implode(',', $availableTransitions)
            ],
        ];
    }

}