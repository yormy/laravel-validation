<?php

namespace Yormy\LaravelValidation\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

//SECURITY NOTE : This is serious, Best to block the ip immediately
class NullByteFoundEvent
{
    use Dispatchable;
    use SerializesModels;

    protected string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }
}
