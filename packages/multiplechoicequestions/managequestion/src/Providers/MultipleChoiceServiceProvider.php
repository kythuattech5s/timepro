<?php
namespace multiplechoicequestions\managequestion\Providers;
use Illuminate\Support\ServiceProvider;
class MultipleChoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../AdminViews','vh');
        $this->loadViewsFrom(__DIR__.'/../Views','mtc');
        $this->loadRoutesFrom(__DIR__.'/../Routes/route.php');
    }
}
