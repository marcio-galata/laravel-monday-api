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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('monday', function ($app) {
            $token = env('MONDAY_TOKEN');
            $MondayBoard = new Galata\LaravelMondayAPI\MondayAPI\MondayBoard();
            $MondayBoard->setToken(new Galata\LaravelMondayAPI\MondayAPI\Token($token));
        });
    }

    public function provides()
    {
        return ['monday'];
    }
}
