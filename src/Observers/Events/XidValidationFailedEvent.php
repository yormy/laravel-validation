<?php

namespace Yormy\LaravelValidation\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class XidValidationFailedEvent
{
    use Dispatchable;
    use SerializesModels;
}
