<?php

namespace Yormy\LaravelValidation\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SizeNotAllowedEvent
{
    use Dispatchable;
    use SerializesModels;

    protected string $filename;

    private string $code = "SIZE_NOT_ALLOWED";

    private string $severity = "low";

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

}
