<?php

namespace Yormy\LaravelValidation;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Yormy\LaravelValidation\LaravelValidation
 */
class LaravelValidationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelValidation::class;
    }
}
