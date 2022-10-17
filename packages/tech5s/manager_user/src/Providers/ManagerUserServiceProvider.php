<?php

namespace Tech5s\ManagerUser\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class ManagerUserServiceProvider extends ServiceProvider
{
    const CONFIG_KEY_START = 'tpfc_';
    const CONFIG_ADMIN_KEY = 'sys_';

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
                Route::prefix(config(self::CONFIG_KEY_START . 'setting.route') . '/' . $name)->middleware('web')
                    ->namespace(config(self::CONFIG_KEY_START . 'setting.controller'))
                    ->group($route);
            }
        });
    }
}
