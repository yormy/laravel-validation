<?php

namespace Yormy\LaravelValidation\Observers\Listeners;

use Illuminate\Support\Facades\Auth;
use Yormy\LaravelValidation\Models\ReferralAward;
use Yormy\LaravelValidation\Observers\Events\AwardRevokeEvent;
use Yormy\LaravelValidation\Traits\CookieTrait;

class AwardRevokeListener
{
    use CookieTrait;

    public function handle(AwardRevokeEvent $event)
    {
        $user = Auth::user();
        if ($user) {
            $latestReward = ReferralAward::with('user')
                ->where('user_id', $user->id)
                ->where('action_id', $event->actionId)
                ->latest('created_at')
                ->first();

            if ($latestReward) {
                $latestReward->delete_reason = $event->deleteReason;
                $latestReward->save();
                $latestReward->delete();
            }
        }
    }
}
