<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;
use Yormy\LaravelValidation\Observers\Events\XidValidationFailedEvent;

class XidNotFoundException extends Exception
{
    public function __construct($value = '')
    {
        event(new XidValidationFailedEvent()); // When the xid is invalid this is probably a hacking attempt

        parent::__construct($value);
    }
}
