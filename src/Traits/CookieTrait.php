<?php

namespace Yormy\LaravelValidation\Traits;

use Illuminate\Support\Facades\Cookie;

trait CookieTrait
{
    public function getReferrerFromCookie()
    {
        $cookieName = config('laravel-validation.cookie.name');
        if (request()->hasCookie($cookieName)) {
            $publicReferrerId = request()->cookie($cookieName);

            return $publicReferrerId;
        }

        return null;
    }

    public function setCookie($referringUserId)
    {
        $cookieName = config('laravel-validation.cookie.name');
        $cookieLifetime = config('laravel-validation.cookie.lifetime');

        if ($referringUserId) {
            Cookie::queue($cookieName, $referringUserId, $cookieLifetime);
        }
    }
}
