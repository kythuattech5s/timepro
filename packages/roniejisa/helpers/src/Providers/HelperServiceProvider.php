<?php

namespace Roniejisa\Helpers\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/manager.php', 'manager');
        $this->initProviderAliasListeners();
    }

    private function initProviderAliasListeners()
    {
        $config = include __DIR__ . "/../../config/app.php";

        foreach ($config['aliases'] as $key => $value) {
            AliasLoader::getInstance()->alias($key, $value);
        }
    }
}
