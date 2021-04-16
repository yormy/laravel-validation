<?php

namespace Yormy\LaravelValidation\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlacklistedContentEvent
{
    use Dispatchable;
    use SerializesModels;

    protected string $filename;

    protected string $maliciousContent;

    public function __construct(string $filename, string $maliciousContent)
    {
        $this->filename = $filename;
        $this->maliciousContent = $maliciousContent;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getMaliciousContent()
    {
        return $this->maliciousContent;
    }
}
