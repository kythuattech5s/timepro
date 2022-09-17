<?php

namespace Tech5s\VideoChapter\Providers;

use Illuminate\Support\ServiceProvider;

class VideoChapterServiceProvider extends ServiceProvider
{
    const VIEW_LINK = 'TVC';
    const CONFIG_ADMIN_KEY = "sys_";
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', self::VIEW_LINK);
        $this->loadRoutesFrom(__DIR__ . '/../../routes/router.php');
        $this->pushConfig();
    }

    private function pushConfig()
    {
        $arrayConfigAdminNeedEdit = ['assets', 'orther_table'];
        foreach ($arrayConfigAdminNeedEdit as $config_table) {
            $configPath = __DIR__ . '/../../config/' . $config_table . '.php';
            $this->mergeConfigFrom($configPath, static::CONFIG_ADMIN_KEY . $config_table);
        }
    }
}
