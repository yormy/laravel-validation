<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class BlacklistedContentException extends Exception
{
    public function __construct($filename, $value)
    {
        //NOTE : This is serious, Best to block the ip immediately
        // todo : throw event
        // todo : for production remove the $value form the feedback
        parent::__construct("$filename is malicious : $value");
    }
}
