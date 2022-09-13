<?php
namespace CourseManage\Providers;

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
        
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../AdminViews','vh');
    }
}
