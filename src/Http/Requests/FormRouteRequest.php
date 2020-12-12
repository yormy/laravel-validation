<?php

namespace Yormy\LaravelValidation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class FormRouteRequest extends FormRequest
{
    protected $routeParamsToValidate = [];

    protected $queryParamsToValidate = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    public function all($keys = null)
    {
        $data = parent::all();

        foreach ($this->routeParamsToValidate as $validationDataKey => $routeParameter) {
            if ($this->route($routeParameter)) {
                $data[$validationDataKey] = $this->route($routeParameter);
            }
        }

        foreach ($this->queryParamsToValidate as $validationDataKey => $queryParameter) {
            if ($this->query($queryParameter)) {
                $data[$validationDataKey] = $this->query($queryParameter);
            }
        }

        return $data;
    }
}
