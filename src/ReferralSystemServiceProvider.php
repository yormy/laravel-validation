<?php

namespace Yormy\LaravelValidation;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yormy\LaravelValidation\Commands\LaravelValidationCommand;
use Yormy\LaravelValidation\Http\Controllers\ReferrerDetailsController;
use Yormy\LaravelValidation\Http\Controllers\ReferrerOverviewController;
use Yormy\LaravelValidation\Providers\EventServiceProvider;

class LaravelValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-validation.php' => config_path('laravel-validation.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views/blade' => base_path('resources/views/vendor/laravel-validation'),
            ], 'blade');

            $this->publishes([
                __DIR__ . '/../resources/views/vue' => base_path('resources/views/vendor/laravel-validation'),
                __DIR__ . '/../resources/assets' => resource_path('assets/vendor/laravel-validation'),
            ], 'vue');

            $this->publishMigrations();

            $this->commands([
                LaravelValidationCommand::class,
            ]);

            $ui_type = 'blade';
        } else {
            $ui_type = 'blade';
            if ("VUE" === config('laravel-validation.ui_type')) {
                $ui_type = 'vue';
            }
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views/'. $ui_type, 'laravel-validation');

        $this->registerGuestRoutes();
        $this->registerUserRoutes();
        $this->registerAdminRoutes();
    }

    private function publishMigrations()
    {
        $migrations = [
            'create_referral_actions_table.php',
            'create_referral_domains_table.php',
            'create_referral_payments_table.php',
            'create_referral_awards_table.php',
            'seed_referral_actions_table.php',
        ];

        $index = 0;
        foreach ($migrations as $migrationFileName) {
            if (! $this->migrationFileExists($migrationFileName)) {
                $sequence = date('Y_m_d_His', time());
                $newSequence = substr($sequence, 0, strlen($sequence) - 2);
                $paddedIndex = str_pad(strval($index), 2, '0', STR_PAD_LEFT);
                $newSequence .= $paddedIndex;
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . $newSequence . '_' . $migrationFileName),
                ], 'migrations');

                $index++;
            }
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-validation.php', 'laravel-validation');
        $this->app->register(EventServiceProvider::class);
    }

    private function registerGuestRoutes()
    {
    }

    private function registerUserRoutes()
    {
        Route::macro('LaravelValidationUser', function (string $prefix) {
            Route::prefix($prefix)->name($prefix. ".")->group(function () {
                Route::get('/details', [ReferrerDetailsController::class, 'show'])->name('show');
            });
        });
    }

    private function registerAdminRoutes()
    {
        //  Route::get('/admin1/ref/details/{referrer}', [ReferrerDetailsController::class, 'showForUser'])->name('shownow');

        Route::macro('LaravelValidationAdmin', function (string $prefix) {
            Route::prefix($prefix)->name($prefix. ".")->group(function () {
                Route::get('/referrers', [ReferrerOverviewController::class, 'index'])->name('overview');
                Route::get('/referrers/{referrer}', [ReferrerDetailsController::class, 'showForUser'])->name('showForUser');
            });
        });
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
