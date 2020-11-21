<?php

namespace Yormy\LaravelValidation\Observers;

use Illuminate\Events\Dispatcher;
use Yormy\LaravelValidation\Observers\Events\AwardReferrerEvent;
use Yormy\LaravelValidation\Observers\Events\AwardRevokeEvent;
use Yormy\LaravelValidation\Observers\Listeners\AwardReferrerListener;
use Yormy\LaravelValidation\Observers\Listeners\AwardRevokeListener;

class ActionSubscriber
{
    /**
     * Binding of SettingsChanged Events
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            AwardReferrerEvent::class,
            AwardReferrerListener::class
        );

        $events->listen(
            AwardRevokeEvent::class,
            AwardRevokeListener::class
        );
    }
}
