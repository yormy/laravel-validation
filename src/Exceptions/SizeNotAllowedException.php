<?php

namespace Yormy\LaravelValidation\Exceptions;

use Exception;

class SizeNotAllowedException extends Exception
{
    public function __construct($filename)
    {
        $maxAllowdSize = config('laravel-validation.upload.max_file_size_kb');
        parent::__construct("$filename is too large (max $maxAllowdSize kb");
    }
}
