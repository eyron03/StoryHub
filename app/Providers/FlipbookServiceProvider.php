<?php

namespace App\Providers;

use App\Http\Controllers\FlipbookController;
use Illuminate\Support\ServiceProvider;

class FlipbookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(FlipbookController::class, function ($app) {
            return new FlipBookController();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadViewsFrom(__DIR__.'/views', 'flipbook');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/rudrarajiv/flipbooklaravel'),
        ],'flipview');


            $this->publishes([
                __DIR__.'/../assets' => public_path('/'),
            ], 'flippublic');

            $this->publishes([
                __DIR__.'/../migrations' => database_path('migrations'),
            ], 'flipmigration');

        }

    }

