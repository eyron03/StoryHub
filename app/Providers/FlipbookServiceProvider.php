<?php

namespace App\Providers;


use App\Services\ElevenLabsService;
use Illuminate\Support\ServiceProvider;
use rudrarajiv\flipbooklaravel\FlipBookController;

class FlipbookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the FlipbookController as a singleton
        $this->app->singleton(FlipbookController::class, function ($app) {
            return new FlipbookController();
        });

        // Register the ElevenLabsService as a singleton
        $this->app->singleton(ElevenLabsService::class, function ($app) {
            return new ElevenLabsService();
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

