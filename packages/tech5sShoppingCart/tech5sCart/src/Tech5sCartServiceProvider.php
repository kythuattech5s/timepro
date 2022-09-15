<?php

namespace Tech5sShoppingCart\Tech5sCart;

use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class Tech5sCartServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Tech5sCart', 'Tech5sShoppingCart\Tech5sCart\Tech5sCart');
        $config = __DIR__.'/Config/tech5sCart.php';
        $this->mergeConfigFrom($config, 'tech5sCart');

        $this->publishes([__DIR__.'/Config/tech5sCart.php' => config_path('tech5sCart.php')], 'config');

        $this->app['events']->listen(Logout::class, function () {
            if ($this->app['config']->get('tech5sCart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('tech5sCart');
            }
        });
        $this->publishes([
            realpath(__DIR__.'/Database/migrations') => $this->app->databasePath().'/migrations',
        ], 'migrations');
    }
}