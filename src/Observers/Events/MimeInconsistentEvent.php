<?php

namespace Yormy\LaravelValidation\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MimeInconsistentEvent
{
    use Dispatchable;
    use SerializesModels;

    protected string $filename;

    protected string $mimeType;

    private string $code = "MIME_INCONSISTENT";

    private string $severity = "medium";

    public function __construct(string $filename, string $mimeType)
    {
        $this->filename = $filename;
        $this->mimeType = $mimeType;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getMimeType()
    {
        return $this->mimeType;
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
