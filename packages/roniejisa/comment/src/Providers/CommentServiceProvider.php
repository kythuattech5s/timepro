<?php

namespace Roniejisa\Comment\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class CommentServiceProvider extends ServiceProvider
{
    const CONFIG_KEY_START = 'cmrsc_';
    const CONFIG_ADMIN_KEY = 'sys_';

    public function boot()
    {
        // Push config
        $this->initConfigFile();
        // Push view
        $this->loadViewsFrom(__DIR__ . '/../../views', config(static::CONFIG_KEY_START . 'setting.soure_view'));
        // Push Provider Aliast
        // Lưu ý sẽ được khởi tạo sau Provider cuối cùng trong app\config
        $this->initProviderAlias();
        // Push Config muốn ghi đề
        $this->pushConfig();
        // Cài đặt router cho package
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
                \Config::set(static::CONFIG_KEY_START . $nameConfig, include_once $value);
            }
        }
    }

    private function pushConfig()
    {
        $arrayConfigAdminNeedEdit = ['action', 'tab'];
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
                if ($name == 'routes') {
                    $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
                } else {
                    Route::prefix(config(static::CONFIG_KEY_START . 'setting.route_prefix') . "/$name")->middleware('web')
                        ->namespace(config(static::CONFIG_KEY_START . 'setting.namespace_controller'))
                        ->group($route);
                }
            }
        });
    }
}
