<?php
namespace Tech5s\Notify\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class NotifyServicePovider extends ServiceProvider
{
    const CONFIG_KEY_START = 'nrsc_';

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
        $tables = config(static::CONFIG_KEY_START . 'view');
        if (is_null($tables)) {
            return;
        }

        $newArray = [];
        foreach ($tables as $table => $value) {
            $newArray[$table] = $value;
        }
        $viewSettings = config(static::CONFIG_KEY_START . 'view');

        if (is_null($viewSettings)) {
            return;
        }
        foreach ($viewSettings as $table => $data) {
            $newArray[$table] = $data;
        }
        Config::set(static::CONFIG_KEY_START . 'view', $newArray);
    }

    public function initRouters()
    {
        $routes = glob(__DIR__ . "/../../routes/*.php");
        $this->routes(function () use ($routes) {
            foreach ($routes as $route) {
                $name = pathinfo($route)['filename'];
                Route::prefix(config(static::CONFIG_KEY_START . 'setting.route_prefix') . "/$name")->middleware('web')
                    ->namespace(config(static::CONFIG_KEY_START . 'setting.namespace_controller'))
                    ->group($route);
            }
        });
    }
}
