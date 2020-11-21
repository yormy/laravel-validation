<?php

namespace Yormy\LaravelValidation\Tests\Features;

use Illuminate\Support\Facades\Auth;
use Yormy\LaravelValidation\Models\ReferralAction;
use Yormy\LaravelValidation\Models\ReferralAward;

use Yormy\LaravelValidation\Observers\Events\AwardReferrerEvent;
use Yormy\LaravelValidation\Tests\TestCase;

class DetailsTest extends TestCase
{
    /** @test */
    public function dummy()
    {
        $this->assertTrue(true);
    }

}
