<?php

namespace Tech5s\ManagerUser\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class ManagerUserServiceProvider extends ServiceProvider
{
    const CONFIG_KEY_START = 'esystem';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'mgu');
        $this->initRouters();
    }
    
    public function initRouters()
    {
        $routes = glob(__DIR__ . "/../../routes/*.php");
       
        $this->routes(function () use ($routes) {
            foreach ($routes as $route) {
                $name = pathinfo($route)['filename'];
                Route::prefix(self::CONFIG_KEY_START)->middleware('web')->namespace('Tech5s\ManagerUser\Controllers')->group($route);
            }
        });
    }
}
