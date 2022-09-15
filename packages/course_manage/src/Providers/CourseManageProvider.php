<?php
namespace CourseManage\Providers;

use CourseManage\Listeners\ManagerEventListener;
use Illuminate\Support\ServiceProvider;

class CourseManageProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->events->subscribe(new ManagerEventListener);
        $this->initConfigFile();
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../AdminViews','vh');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/route.php');
    }
    private function initConfigFile()
    {
        $configs = glob(__DIR__ . "/../../config/*.php");
        foreach ($configs as $path) {
            $nameConfig = pathinfo($path)['filename'];
            if ($nameConfig !== 'app') {
                $this->mergeConfigFrom($path, 'sys_' . $nameConfig);
            }
        }
    }
}
