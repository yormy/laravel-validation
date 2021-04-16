<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class ExtensionInvalidException extends Exception
{
    public function __construct($filename)
    {
        parent::__construct("$filename is has an incorrect extension, please rename the file");
    }
}
