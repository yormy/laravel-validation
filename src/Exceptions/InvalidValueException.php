<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class InvalidValueException extends Exception
{
    /**
     * InvalidValueException constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct($value);
    }
}
