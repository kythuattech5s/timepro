<?php

namespace Tech5s\FlashSale\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class FlashSaleServiceProvider extends ServiceProvider
{
    const CONFIG_KEY_START = 'tpfc_';
    const CONFIG_ADMIN_KEY = 'sys_';

    public function boot()
    {
        $this->initConfigFile();
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tpf');
        $this->initProviderAlias();
        $this->pushConfig();
        $this->initRouters();
    }

    private function initProviderAlias()
    {
        $config = include __DIR__ . "/../../config/app.php";
        foreach ($config['providers'] as $key => $value) {
            $this->app->register($value);
        }
        foreach ($config['aliases'] as $key => $value) {
            AliasLoader::getInstance()->alias($key, $value);
        }
        foreach ($config['listeners'] as $listener) {
            Event::subscribe($listener);
        }
    }

    private function initConfigFile()
    {
        $arr = glob(__DIR__ . "/../../config/*.php");
        foreach ($arr as $value) {
            $nameConfig = pathinfo($value)['filename'];
            if ($nameConfig !== 'app') {
                \Config::set(self::CONFIG_KEY_START . $nameConfig, include_once $value);
            }
        }
    }

    private function pushConfig()
    {
        $arrayConfigAdminNeedEdit = ['tab', 'view', 'action', 'orther_table'];
        foreach ($arrayConfigAdminNeedEdit as $config_table) {
            $configPath = __DIR__ . '/../../config/' . $config_table . '.php';
            $this->mergeConfigFrom($configPath, static::CONFIG_ADMIN_KEY . $config_table);
        }
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
