<?php namespace Olyckne\Pug;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class PugServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Pug', function ($app) {
           return new Pug(new Client);
        });
    }
}