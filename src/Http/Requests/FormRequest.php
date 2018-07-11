<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends BaseFormRequest implements
    Belt\Core\Http\Requests\BaseRequestInterface
{

    use Belt\Core\Http\Requests\BaseRequest;

    /**
     * @todo figure out what happened to Laravel 5.6
     *
     * @return bool
     */
    public function wantsJson()
    {
        if ($route = $this->route()) {
            if ($middleware = $route->middleware()) {
                if (in_array('api', $middleware)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }

    /**
     * @param $table
     * @param $column
     * @param array $routeParameters
     * @return Rules\Exists
     */
    public function ruleExists($table, $column, $routeParameters = [])
    {
        $params = [];
        foreach ($routeParameters as $routeParameter) {
            $params[$routeParameter] = $this->route($routeParameter);
        }

        $rule = new Rules\Exists($table, $column);

        foreach ($params as $key => $value) {
            $rule->where($key, $value);
        }

        return $rule;
    }

    /**
     * @param $table
     * @param array $columns
     * @return Rules\Unique
     */
    public function ruleUnique($table, $columns = [])
    {

        $rule = new Rules\Unique($table);
        $rule->where(function ($query) use ($columns) {
            foreach ($columns as $column) {
                $query->where($column, $this->get($column));
            }
        });

        return $rule;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        parent::failedValidation($validator);
    }

}