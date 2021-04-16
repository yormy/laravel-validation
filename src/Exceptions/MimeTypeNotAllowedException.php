<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class MimeTypeNotAllowedException extends Exception
{
    public function __construct($filename, $mimetype)
    {
        parent::__construct("$mimetype is not allowed for file: $filename");
    }
}
