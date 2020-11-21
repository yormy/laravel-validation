<?php

namespace Yormy\LaravelValidation\Observers\Listeners;

use Illuminate\Support\Facades\Auth;
use Yormy\LaravelValidation\Models\ReferralAward;
use Yormy\LaravelValidation\Observers\Events\AwardReferrerEvent;
use Yormy\LaravelValidation\Services\AwardService;
use Yormy\LaravelValidation\Traits\CookieTrait;

class AwardReferrerListener
{
    use CookieTrait;

    protected AwardService $awardService;

    public function __construct()
    {
        $this->awardService = new AwardService();
    }

    public function handle(AwardReferrerEvent $event)
    {
        $user = Auth::user();

        if ($user) {
            $publicReferrerId = $this->awardService->getReferrer();

            if (! $publicReferrerId) {
                $latestReward = $this->awardService->getReferringUserFromLatestAward($user->id);
                //if ($latestReward) {
                $publicReferrerId = $latestReward->referrer_id;
                //}
            }

            if ($publicReferrerId) {
                $referringUser = $this->awardService->getReferringUser($publicReferrerId);

                if ($referringUser) {
                    ReferralAward::create([
                        'user_id' => $user->id,
                        'referrer_id' => $referringUser->id,
                        'action_id' => $event->actionId,
                    ]);
                }
            }
        }
    }
}
