<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class MimeInconsistentException extends Exception
{
    public function __construct($filename)
    {
        parent::__construct("$filename is inconsistent mimetype");
    }
}
