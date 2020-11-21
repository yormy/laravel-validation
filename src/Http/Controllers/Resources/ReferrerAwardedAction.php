<?php

namespace Yormy\LaravelValidation\Http\Controllers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferrerAwardedAction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $modelIdColumn = config('laravel-validation.models.referrer.public_id');
        $modelNameColumn = config('laravel-validation.models.referrer.name');

        return [
            'user_id' => $this->user->{$modelIdColumn},
            'user_name' => $this->user->{$modelNameColumn},
            'actionName' => $this->action->name,
            'points' => $this->action->points,
            'paid' => $this->payment_id ? true : false,
            'paidSearchable' => $this->payment_id ? "#paid" : "#unpaid",
            'created_at' => $this->created_at->format(config('laravel-validation.datetime_format')),
        ];
    }
}
