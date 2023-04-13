<?php

namespace Galata\LaravelMondayAPI;

use Illuminate\Support\ServiceProvider;
use Galata\LaravelMondayAPI\MondayAPI\Token;
use Galata\LaravelMondayAPI\MondayAPI\MondayBoard;

class MondayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../config/monday.php' => config_path('monday.php')
        ], 'config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->mergeConfigFrom(__DIR__.'/../config/monday.php', 'monday');

        $this->app->bind('monday', function ($app) {
            if(class_exists('\App\Services\MondayBoard')){
                $mondayBoard = new \App\Services\MondayBoard();
            } else {
                $mondayBoard = new MondayBoard();
            }
            $mondayBoard->setToken(new Token(config('monday.monday_token')));

            return $mondayBoard;
        });
    }

    public function provides()
    {
        return ['monday'];
    }
}
