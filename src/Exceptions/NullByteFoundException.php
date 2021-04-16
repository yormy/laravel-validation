<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class NullByteFoundException extends Exception
{
    public function __construct($filename)
    {
        //SECURITY NOTE : This is serious, Best to block the ip immediately
        parent::__construct("$filename null byte injection");
    }
}
