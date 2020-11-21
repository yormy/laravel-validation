<?php

namespace Yormy\LaravelValidation\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Yormy\LaravelValidation\Http\Middleware\ReferrerMiddleware;
use Yormy\LaravelValidation\LaravelValidationServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }
}
