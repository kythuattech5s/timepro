<?php

namespace Tech5s\Promotion;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class Tech5sPromotionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'vh');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/route.php');
        $this->initProviderAlias();
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
}
