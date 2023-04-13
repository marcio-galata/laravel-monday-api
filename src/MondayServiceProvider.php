<?php

namespace Galata\LaravelMondayAPI;

use Illuminate\Support\ServiceProvider;
use TBlack\MondayAPI\Token;
use TBlack\MondayAPI\MondayBoard;

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
            $MondayBoard = new TBlack\MondayAPI\MondayBoard();
            $MondayBoard->setToken(new TBlack\MondayAPI\Token($token));
        };
    }

    public function provides()
    {
        return ['monday'];
    }
}
